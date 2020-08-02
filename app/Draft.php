<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Draft extends Model
{
    public $fillable = [];

    public function set()
    {
        return $this->belongsTo(Set::class);
    }

    public function players()
    {
        return $this->hasMany(Player::class);
    }

    public function config()
    {
        return [
            'set' => $this->set->config(),
            'players' => $this->players->each(function (Player $player) {
                return $player->config();
            })
        ];
    }
}
