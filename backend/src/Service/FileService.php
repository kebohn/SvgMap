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
     * @param $id
     * @return string
     */
    public function getFile($id) {
        $fileRepository = $this->em->getRepository(File::class);
        $file = $fileRepository->find($id);
        $path = $this->configuration->getString('uploads');
        return $path .'/'. $file->getRelPath() .'.'. pathinfo($file->getName(), PATHINFO_EXTENSION);
    }

    public function replaceFile($id, $fileContent) {
        $fileRepository = $this->em->getRepository(File::class);
        $file = $fileRepository->find($id);
        $fileName = $this->configuration->getString('uploads') . '/' . $file->getRelPath() . '.'. pathinfo($file->getName(), PATHINFO_EXTENSION);
        if (file_exists($fileName) && ($f = fopen($fileName,'w'))) {
            fwrite($f,$fileContent);
            fclose($f);
            return 200;
        } else {
            return 500;
        }
    }
}