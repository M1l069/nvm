<?php

namespace App\Enums;

enum GradeType: string
{
    case Continuous = 'continuous';
    case Final = 'final';

    public function label(): string {
        return match ($this) {
            self::Continuous => 'Priebežná známka',
            self::Final => 'Výsledná známka',
        };

    }
}
