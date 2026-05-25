<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TimeSlot extends Model
{
    public function subjectSchoolYear():BelongsTo
    {
        return $this->belongsTo(SubjectSchoolYear::class);
    }
    public function lessons():HasMany { return $this->hasMany(Lesson::class); }
}
