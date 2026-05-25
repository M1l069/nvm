<?php

namespace App\Enums;

enum EventType: string
{
    case Concert = 'concert';
    case Trip = 'trip';

    public function label(): string {
        return match ($this) {
            self::Concert => 'Koncert',
            self::Trip => 'Výlet'
        };
    }
}
