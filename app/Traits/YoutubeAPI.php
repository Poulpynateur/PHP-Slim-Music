<?php

namespace App\Traits;

trait YoutubeAPI {

    protected function getInfoFromUri($uri) {
        $api_url = 'https://www.googleapis.com/youtube/v3/videos?part=snippet%2CcontentDetails%2Cstatistics&id=' . $uri . '&key=' . env('YOUTUBE_API_KEY');
        $response = json_decode(file_get_contents($api_url));

        if($response->items[0]) {
            $duration = new \DateInterval($response->items[0]->contentDetails->duration);
            
            $data['duration'] = $duration->format('%h:%i:%S');
            $data['channel'] = $response->items[0]->snippet->channelTitle;
            $data['title'] = $response->items[0]->snippet->title;
        }

        return $data;
    }

}