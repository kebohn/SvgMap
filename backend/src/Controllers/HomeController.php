<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class HomeController {

    public function __invoke(Request $request, Response $response): Response {
        $response->getBody()->write('Use the api under /api');
        return $response;
    }
}
