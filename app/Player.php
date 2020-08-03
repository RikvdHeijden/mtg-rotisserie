<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    public function draft()
    {
        $this->belongsTo(Draft::class);
    }

    public function picks()
    {
        return $this->hasMany(Pick::class);
    }

    public function config()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
