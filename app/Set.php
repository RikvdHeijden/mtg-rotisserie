<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Set extends Model
{
    public function cards()
    {
        return $this->hasMany(Card::class);
    }
}
