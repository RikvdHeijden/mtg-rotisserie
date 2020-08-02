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
            }),
            'activePlayer' => $this->players->get($this->active_player_index)->id
        ];
    }

    public function proceedToNextPlayer()
    {
        $this->active_player_index = ($this->active_player_index + 1) % $this->players->count();
        $this->save();
    }
}
