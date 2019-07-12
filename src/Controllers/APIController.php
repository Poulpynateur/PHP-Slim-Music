<?php

namespace App\Controllers;

use Exception;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class APIController {

    protected $API_KEY;

    public function __construct($API_KEY) {
        $this->API_KEY = $API_KEY;
    }

    private function getURLid($url) {
        $parts = parse_url($url);
        if(array_key_exists('query', $parts) == false)
            return null;

        parse_str($parts['query'], $query);
        return $query['v'];
    }

    private function getAPIinfo($id, $data) {
        $api_url = 'https://www.googleapis.com/youtube/v3/videos?part=snippet%2CcontentDetails%2Cstatistics&id=' . $id . '&key=' . $API_KEY;
        $info = json_decode(file_get_contents($api_url));

        if($info->items[0]) {
            $interval = new \DateInterval($info->items[0]->contentDetails->duration);
            $interval = ($interval->h)? $interval->format('%h:%i:%S') : $interval->format('%i:%S');
            
            $data['thumbnail'] = 'https://img.youtube.com/vi/'.$id.'/default.jpg';
            $data['duration'] = $interval;
            $data['channel'] = $info->items[0]->snippet->channelTitle;
            $data['title'] = $info->items[0]->snippet->title;
        }

        return $data;
    }

//public:
    public function addMusic(Request $request, Response $response, $args) {
        try {
            $json = $request->getBody();
            $data = json_decode($json, true);

            if(!array_key_exists('type', $data) || !array_key_exists('title', $data) || !array_key_exists('uri', $data))
                throw new Exception('Invalide format : missing key.');

            $strJsonFileContents = file_get_contents(__DIR__."/../../ressources/musics.json");
            $musics = json_decode($strJsonFileContents, true);

            //Should check the data validity, but meh
            foreach($musics as &$folder) {
                if($folder['title'] == $data['type']) {
                    unset($data['type']);

                    $id = $this->getURLid($data['uri']);
                    if($id)
                        $data = $this->getAPIinfo($id, $data);

                    array_push($folder['children'], $data);
                    break;
                }
            }
        
            file_put_contents(__DIR__.'/../../ressources/musics.json', json_encode($musics));

            return $response->withStatus(200);
        }
        catch (Exception $e) {
            return $response->withStatus(500);
        }

    }
}