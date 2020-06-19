<?php

namespace App\Models;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Entity(repositoryClass="App\Repositories\ProjectRepository")
 * @ORM\Table(name="project")
 */
class Project {
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;


    /**
     * @var string
     * @ORM\Column(type="string")
     * do not trust user provided name!!!
     */
    private $generatedName;

    /**
     * @return string
     */
    public function getGeneratedName(): string
    {
        return $this->generatedName;
    }

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var File[]
     * @ORM\OneToMany(targetEntity="File", mappedBy="project")
     */
    private $files;

    /**
     * @return File[]
     */
    public function getFiles() : array
    {
        return $this->files->toArray();
    }

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->generatedName = uniqid();
        $this->name = $name;
        $this->files = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getRelPath()
    {
        return $this->getId();
    }
}