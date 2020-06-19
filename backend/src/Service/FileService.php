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

    public function getFile($id) {
    }
}