<?php 

namespace App\Controllers;
use \Slim\Views\Twig as View;

class Controller {
    protected $renderer;
    public function __construct(View $renderer) {
        $this->renderer = $renderer;
    }
}