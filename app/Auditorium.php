<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Auditorium extends Model
{
    public $table = 'auditoriums';

    public function seats(): HasMany
    {
        return $this->hasMany(Seat::class);
    }
}
