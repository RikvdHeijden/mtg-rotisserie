<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Draft extends Model
{
    protected $fillable = ['set_id', 'code'];

    public function set()
    {
        return $this->belongsTo(Set::class);
    }

    public function players()
    {
        return $this->hasMany(Player::class);
    }

    public function picks()
    {
        return $this->hasMany(Pick::class);
    }

    public function config()
    {
        return [
            'id' => $this->id,
            'set' => $this->set->config(),
            'players' => $this->players->each(function (Player $player) {
                return $player->config();
            }),
            'picks' => $this->picks->each(function (Pick $pick) {
                return $pick->config();
            }),
            'activePlayer' => $this->players->get($this->active_player_index)->id
        ];
    }

    public function proceedToNextPlayer()
    {
        $this->active_player_index = ($this->active_player_index + 1) % $this->players->count();
        $this->save();
    }

    public function currentPlayer()
    {
        return $this->players->get($this->active_player_index);
    }
}
