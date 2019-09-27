<?php

namespace App\Traits;

use App\Models\Channel;
use App\Models\Category;
use App\Models\Music;
use App\Models\Tag;

/**
 * Every database interaction that require special care
 */
trait DatabaseInteraction {

    protected function insertNewMusic($music) {
        $category = Category::firstOrCreate([
            'name' => $music['category']
        ]);
        $channel = Channel::firstOrCreate(
            ['name' => $music['channel']]
        );

        $new_music = Music::create([
            'title' => $music['title'],
            'uri' => $music['uri'],
            'category_id' => $category->id,
            'channel_id' => $channel->id,
            'duration' => $music['duration']
        ]);

        if($music['tags'] !== null) {
            $tag = Tag::firstOrCreate([
                'name' => $music['tag']
            ]);
    
            $new_music->tags()->attach($tag->id);
        }
    }
}