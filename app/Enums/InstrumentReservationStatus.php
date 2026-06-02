<?php

namespace App\Enums;

enum InstrumentReservationStatus: string
{
    case Completed = 'completed';
    case Active = 'active';
    case Overdue = 'overdue';

    public function label(): string {
        return match ($this) {
            self::Completed => 'Ukončená',
            self::Active => 'Aktívna',
            self::Overdue => 'Po termíne'
        };
    }
}
