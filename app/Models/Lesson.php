<?php

namespace App\Models;

use App\Enums\LessonState;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lesson extends Model
{
    use SoftDeletes;

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'state' => LessonState::class,
        ];
    }

    public function subjectSchoolYear():BelongsTo
    {
        return $this->belongsTo(SubjectSchoolYear::class);
    }

    public function room():BelongsTo { return $this->belongsTo(Room::class); }
    public function timeSlot():BelongsTo { return $this->belongsTo(TimeSlot::class); }
    public function attendances():HasMany { return $this->hasMany(Attendance::class); }
    public function grades():HasMany { return $this->hasMany(Grade::class); }
    public function gradeEvents():HasMany { return $this->hasMany(GradeEvent::class); }

}
