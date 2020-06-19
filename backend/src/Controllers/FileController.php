<?php
namespace App\Controllers;

use App\Service\FileService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class FileController {

    private $fileService;

    public function __construct(FileService $fileService) {
        $this->fileService = $fileService;
    }

    public function createFile(Request $request, Response $response, $args){
        
    }

    public function deleteFile(Request $request, Response $response, $args){
        var_dump($args);
        return $response;
    }

    public function getFile(Request $request, Response $response, $args){
        $id = $args['fileId'];
        $this->fileService->getFile($id);
        return $response;
    }
}