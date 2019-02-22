<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Seat extends Model
{
    public function auditorium(): BelongsTo
    {
        return $this->belongsTo(Auditorium::class);
    }
}
