<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    public function set()
    {
        $this->belongsTo(Set::class);
    }

    public function config()
    {
        return [
            'name' => $this->name,
            'text' => $this->text
        ];
    }
}
