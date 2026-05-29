<?php

namespace App\Models;

use App\Enums\EnrollmentState;
use App\Enums\GradeType;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['user_id', 'specialization_id', 'birth_date', 'street', 'city', 'postal_code',
    'country', 'phone_number'])]
class Student extends Model
{
    use SoftDeletes;
    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
        ];
    }

    public function user():BelongsTo { return $this->belongsTo(User::class)->withTrashed(); }
    public function specialization():BelongsTo { return $this->belongsTo(Specialization::class); }

    public function guardians():BelongsToMany
    {
        return $this->belongsToMany(Guardian::class, 'guardian_student');
    }

    public function enrollments():HasMany { return $this->hasMany(SubjectEnrollment::class); }
    public function attendances():HasMany { return $this->hasMany(Attendance::class); }
    public function grades():HasMany { return $this->hasMany(Grade::class); }
    public function bands():BelongsToMany
    {
        return $this->belongsToMany(Band::class, 'band_student');
    }

    public function activeEnrollments()
    {
        return $this->enrollments()->where('state', EnrollmentState::Active);
    }

    public function finalGrades()
    {
        return $this->grades()->where('type', GradeType::Final);
    }
}
