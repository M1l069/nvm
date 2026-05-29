<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use SoftDeletes;
    protected function casts(): array
    {
        return [
            'grade_level' => 'integer',
        ];
    }

    public function department():BelongsTo { return $this->belongsTo(Department::class); }
    public function specialization():BelongsTo { return $this->belongsTo(Specialization::class); }

    public function schoolYears()
    {
        return $this->hasMany(SubjectSchoolYear::class);
    }
}
