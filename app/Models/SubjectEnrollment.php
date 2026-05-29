<?php

namespace App\Models;

use App\Enums\EnrollmentState;
use Illuminate\Database\Eloquent\Model;

class SubjectEnrollment extends Model
{
    protected $casts = [
        'state' => EnrollmentState::class,
        'enrolled_at' => 'date',
        'grade_level' => 'integer',
    ];

    public function student()           { return $this->belongsTo(Student::class); }
    public function subjectSchoolYear() { return $this->belongsTo(SubjectSchoolYear::class); }
}
