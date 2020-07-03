<?php
namespace App\Service;

use App\Models\File;
use Doctrine\ORM\EntityManager;
use Selective\Config\Configuration;

class FileService {

    /**
     * @var EntityManager
     */
    private $em;
    /**
     * @var Configuration
     */
    private $configuration;


    public function __construct(EntityManager $em, Configuration $configuration)
    {
        $this->em = $em;
        $this->configuration = $configuration;
    }

    /**
     * @param $projectId
     * @param $fileId
     * @param $fileName
     * @return string
     */
    public function getFile($projectId, $fileId, $fileName) :string {
        $fileRepository = $this->em->getRepository(File::class);
        if ($fileId != null) {
            $file = $fileRepository->find($fileId);
        } else {
            $fileName = preg_replace('/^.+[\\\\\\/]/', '', $fileName);
            $file = $fileRepository->findOneBy(['project' => $projectId, 'name' => utf8_encode($fileName)]);
        }
        $path = $this->configuration->getString('uploads');
        return $path .'/'. $file->getRelPath() .'.'. pathinfo($file->getName(), PATHINFO_EXTENSION);
    }

    public function exchangeFile($fileId, $newFile) {
        try {
            $fileRepository = $this->em->getRepository(File::class);
            $oldFile = $fileRepository->find($fileId);
            $ext = pathinfo($newFile->getClientFilename(), PATHINFO_EXTENSION);

            $newFile->moveTo($this->configuration->getString('uploads').'/'.$oldFile->getRelPath().'.'.$ext);
        } catch(\Exception $e) {
            throw $e;
        }
    }
}