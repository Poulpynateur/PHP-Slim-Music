<?php 

namespace App\Middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class Middleware {
    private $API_key;

    public function __construct($API_key) {
        $this->API_key = $API_key;
    }

    public function __invoke(Request $request, Response $response, callable $next) {

        $authorization = $request->getHeader('Authorization');

        if ($authorization && $this->API_key === $authorization[0]) {
            // authorized, call next middleware
            return $next($request, $response);
        }

        return $response->withStatus(401);
    }
}