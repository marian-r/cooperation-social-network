<?php
/**
 * User: V
 * Date: 2.5.2014
 * Time: 21:56
 */

namespace PA036\SocialNetworkBundle\Tests\Service;

use Doctrine\Common\Persistence\ObjectManager;

abstract class ServiceTestCase extends \Symfony\Bundle\FrameworkBundle\Test\WebTestCase
{

    /**
     * @var ObjectManager
     */
    protected $entityManager;

    protected function setUp()
    {
        $kernel = static::createKernel();
        $kernel->boot();
        $this->entityManager = $kernel->getContainer()->get('doctrine.orm.entity_manager');
        $this->entityManager->beginTransaction();
    }

    /**
     * Rollback changes.
     */
    public function tearDown()
    {
        $this->entityManager->rollback();
    }


}

