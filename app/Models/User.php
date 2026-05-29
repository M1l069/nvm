<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserRole;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;


#[Fillable(['name','username','email', 'password', 'role', 'must_change_password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
            'must_change_password' => 'boolean'
        ];
    }

    public function student():HasOne { return $this->hasOne(Student::class); }
    public function teacher():HasOne { return $this->hasOne(Teacher::class); }
    public function guardian():HasOne { return $this->hasOne(Guardian::class); }

    public function roomReservations(): HasMany
    {
        return $this->hasMany(RoomReservation::class, 'reserved_by');
    }

    public function instrumentReservations():HasMany {
        return $this->hasMany(InstrumentReservation::class, 'reserved_for');
    }

    public function instrumentReservationsFor(): HasMany
    {
        return $this->hasMany(InstrumentReservation::class, 'reserved_by');
    }

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_participants');
    }
}
