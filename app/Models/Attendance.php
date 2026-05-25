<?php

namespace App\Models;

use App\Enums\AttendanceState;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    protected function casts(): array
    {
        return [
            'state' => AttendanceState::class,
        ];
    }

    public function student():BelongsTo { return $this->belongsTo(Student::class); }
    public function lesson():BelongsTo { return $this->belongsTo(Lesson::class); }

}
