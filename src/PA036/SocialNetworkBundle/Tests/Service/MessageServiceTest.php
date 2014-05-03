<?php
/**
 * User: V
 * Date: 3.5.2014
 * Time: 11:32
 */
namespace PA036\SocialNetworkBundle\Tests\Service;

use PA036\SocialNetworkBundle\Service\PostService;
use PA036\SocialNetworkBundle\Service\MessageService;
use PA036\SocialNetworkBundle\Entity\Group;
use PA036\AccountBundle\Entity\User;
use PA036\SocialNetworkBundle\Entity\Post;

class MessageServiceTest extends ServiceTestCase
{

    /**
    function testFilter(){
    $entityManager = $this->entityManager;
    $service = new PostService($entityManager);
    $posts = $service->findPostsByGroup($entityManager->find('PA036\SocialNetworkBundle\Entity\Group', 1));
    $this->assertEquals(1, count($posts));
    }
     */

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
        /*    $entityManager = $this->entityManager;

            $group1 = new Group();
            $group1->setName('testing2 group');
            $group1->setDescription('lorem ipsum');

            $entityManager->persist($group1);

            $user1 = new User();
            $user1->setEmail('test@test.test');
            $user1->setFirstName('test');
            $user1->setLastName('test');
            $user1->setPassword('random');
            $user1->setLastLogin(new \DateTime(date('Y-m-d H:i:s')));

            $entityManager->persist($user1);

            $post = new Post();
            $post->setUser($user1);
            $post->setLikesCount(11);
            $post->setSeensCount(26);
            $post->setGroup($group1);
            $post->setText("");
            $post->setTimestamp(new \DateTime(date('Y-m-d H:i:s')));

            $entityManager->persist($post);

            $entityManager->flush();

            $service = new PostService($entityManager);

            $saved_post = $service->commentPost($post, $user1, 'random comment');

            $this->assertNotEquals(null, $saved_post);

            if($saved_post){
                $this->assertNotEquals(0, $saved_post->getPostId());
                $this->assertEquals('random comment', $saved_post->getText());
                $this->assertEquals($post->getGroup()->getGroupId(), $saved_post->getGroup()->getGroupId());
            }*/
    }

    public function testSendMessage()
    {

    }
}