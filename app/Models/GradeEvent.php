<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class GradeEvent extends Model
{
    use SoftDeletes;

    public function subjectSchoolYear():BelongsTo
    {
        return $this->belongsTo(SubjectSchoolYear::class);
    }

    public function lesson():BelongsTo { return $this->belongsTo(Lesson::class); }
    public function grades():HasMany { return $this->hasMany(Grade::class); }


}
