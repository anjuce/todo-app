<?php

namespace App\Enums;

enum TaskPriority: string
{
    const LOW = 'low';
    const MEDIUM = 'medium';
    const HIGH = 'high';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
