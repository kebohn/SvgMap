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
}