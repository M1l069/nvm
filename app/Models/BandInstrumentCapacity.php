<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BandInstrumentCapacity extends Model
{
    protected $table = 'band_instrument_capacity';

    protected function casts(): array
    {
        return [
            'count' => 'integer',
        ];
    }
}
