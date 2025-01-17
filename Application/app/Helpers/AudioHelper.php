<?php

declare(strict_types=1);

namespace App\Helpers;

use FFMpeg\FFMpeg;
use FFMpeg\Format\Audio\Aac;
use FFMpeg\Format\Audio\Mp3;
use Illuminate\Http\UploadedFile;

class AudioHelper
{
    private FFMpeg $ffmpeg;

    public function __construct()
    {
        $this->ffmpeg = FFMpeg::create([
            'ffmpeg.binaries'  => config('ffmpeg.ffmpeg_binary', '/usr/bin/ffmpeg'),
            'ffprobe.binaries' => config('ffmpeg.ffprobe_binary', '/usr/bin/ffprobe'),
            'timeout'          => 3600,
            'ffmpeg.threads'   => 12,
        ]);
    }

    public function compress(UploadedFile $file, array $options = []): string
    {
        try {
            $this->validateFile($file);

            $options = array_merge([
                'bitrate'  => 128,
                'format'   => 'mp3',
                'channels' => 2,
            ], $options);

            $tempFilePath = $this->createTempFile($options['format']);
            $audio        = $this->ffmpeg->open($file->getPathname());
            $format       = $this->getFormat($options);

            $format->setAudioChannels($options['channels'])
                ->setAudioKiloBitrate($options['bitrate']);

            $audio->save($format, $tempFilePath);

            if (!file_exists($tempFilePath) || !is_readable($tempFilePath)) {
                throw new \DomainException('Failed to create compressed audio file');
            }

            return $tempFilePath;

        } catch (\Exception $e) {
            throw new \DomainException('Audio compression failed: ' . $e->getMessage());
        }
    }

    private function validateFile(UploadedFile $file): void
    {
        $allowedMimes = ['audio/mpeg', 'audio/mp3', 'audio/wav', 'audio/aac', 'audio/m4a'];

        if (!in_array($file->getMimeType(), $allowedMimes)) {
            throw new \DomainException('Invalid file type. Allowed types: MP3, WAV, AAC, M4A');
        }

        if ($file->getSize() > 100 * 1024 * 1024) {
            throw new \DomainException('File size too large. Maximum size: 100MB');
        }
    }

    private function createTempFile(string $format): string
    {
        return tempnam(sys_get_temp_dir(), 'compressed_audio_') . '.' . $format;
    }

    private function getFormat(array $options)
    {
        return match ($options['format']) {
            'mp3' => new Mp3(),
            'aac' => new Aac(),
            default => throw new \Exception('Unsupported output format'),
        };
    }

    public function cleanup(string $filePath): void
    {
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
}
