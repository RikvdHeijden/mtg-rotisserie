<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Draft extends Model
{
    protected $fillable = ['set_id', 'code', 'password'];

    public function set()
    {
        return $this->belongsTo(Set::class);
    }

    public function players()
    {
        return $this->hasMany(Player::class);
    }

    public function activePlayers()
    {
        return $this->hasMany(Player::class)->whereActive(true);
    }

    public function picks()
    {
        return $this->hasMany(Pick::class);
    }

    public function config()
    {
        return [
            'id' => $this->id,
            'started' => $this->started,
            'code' => $this->code,
            'set' => $this->set->config(),
            'players' => $this->players->each(function (Player $player) {
                return $player->config();
            }),
            'picks' => $this->picks->each(function (Pick $pick) {
                return $pick->config();
            }),
            'activePlayer' => $this->currentPlayer()->id
        ];
    }

    public function proceedToNextPlayer()
    {
        $this->active_player_index = ($this->active_player_index + 1) % ($this->activePlayers()->count() * 2);
        $this->save();
    }

    public function currentPlayer()
    {
        $player_turn_mapping = [];

        foreach ($this->activePlayers as $player) {
            $player_turn_mapping[] = $player;
        }

        $player_turn_mapping = array_merge($player_turn_mapping, array_reverse($player_turn_mapping));

        return $player_turn_mapping[$this->active_player_index];
    }
}
