<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name'
    ];

    public function musics()
    {
        return $this->belongsToMany('App\Models\Music', 'music_tag');
    }
}
