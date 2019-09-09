<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Music extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'uri', 'channel_id', 'category_id', 'duration', 'type'
    ];

    public function getYoutubeUrl() {
        return 'https://www.youtube.com/watch?v='.$this->uri;
    }
    public function getYoutubeThumbnail() {
        return 'https://img.youtube.com/vi/'.$this->uri.'/mqdefault.jpg';
    }
    public function getYoutubeThumbnailHD() {
        return 'https://img.youtube.com/vi/'.$this->uri.'/maxresdefault.jpg';
    }
    public function getYoutubeThumbnailLow() {
        return 'https://img.youtube.com/vi/'.$this->uri.'/1.jpg';
    }

    public function scopeByTag($query, $tag_name) {
        return $query->whereHas('tags', function ($q) use ($tag_name) {
            $q->where('name', $tag_name);
        })->get();
    }

    public function channel()
    {
        return $this->belongsTo('App\Models\Channel');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag', 'music_tag');
    }
}