<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    public function draft()
    {
        $this->belongsTo(Draft::class);
    }
}
