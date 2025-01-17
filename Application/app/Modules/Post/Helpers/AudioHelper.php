<?php

declare(strict_types=1);

namespace App\Modules\Post\Helpers;

use FFMpeg\FFMpeg;
use FFMpeg\Format\Audio\Mp3;
use Illuminate\Http\UploadedFile;

class AudioHelper
{
    public static function compress(UploadedFile $file, int $bitrate = 128): string
    {
        $tempFilePath = tempnam(sys_get_temp_dir(), 'compressed_audio');

        $ffmpeg = FFMpeg::create();
        $audio  = $ffmpeg->open($file->getPathname());

        $format = new Mp3();
        $format->setAudioKiloBitrate($bitrate);

        $audio->save($format, $tempFilePath);

        return $tempFilePath;
    }
}
