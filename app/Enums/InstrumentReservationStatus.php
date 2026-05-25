<?php

namespace App\Enums;

enum InstrumentReservationStatus: string
{
    case Completed = 'Completed';
    case Cancelled = 'Cancelled';
    case Reserved = 'Reserved';

    public function label(): string {
        return match ($this) {
            self::Reserved => 'Rezervované',
            self::Cancelled => 'Zrušená',
            self::Completed => 'Voľné'
        };
    }
}
