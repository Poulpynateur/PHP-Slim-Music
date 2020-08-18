<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public $timestamps = false;
    protected $table = 'tags';
    protected $hidden = ['pivot'];
    
    public function musics() {
        return $this->belongsToMany('App\Note', 'notes_tags', 'tag_id', 'note_id');
    }
}
