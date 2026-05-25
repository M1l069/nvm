<?php

namespace App\Enums;

enum DayOfTheWeek: string
{
    case Monday = 'Monday';
    case Tuesday = 'Tuesday';
    case Wednesday = 'Wednesday';
    case Thursday = 'Thursday';
    case Friday = 'Friday';

    public function label():string {
        return match ($this) {
            self::Monday => 'Pondelok',
            self::Tuesday => 'Utorok',
            self::Wednesday => 'Streda',
            self::Thursday => 'Štvrtok',
            self::Friday => 'Piatok'
        };
    }
}
