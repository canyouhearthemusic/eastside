<?php

declare(strict_types=1);

namespace App\Modules\Post\Enums;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="StatusResource",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID",
 *         example="1"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Status name",
 *         example="Active"
 *     )
 * )
 */
enum Status: int
{
    case ACTIVE   = 1;
    case INACTIVE = 2;

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): array
    {
        return match ($this) {
            self::ACTIVE   => [
                'id'   => self::ACTIVE->value,
                'name' => 'Active',
            ],
            self::INACTIVE => [
                'id'   => self::INACTIVE->value,
                'name' => 'Inactive',
            ],
        };
    }
}
