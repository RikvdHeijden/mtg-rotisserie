<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = ['set_id',
        'name',
        'text',
        'small_image',
        'normal_image',
        'large_image',
        'colors',
        'cmc',
        'type_line',
        'rarity',
    ];

    public function set()
    {
        $this->belongsTo(Set::class);
    }

    public function config()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'text' => $this->text
        ];
    }
}
