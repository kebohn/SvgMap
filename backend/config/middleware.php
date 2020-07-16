<?php

use Slim\App;
use App\Middleware\JwtClaimMiddleware;
use App\Middleware\CorsMiddleware;
use Slim\Middleware\ErrorMiddleware;

return function (App $app) {

    $app->add(JwtClaimMiddleware::class);

    $app->add(CorsMiddleware::class);

    $app->addBodyParsingMiddleware();

    $app->addRoutingMiddleware();

    $app->add(ErrorMiddleware::class);

};