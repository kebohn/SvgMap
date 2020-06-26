<?php
namespace App\Controllers;

use App\Service\ProjectService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class ProjectController {

    private $projectService;

    public function __construct(ProjectService $projectService) {
        $this->projectService = $projectService;
    }

    public function getProjects(Request $request, Response $response, $args){
        $projects = $this->projectService->getAllProjects();
        $payload = json_encode($projects);
        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

    public function createProject(Request $request, Response $response, $args){
        $name = $request->getHeader('x-project-title')[0];
        $files = $request->getUploadedFiles();
        $data['projectId'] = $this->projectService->createProject($name, $files);
        $payload = json_encode($data);
        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

    public function getProject(Request $request, Response $response, $args){
        $id = $args['projectId'];
        $project = $this->projectService->getProject($id);
        $payload = json_encode($project);
        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

    public function deleteProject(Request $request, Response $response, $args){
        $id = $args['projectId'];
        $this->projectService->deleteProject($id);
        return $response->withStatus(200);
    }

    public function getFile(Rquest $request, Response $response, $args) {
        $projectId = $args['projectId'];
        $fileName = $args['fileName'];
    }
}