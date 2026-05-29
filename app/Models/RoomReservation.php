<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoomReservation extends Model
{
    protected function casts(): array
    {
        return [
            'from' => 'datetime',
            'to' => 'datetime',
            'status' => 'boolean'
        ];
    }

    public function room():BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
    public function reservedBy():BelongsTo
    {
        return $this->belongsTo(User::class, 'reserved_by');
    }

    public function scopeConflicting($query, $start, $end, $excludeId = null)
    {
        return $query->where('start_at', '<', $end)
            ->where('end_at', '>', $start)
            ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId));
    }


}
