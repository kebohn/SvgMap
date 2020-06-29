<?php
namespace App\Controllers;

use App\Service\FileService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\Stream;


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
        $projectId = $args['projectId'];
        $fileId = $args['fileId'];
        $fileName = $request->getHeader('fileName')[0];
        $file = $this->fileService->getFile($projectId, $fileId, $fileName);
        $openFile = fopen($file, 'rb');
        $stream = new Stream($openFile);
        return $response->withStatus(200)
            ->withHeader('Content-Type', 'application/'.pathinfo($file, PATHINFO_EXTENSION))
            ->withHeader('Content-Description', 'File Transfer')
            ->withHeader('Content-Transfer-Encoding', 'binary')
            ->withHeader('Content-Disposition', 'attachment; filename="' . basename($file) . '"')
            ->withHeader('Expires', '0')
            ->withHeader('Content-Length', filesize($file))
            ->withHeader('Cache-Control', 'must-revalidate')
            ->withHeader('Pragma', 'public')
            ->withBody($stream);
    }
}