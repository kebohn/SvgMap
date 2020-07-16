<?php

use App\Auth\JwtAuth;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Selective\Config\Configuration;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Middleware\ErrorMiddleware;


return [
    Configuration::class => function () {
        return new Configuration(require __DIR__ . '/settings.php');
    },

    App::class => function (ContainerInterface $container) {
        AppFactory::setContainer($container);
        $app = AppFactory::create();
        return $app;
    },

    ErrorMiddleware::class => function (ContainerInterface $container) {
        $app = $container->get(App::class);
        $settings = $container->get(Configuration::class)->getArray('error_handler_middleware');

        return new ErrorMiddleware(
            $app->getCallableResolver(),
            $app->getResponseFactory(),
            (bool)$settings['display_error_details'],
            (bool)$settings['log_errors'],
            (bool)$settings['log_error_details']
        );
    },

    'db' => function(ContainerInterface $container) {
        $settings = $container->get(Configuration::class)->getArray('doctrine');
        $config = Setup::createAnnotationMetadataConfiguration(
            $settings['metadata_dirs'],
            $settings['dev_mode'],
            null,
            null,
            false
        );
        return EntityManager::create($settings['connection'], $config);
    },

    EntityManager::class => function(ContainerInterface $c){
        return $c->get('db');
    },

    ResponseFactoryInterface::class => function (ContainerInterface $container) {
        return $container->get(App::class)->getResponseFactory();
    },

    JwtAuth::class => function (ContainerInterface $container) {
        $config = $container->get(Configuration::class)->getArray('jwt');
        $issuer = (string)$config['issuer'];
        $lifetime = (int)$config['lifetime'];
        $privateKey = (string)$config['private_key'];
        $publicKey = (string)$config['public_key'];
        return new JwtAuth($issuer, $lifetime, $privateKey, $publicKey);
    },
];
