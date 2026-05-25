<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Specialization extends Model
{
    use SoftDeletes;

    public function department():BelongsTo { return $this->belongsTo(Department::class); }
    public function students():HasMany { return $this->hasMany(Student::class); }
    public function teachers():HasMany { return $this->hasMany(Teacher::class); }
    public function subjects():HasMany { return $this->hasMany(Subject::class); }
    public function instruments():HasMany { return $this->hasMany(Instrument::class); }
}
