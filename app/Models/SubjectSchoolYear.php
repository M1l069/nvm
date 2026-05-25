<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubjectSchoolYear extends Model
{
    use SoftDeletes;

    public function subject():BelongsTo { return $this->belongsTo(Subject::class); }
    public function schoolYear():BelongsTo { return $this->belongsTo(SchoolYear::class); }
    public function teacher():BelongsTo { return $this->belongsTo(Teacher::class); }

    public function timeSlots():HasMany { return $this->hasMany(TimeSlot::class); }
    public function lessons():HasMany { return $this->hasMany(Lesson::class); }
    public function enrollments():HasMany { return $this->hasMany(SubjectEnrollment::class); }
    public function grades():HasMany { return $this->hasMany(Grade::class); }
    public function gradeEvents():HasMany { return $this->hasMany(GradeEvent::class); }

    public function students()
    {
        return $this->hasManyThrough(
            Student::class,
            SubjectEnrollment::class,
            'subject_school_year_id',
            'id',
            'id',
            'student_id'
        );
    }
}
