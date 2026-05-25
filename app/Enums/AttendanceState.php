<?php

namespace App\Enums;

enum AttendanceState:string
{
    case Present = 'present';
    case Absent = 'absent';
    case Excused = 'excused';
}
