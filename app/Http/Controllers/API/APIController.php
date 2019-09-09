<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

use App\Traits\DatabaseInteraction;
use App\Traits\YoutubeAPI;

use App\Models\Music;
use App\Models\Channel;

class APIController extends Controller
{

    use DatabaseInteraction, YoutubeAPI;

    private function updateToken(Request $request)
    {
        $token = Str::random(60);

        $request->user()->forceFill([
            'api_token' => hash('sha256', $token),
        ])->save();

        return ['token' => $token];
    }

    public function addFavoriteChannel(Request $request) {

        if(Channel::where('name', $request->name)->first())
            return [
                'status' => 'warning',
                'msg' => 'Warning : title already exist.'
            ]  ;

        $channel = new Channel;
        $channel->name = $request->name;
        $channel->favorite = true;
        $channel->save();

        return [
            'status' => 'success',
            'msg' => 'Success : new channel added !'
        ];
    }

    public function addMusic(Request $request) {
        
        $new_music = $request->validate([
            'uri' => 'required',
            'category' => 'required',
            'tags' => 'required'
        ]);

        $youtube_data = $this->getInfoFromUri($new_music['uri']);

        if(Music::where('title', $youtube_data['title'])->first())
            return [
                'status' => 'warning',
                'msg' => 'Warning : music already exist.'
            ];

        $this->insertNewMusic([
            'title' => $youtube_data['title'],
            'channel' => $youtube_data['channel'],
            'duration' => $youtube_data['duration'],
            'uri' => $new_music['uri'],
            'category' => $new_music['category'],
            'tag' => $new_music['tags']
        ]);

        return [
            'status' => 'success',
            'msg' => 'Success : new music added !'
        ];
    }
}
