<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model {

    protected $table = 'notes';
    protected $hidden = ['pivot'];
    protected $with = ['tags'];

    public function tags() {
        return $this->belongsToMany('App\Tag', 'notes_tags', 'note_id', 'tag_id');
    }

    public function parent()
    {
        return $this->belongsTo('App\Note', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('App\Note', 'parent_id')->orderBy('updated_at', 'desc');
    }
}
