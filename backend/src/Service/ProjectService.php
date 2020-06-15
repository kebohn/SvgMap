<?php
namespace App\Service;

use App\Models\File;
use App\Models\Project;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Psr\Http\Message\UploadedFileInterface;
use Selective\Config\Configuration;

class ProjectService {


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
     * @param $name string
     * @param $files UploadedFileInterface[][]
     * @throws \Exception
     */
    public function createProject($name, $files) {

        $uploadDir = $this->configuration->getString('uploads');
        $project = new Project($name);
        if (!file_exists($uploadDir.'/'.$project->getGeneratedName())){
            if(mkdir($uploadDir.'/'.$project->getGeneratedName())){
                chmod($uploadDir.'/'.$project->getGeneratedName(), 0777);
                try {
                    $this->em->beginTransaction();
                    $this->em->persist($project);

                    foreach ($files['files'] as $uploadedFile) { // form input name is  'files'
                        $file = new File($uploadedFile->getClientFilename());
                        $pi = pathinfo($uploadedFile->getClientFilename());
                        $ext = $pi['extension'];
                        $uploadedFile->moveTo($uploadDir.'/'.$project->getGeneratedName().'/'.$file->getGeneratedName().'.'.$ext);

                        $file->setProject($project);
                        $this->em->persist($file);
                    }

                    $this->em->flush();
                    $this->em->commit();

                } catch (\Exception $e) {
                    $this->em->rollback();
                    // TODO remove created directory and files uploadDir.'/'. $project->getGeneratedName().
                    throw $e;
                }
            }
            else {
                throw new \Exception('Could not create project directory');
            }
        }
        else {
            throw new \Exception('äretry');
        }
    }

}