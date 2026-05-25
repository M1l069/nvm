<?php

namespace App\Enums;

enum EnrollmentState:string
{
    case Active = 'active';
    case Interrupted = 'interrupted';
    case Finished = 'finished';
    case Withdrawn = 'withdrawn';

    public function label():string {
        return match ($this) {
            self::Active => 'Aktívny',
            self::Interrupted => 'Prerušený',
            self::Finished => 'Ukončený',
            self::Withdrawn => 'Odhlásený'
        };
    }


}
