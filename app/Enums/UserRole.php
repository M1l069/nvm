<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case Student = 'student';
    case Teacher = 'teacher';
    case Parent = 'guardian';

    public function label(): string
    {
        return match($this) {
            self::Admin    => 'Administrátor',
            self::Student  => 'Žiak/čka',
            self::Teacher  => 'Učiteľ/ka',
            self::Parent => 'Zákonný zástupca',
        };
    }
}
