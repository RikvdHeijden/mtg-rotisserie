<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = ['name', 'draft_id', 'admin'];
    public function draft()
    {
        return $this->belongsTo(Draft::class);
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
            'admin' => $this->admin,
            'active' => $this->active,
        ];
    }
}
