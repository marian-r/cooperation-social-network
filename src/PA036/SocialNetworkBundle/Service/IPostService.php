<?php

namespace PA036\SocialNetworkBundle\Service;

use PA036\AccountBundle\Entity\User;
use PA036\SocialNetworkBundle\Entity\Group;
use PA036\SocialNetworkBundle\Entity\Post;

/**
 * 
 * @author Marian Rusnak
 */
interface IPostService
{
	/**
	 * @param User $user
	 * @param string $text
	 * @param Group $group
	 * @param array $files
	 * @return Post
	 */
	function addPost(User $user, $text, Group $group = NULL, $files = array());


	/**
	 * @param Post $post
	 * @return void
	 */
	function savePost(Post $post);


	/**
	 * @param Post $post
	 * @param User $user
	 * @param string $comment
	 * @return Post
	 */
	function commentPost(Post $post, User $user, $comment);


	/**
	 * @param Post $post
	 * @param User $user
	 * @return void
	 */
	function likePost(Post $post, User $user);


	/**
	 * @param Post $post
	 * @param User $user
	 * @return void
	 */
	function markPostAsSeen(Post $post, User $user);


	/**
	 * @param Group $group
	 * @return Post[]
	 */
	function findPostsByGroup(Group $group = NULL);
}
