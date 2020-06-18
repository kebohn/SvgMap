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
                    $this->deleteDirectory($uploadDir.'/'.$project->getGeneratedName());
                    throw $e;
                }
            }
            else {
                throw new \Exception('Could not create project directory');
            }
        }
        else {
            throw new \Exception('retry');
        }
    }

    /**
     * @param $id
     * @throws ORMException
     */
    public function deleteProject($id) {
        try {
            $projectRepository = $this->em->getRepository(Project::class);
            $project = $projectRepository->find($id);
            $generatedName = $project->getGeneratedName();
            $this->em->remove($project);
            $this->em->flush();
            $this->deleteDirectory($this->configuration->getString('uploads').'/'.$generatedName);
        } catch (ORMException $e) {
            $this->em->rollback();
            throw $e;
        }
    }

    /**
     * @param $str
     * @return bool
     */
    public function deleteDirectory($str) {
            if (is_file($str)) {
                return unlink($str);
            }
            elseif (is_dir($str)) {
                $files = glob(rtrim($str, '/').'/*');
                foreach($files as $file) {
                    $this->deleteDirectory($file);
                }
                return @rmdir($str);
            } else {
                return false;
            }
    }

    /**
     * @param $id
     * @return array
     */
    public function getProject($id) {
        $projectRepository = $this->em->getRepository(Project::class);
        $project = $projectRepository->find($id);
        /*
        $files = $project->getFiles();
        foreach($files as $file) {
            $tmpFile = [
            'id' => $project->getId(),
            'generatedName' => $project->getGeneratedName(),
            'name' => $project->getName()
        ];
        }*/
        return [
            'id' => $project->getId(),
            'generatedName' => $project->getGeneratedName(),
            'name' => $project->getName(),
            'files' => $project->getFiles()
            ];
    }

    public function getAllProjects() {
        $projectRepository = $this->em->getRepository(Project::class);
        return $projectRepository->findAllProjectsDesc();
    }
}