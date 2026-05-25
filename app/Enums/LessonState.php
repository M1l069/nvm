<?php

namespace App\Enums;

enum LessonState: string
{
    case Planned = 'Planned';
    case Ongoing = 'Ongoing';
    case Completed = 'Completed';

    public function label(): string {
        return match($this) {
            self::Planned    => 'Plánovaná',
            self::Ongoing  => 'Prebiehajúca',
            self::Completed  => 'Odučená',
        };
    }
}
