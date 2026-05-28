<?php

namespace App\Models;

use App\Enums\EventType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;

    protected function casts(): array
    {
        return [
            'type' => EventType::class,
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'is_public' => 'boolean',
        ];
    }

    public function room():BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
    public function bands():BelongsToMany
    {
        return $this->belongsToMany(Band::class, 'event_band');
    }
    public function participants():BelongsToMany
    {
        return $this->belongsToMany(User::class, 'event_participants')
            ->withPivot('role', 'note');
    }

}
