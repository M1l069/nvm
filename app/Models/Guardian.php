<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guardian extends Model
{
    use SoftDeletes;

    public function user():BelongsTo { return $this->belongsTo(User::class); }

    public function students():BelongsToMany {
        return $this->belongsToMany(Student::class, 'guardian_student');
    }

}
