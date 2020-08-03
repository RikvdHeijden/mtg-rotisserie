<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pick extends Model
{
    protected $fillable = ['card_id', 'player_id', 'draft_id'];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function draft()
    {
        return $this->belongsTo(Draft::class);
    }

    public function card()
    {
        return $this->belongsTo(Card::class);
    }

    public function config()
    {
        return [
            'player' => $this->player->config(),
            'card' => $this->player->id,
        ];
    }
}
