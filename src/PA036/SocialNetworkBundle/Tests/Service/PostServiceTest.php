<?php
/**
 * User: V
 * Date: 2.5.2014
 * Time: 23:31
 */

namespace PA036\SocialNetworkBundle\Tests\Service;

use PA036\SocialNetworkBundle\Service\PostService;
use PA036\SocialNetworkBundle\Entity\Group;
use PA036\AccountBundle\Entity\User;
use PA036\SocialNetworkBundle\Entity\Post;

class PostServiceTest extends ServiceTestCase{

    public function testAddPost(){
        $entityManager = $this->entityManager;

        $user1 = new User();
        $user1->setEmail('test@test.test');
        $user1->setFirstName('test');
        $user1->setLastName('test');
        $user1->setPassword('random');
        $user1->setLastLogin(new \DateTime(date('Y-m-d H:i:s')));

        $entityManager->persist($user1);

        $entityManager->flush();

        $service = new PostService($entityManager);

        $saved_post = $service->addPost($user1, 'random post');

        $this->assertNotEquals(null, $saved_post);
        if($saved_post){
            $this->assertNotEquals(0, $saved_post->getPostId());
            $this->assertEquals('random post', $saved_post->getText());
        }
    }

    public function testAddComment(){
        $entityManager = $this->entityManager;

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
        }
    }
}
