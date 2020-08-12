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
            'text' => $this->text,
            'small_image' => $this->small_image,
            'normal_image' => $this->normal_image,
            'large_image' => $this->large_image,
            'colors' => $this->colors,
            'cmc' => $this->cmc,
            'type_line' => $this->type_line,
            'rarity' => $this->rarity,
        ];
    }
}
