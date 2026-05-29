<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
#[Fillable(['user_id', 'phone_number'])]
class Teacher extends Model
{
    use SoftDeletes;

    public function user():BelongsTo { return $this->belongsTo(User::class); }
    public function specialization():BelongsTo { return $this->belongsTo(Specialization::class); }
    public function subjectSchoolYears():HasMany
    {
        return $this->hasMany(SubjectSchoolYear::class);
    }

    public function grades():HasMany { return $this->hasMany(Grade::class); }
    public function bands():HasMany { return $this->hasMany(Band::class); }

}
