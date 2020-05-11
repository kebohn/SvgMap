<?php
namespace App\Service;

use Doctrine\ORM\EntityManager;
class ProjectService {


    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function createProject() {
       
    }

}