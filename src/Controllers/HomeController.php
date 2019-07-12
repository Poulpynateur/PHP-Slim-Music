<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class HomeController extends Controller{

    private function loadFromJSON() {
        $strJsonFileContents = file_get_contents(__DIR__."/../../ressources/musics.json");
        $folders = json_decode($strJsonFileContents, true);
        return $folders;
    }

    public function __invoke(Request $request, Response $response) {
        $folders = $this->loadFromJSON();
            
        return $this->renderer->render($response, 'home.twig',
        [
            'folders' => $folders
        ]);
    }
}