<?php

namespace App\Repositories;

use App\Models\Project;
use Doctrine\ORM\EntityRepository;

class ProjectRepository extends EntityRepository {

    public function findAllProjectsDesc() {
        $qb = $this->getEntityManager()->createQueryBuilder();
        return $qb->select('p.id', 'p.name', 'p.generatedName' )
            ->from(Project::class,'p')
            ->orderBy('p.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
}