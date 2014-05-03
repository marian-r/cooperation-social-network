<?php
/**
 * User: V
 * Date: 3.5.2014
 * Time: 11:32
 */
namespace PA036\SocialNetworkBundle\Tests\Service;

use PA036\SocialNetworkBundle\Service\PostService;
use PA036\SocialNetworkBundle\Entity\ConversationMember;
use PA036\SocialNetworkBundle\Entity\Conversation;
use PA036\SocialNetworkBundle\Service\MessageService;
use PA036\SocialNetworkBundle\Entity\Group;
use PA036\AccountBundle\Entity\User;
use PA036\SocialNetworkBundle\Entity\Post;

class MessageServiceTest extends ServiceTestCase
{


    public function testStartConversation()
    {
        $entityManager = $this->entityManager;

        $user1 = new User();
        $user1->setEmail('test1@test.test');
        $user1->setFirstName('test');
        $user1->setLastName('test');
        $user1->setPassword('random');
        $user1->setLastLogin(new \DateTime(date('Y-m-d H:i:s')));
        $entityManager->persist($user1);

        $user2 = new User();
        $user2->setEmail('test2@test.test');
        $user2->setFirstName('test');
        $user2->setLastName('test');
        $user2->setPassword('random');
        $user2->setLastLogin(new \DateTime(date('Y-m-d H:i:s')));
        $entityManager->persist($user2);

        $user3 = new User();
        $user3->setEmail('test3@test.test');
        $user3->setFirstName('test');
        $user3->setLastName('test');
        $user3->setPassword('random');
        $user3->setLastLogin(new \DateTime(date('Y-m-d H:i:s')));
        $entityManager->persist($user3);

        $entityManager->flush();

        $service = new MessageService($entityManager);

        $conversation = $service->startConversation($user1, array($user2, $user3), 'an important conversation', 'random conversation name');

        $this->assertNotEquals(null, $conversation);
        if ($conversation) {
            $this->assertNotEquals(0, $conversation->getConversationId());
            $this->assertEquals('random conversation name', $conversation->getName());
            $this->assertEquals(3, count($conversation->getMembers()));
        }
    }

    public function testAddUsersToConversation()
    {
        $entityManager = $this->entityManager;

        $conversation = new Conversation();
        $conversation->setName('a conversation');
        $entityManager->persist($conversation);

        $user1 = new User();
        $user1->setEmail('test3@test.test');
        $user1->setFirstName('test');
        $user1->setLastName('test');
        $user1->setPassword('random');
        $user1->setLastLogin(new \DateTime(date('Y-m-d H:i:s')));
        $entityManager->persist($user1);

        $user2 = new User();
        $user2->setEmail('test4@test.test');
        $user2->setFirstName('test');
        $user2->setLastName('test');
        $user2->setPassword('random');
        $user2->setLastLogin(new \DateTime(date('Y-m-d H:i:s')));
        $entityManager->persist($user2);

        $user3 = new User();
        $user3->setEmail('test5@test.test');
        $user3->setFirstName('test');
        $user3->setLastName('test');
        $user3->setPassword('random');
        $user3->setLastLogin(new \DateTime(date('Y-m-d H:i:s')));
        $entityManager->persist($user3);

        $entityManager->flush();

        $service = new MessageService($entityManager);
        $service->addUsersToConversation($conversation, array($user1, $user2, $user3));

        $entityManager->refresh($conversation);

        $this->assertEquals(3, count($conversation->getMembers()));
    }

    public function testSendMessage()
    {

        $entityManager = $this->entityManager;

        $conversation = new Conversation();
        $conversation->setName('a conversation');
        $entityManager->persist($conversation);

        $user1 = new User();
        $user1->setEmail('test6@test.test');
        $user1->setFirstName('test');
        $user1->setLastName('test');
        $user1->setPassword('random');
        $user1->setLastLogin(new \DateTime(date('Y-m-d H:i:s')));
        $entityManager->persist($user1);

        $entityManager->flush();
        $service = new MessageService($entityManager);

        $service->addUsersToConversation($conversation, array($user1));
        $message = $service->sendMessage($user1, $conversation, "random message");

        $entityManager->refresh($conversation);

        $members = $conversation->getMembers();

        $this->assertEquals(1, count($members));
        $this->assertEquals(1, count($members[0]->getMessages()));

        $this->assertEquals($message->getMember()->getMemberId(), $members[0]->getMemberId());

        $messages = $service->findMessagesByConversation($conversation);
        $this->assertEquals(1, count($messages));
    }
}