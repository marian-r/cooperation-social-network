<?php
/**
 * User: V
 * Date: 2.5.2014
 * Time: 23:09
 */

namespace PA036\SocialNetworkBundle\Service;

use Doctrine\ORM\Query\ResultSetMapping;
use PA036\SocialNetworkBundle\Entity\Attachment;
use PA036\SocialNetworkBundle\Entity\AttachmentType;
use PA036\SocialNetworkBundle\Entity\Seen;
use PA036\SocialNetworkBundle\Entity\Like;
use PA036\AccountBundle\Entity\User;
use PA036\SocialNetworkBundle\Entity\Group;
use PA036\SocialNetworkBundle\Entity\Post;

class PostService extends BaseService implements IPostService
{
    private function createPostMapping()
    {
        $rsm = new ResultSetMapping();

        $rsm->addEntityResult('PA036\SocialNetworkBundle\Entity\Post', 'p');
        $rsm->addFieldResult('p', 'post_id', 'postId');
        $rsm->addFieldResult('p', 'text', 'text');
        $rsm->addFieldResult('p', 'likes_count', 'likesCount');
        $rsm->addFieldResult('p', 'seens_count', 'seensCount');
        $rsm->addFieldResult('p', 'timestamp', 'timestamp');


        $rsm->addMetaResult('p', 'user_id', 'user_id');
        $rsm->addMetaResult('p', 'post_id', 'post_id');
        $rsm->addMetaResult('p', 'group_id', 'group_id');
        return $rsm;
    }

    /**
     * @param User $user
     * @param string $text
     * @param Group $group
     * @param array $files
     * @return Post
     */
	function addPost(User $user, $text, Group $group = NULL, $files = array())
	{
		$rsm = $this->createPostMapping();
		return $this->entityManager->transactional(function($em) use ($rsm, $user, $text, $group, $files) {

			$query = $em->createNativeQuery(
					'select * from add_post( NULL, :group_id, :user_id, :text)', $rsm
			);
			$query->setParameter(":group_id", $group ? $group->getGroupId() : NULL);
			$query->setParameter(":user_id", $user->getUserId());
			$query->setParameter(":text", $text);

			$post = $query->getSingleResult();

			foreach ($files as $file) {
				$attachmentType = new AttachmentType();
				$attachmentType->setName($file->guessExtension());
				$em->persist($attachmentType);

				$attachment = new Attachment();
				$attachment->setType($attachmentType);
				$attachment->setFileHandler($file);
				$attachment->setPost($post);
				$em->persist($attachment);
			}
			return $post;
		});
    }

    /**
     * @param Post $post
     * @return void
     */
    function savePost(Post $post)
    {
        $this->entityManager->persist($post);
    }

    /**
     * @param Post $post
     * @param User $user
     * @param string $comment
     * @return Post
     */
    function commentPost(Post $post, User $user, $comment)
    {
        $group = $post->getGroup();

        $query = $this->entityManager->createNativeQuery(
            'select * from add_post( :post_id, :group_id, :user_id, :text)',
            $this->createPostMapping()
        );
        $query->setParameter(":post_id", $post->getPostId());
        $query->setParameter(":group_id", $group ? $group->getGroupId() : null);
        $query->setParameter(":user_id", $user->getUserId());
        $query->setParameter(":text", $comment);

        return $query->getSingleResult();
    }

    /**
     * @param Post $post
     * @param User $user
     * @return void
     */
    function likePost(Post $post, User $user)
    {
        $like = new Like();
        $like->setPost($post);
        $like->setUser($user);
        $like->setTimestamp(new \DateTime(date('Y-m-d H:i:s')));

        $this->entityManager->persist($like);
    }

    /**
     * @param Post $post
     * @param User $user
     * @return void
     */
    function markPostAsSeen(Post $post, User $user)
    {
        $seen = new Seen();
        $seen->setPost($post);
        $seen->setUser($user);
        $seen->setTimestamp(new \DateTime(date('Y-m-d H:i:s')));

        $this->entityManager->persist($seen);
    }

    /**
     * @param Group $group
     * @return Post[]
     */
    function findPostsByGroup(Group $group = NULL)
    {
        return
            $this->entityManager->getRepository('PA036\SocialNetworkBundle\Entity\Post')->findBy(
                array(
                    'group' => $group ? $group->getGroupId() : null
                )
            );
    }
}
