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

    }

    public function createProject(Request $request, Response $response, $args){
        
    }

    public function getProject(Request $request, Response $response, $args){
        
    }

    public function deleteProject(Request $request, Response $response, $args){
        
    }

    public function createFile(Request $request, Response $response, $args){
        
    }

    public function deleteFile(Request $request, Response $response, $args){
        var_dump($args);
        return $response;
    }
}