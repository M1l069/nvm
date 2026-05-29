<?php

namespace App\Models;

use App\Enums\GradeType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grade extends Model
{
    use SoftDeletes;
    protected function casts(): array {
        return [
            'type' => GradeType::class,
            'graded_at' => 'datetime'
        ];
    }

    public function student():BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
    public function teacher():BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }
    public function subjectSchoolYear():BelongsTo
    {
        return $this->belongsTo(SubjectSchoolYear::class);
    }
    public function lesson():BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }
    public function gradeEvent():BelongsTo
    {
        return $this->belongsTo(GradeEvent::class);
    }
}
