<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name', 'favorite'
    ];

    protected $attributes = [
        'favorite' => false,
    ];

    public function musics()
    {
        return $this->hasMany('App\Models\Music');
    }
}
