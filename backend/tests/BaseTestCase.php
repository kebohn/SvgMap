<?php


namespace App\Test;

use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;



class BaseTestCase extends TestCase
{

    /**
     * @var \DI\Container
     */
    static $container;

    /**
     * @var EntityManager
     */
    protected $em;

    public static function setupBeforeClass(): void  {

        $app = require __DIR__. '/../config/bootstrap.php';
        self::$container = $app->getContainer();

        echo "Setting up BaseTestCase \n";
    }
    public function setUp(): void
    {
        parent::setUp();
        $this->em = self::$container->get(EntityManager::class);
        $this->em->beginTransaction();
    }

    public function tearDown(): void
    {
        parent::tearDown();
        $this->em->rollback();

    }

}