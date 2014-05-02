<?php
/**
 * User: V
 * Date: 2.5.2014
 * Time: 21:56
 */

namespace PA036\SocialNetworkBundle\Tests\Service;

abstract class ServiceTestCase extends \Symfony\Bundle\FrameworkBundle\Test\WebTestCase
{

    protected $_em;

    protected function setUp()
    {
        $kernel = static::createKernel();
        $kernel->boot();
        $this->_em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
        $this->_em->beginTransaction();
    }

    /**
     * Rollback changes.
     */
    public function tearDown()
    {
        $this->_em->rollback();
    }


}

