<?php


namespace App\Test;


use App\Models\Project;

class DatabaseTest extends BaseTestCase
{

    public function testCreateProject(){
        $project = new Project();
        $project->setName('testProject');
        $this->em->persist($project);
        $this->em->flush();


        $results = $this->em->getRepository(Project::class)->findAll();
        $this->assertEquals(1, $this->count($results));
        $this->assertEquals('testProject', $results[0]->getName());


    }

}