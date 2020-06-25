<?php
declare(strict_types = 1);
use App\Controllers\FileController;
use App\Controllers\HomeController;
use App\Controllers\ProjectController;
use App\Models\User;
use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

return function (App $app) {

    $app->get('/', HomeController::class);

    $app->get('/users/create', function (Request $request, Response $response) {
        $user = new User();
        $user->setName("kevin5");
        $this->get('db')->persist($user);
        $this->get('db')->flush();
        return $response;
    });

    $app->get('/users', function (Request $request, Response $response) {
        $users = $this->get('db')->getRepository(User::class)->findAll();
        var_dump($users);
        die();
    });

    $app->get('/swagger', function (Request $request, Response $response) {
        $openapi = \OpenApi\scan(__DIR__);
        $doc =  $openapi->toYaml();
        $response->getBody()->write($doc);
        return $response->withHeader("Content-Type", "application/x-yaml");
    });


    /**
     * @OA\Info(title="My First API", version="0.1")
     */
    $app->group('/api', function ($group) {
        $group->get('', function ($request, $response) {
            $response->getBody()->write('Hello api');
            return $response;
        });
        /**
         * @OA\Get(
         *     path="/api/test",
         *     @OA\Response(response="200", description="An example resource")
         * )
         */
        $group->get('/test', function (Request $request, Response $response) {
            $response->getBody()->write('Hello test');
            return $response;
        });

        $group->get('/projects', ProjectController::class . ':getProjects');
        $group->post('/projects', ProjectController::class . ':createProject');
        $group->get('/projects/{projectId}', ProjectController::class . ':getProject');
        $group->delete('/projects/{projectId}', ProjectController::class . ':deleteProject');

        $group->get('/files/{fileId}', FileController::class . ':getFile');
        $group->post('/files/replace/{fileId}', FileController::class . ':replaceFile');
        $group->post('/files/{projectId}', FileController::class . ':createFile');
        $group->delete('/files/{fileId}', FileController::class . ':deleteFile');
    });
};
