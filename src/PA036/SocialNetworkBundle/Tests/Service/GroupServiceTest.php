<?php
/**
 * User: V
 * Date: 2.5.2014
 * Time: 20:44
 */
namespace PA036\SocialNetworkBundle\Tests\Service;

use PA036\SocialNetworkBundle\Entity\Group;
use PA036\SocialNetworkBundle\Service\GroupService;
use PA036\AccountBundle\Entity\User;

class GroupServiceTest extends ServiceTestCase
{

    public function testAddGroup(){
        $entityManager = $this->entityManager;

        $user1 = new User();
        $user1->setEmail('test@test.test');
        $user1->setFirstName('test');
        $user1->setLastName('test');
        $user1->setPassword('random');
        $user1->setLastLogin(new \DateTime(date('Y-m-d H:i:s')));

        $entityManager->persist($user1);
        $entityManager->flush();

        $group1 = new Group();
        $group1->setName('testing group');
        $group1->setDescription('lorem ipsum');

        $service = new GroupService($entityManager);
        $group1 = $service->addGroup($group1, $user1);

        $this->assertNotEquals(null, $group1);
        if($group1){
            $this->assertNotEquals(0, $group1->getGroupId());
            $this->assertEquals('testing group', $group1->getName());
        }
    }

    public function testJoinGroup(){
        $entityManager = $this->entityManager;

        $user1 = new User();
        $user1->setEmail('test1@test.test');
        $user1->setFirstName('test');
        $user1->setLastName('test');
        $user1->setPassword('random');
        $user1->setLastLogin(new \DateTime(date('Y-m-d H:i:s')));

        $entityManager->persist($user1);

        $group1 = new Group();
        $group1->setName('testing1 group');
        $group1->setDescription('lorem ipsum');

        $entityManager->persist($group1);
        $entityManager->flush();

        $service = new GroupService($entityManager);
        $service->joinGroup($group1, $user1);

        $this->assertNotEquals(0, $group1->getGroupId());
        $this->assertNotEquals(0, $user1->getUserId());


        $groupMemberShip = $entityManager->find('PA036\SocialNetworkBundle\Entity\UserGroupMap',
            array('group' => $group1->getGroupId(), 'user' => $user1->getUserId()));

        $this->assertNotEquals(null, $groupMemberShip);
    }

    public function testLeaveGroup(){
        $entityManager = $this->entityManager;

        $user1 = new User();
        $user1->setEmail('test2@test.test');
        $user1->setFirstName('test');
        $user1->setLastName('test');
        $user1->setPassword('random');
        $user1->setLastLogin(new \DateTime(date('Y-m-d H:i:s')));

        $entityManager->persist($user1);

        $group1 = new Group();
        $group1->setName('testing2 group');
        $group1->setDescription('lorem ipsum');

        $entityManager->persist($group1);
        $entityManager->flush();

        $service = new GroupService($entityManager);
        $service->joinGroup($group1, $user1);

        $this->assertNotEquals(0, $group1->getGroupId());
        $this->assertNotEquals(0, $user1->getUserId());

        $groupMemberShip = $entityManager->find('PA036\SocialNetworkBundle\Entity\UserGroupMap',
            array('group' => $group1->getGroupId(), 'user' => $user1->getUserId()));

        $this->assertNotEquals(null, $groupMemberShip);

        $service->leaveGroup($group1, $user1);

        $entityManager->refresh($groupMemberShip);
        $entityManager->detach($groupMemberShip);

        $groupMemberShip = $entityManager->find('PA036\SocialNetworkBundle\Entity\UserGroupMap',
            array('group' => $group1->getGroupId(), 'user' => $user1->getUserId()));

        $this->assertEquals(null, $groupMemberShip);
    }
}
