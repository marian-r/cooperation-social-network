<?php
/**
 * User: V
 * Date: 2.5.2014
 * Time: 20:44
 */
namespace PA036\SocialNetworkBundle\Tests\Service;


class GroupServiceTest extends \PHPUnit_Framework_TestCase
{

    public function testAddGroup(){
        $entityManager = $this->getMockBuilder('\Doctrine\Common\Persistence\ObjectManager')
            ->disableOriginalConstructor()
            ->getMock();

    }
}
