<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['name', 'description', 'responsible_teacher_id'])]
class Department extends Model
{
    use SoftDeletes;


    public function specializations(): HasMany
    {
        return $this->hasMany(Specialization::class);
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function responsibleTeacher():BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'responsible_teacher_id');
    }

    public function activate(Teacher $teacher): void
    {
        $this->update(['responsible_teacher_id' => $teacher->id]);
    }

}
