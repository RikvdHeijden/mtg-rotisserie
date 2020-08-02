<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Set extends Model
{
    public function cards()
    {
        return $this->hasMany(Card::class);
    }

    public function config()
    {
        return [
            'name' => $this->name,
            'cards' => $this->cards->each(function (Card $card) {
                return $card->config();
            })
        ];
    }
}
