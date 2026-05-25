<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Band extends Model
{
    use SoftDeletes;

    public function teacher():BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }
    public function students():BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'band_student');
    }
    public function events():BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_band');
    }
}
