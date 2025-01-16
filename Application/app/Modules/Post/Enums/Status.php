<?php

declare(strict_types=1);

namespace App\Modules\Post\Enums;

enum Status: int
{
    case INACTIVE = 0;
    case ACTIVE   = 1;

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): array
    {
        return match ($this) {
            self::INACTIVE => [
                'id'   => self::INACTIVE->value,
                'name' => 'Inactive',
            ],
            self::ACTIVE   => [
                'id'   => self::ACTIVE->value,
                'name' => 'Active',
            ],
        };
    }
}
