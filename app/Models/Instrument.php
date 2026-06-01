<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['manufacturer', 'model_name','serial_number','specialization_id', 'room_id', 'is_available'])]
class Instrument extends Model
{
    protected function casts(): array
    {
        return [
            'is_available' => 'boolean',
        ];
    }

    public function specialization():BelongsTo
    {
        return $this->belongsTo(Specialization::class);
    }
    public function room():BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
    public function instrumentReservations():HasMany
    {
        return $this->hasMany(InstrumentReservation::class);
    }

}
