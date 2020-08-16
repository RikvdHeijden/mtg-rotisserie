<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = ['name', 'draft_id'];
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
            'active' => $this->active,
        ];
    }
}
