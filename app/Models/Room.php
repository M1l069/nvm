<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use SoftDeletes;

    public function roomReservations():HasMany
    {
        return $this->hasMany(RoomReservation::class);
    }
    public function lessons():HasMany { return $this->hasMany(Lesson::class); }
    public function instruments():HasMany { return $this->hasMany(Instrument::class); }
    public function events():HasMany { return $this->hasMany(Event::class); }
}
