<?php

namespace PA036\SocialNetworkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PA036\AccountBundle\Entity\User;

/**
 * @ORM\Table(name="likes")
 * @ORM\Entity
 */
class Like
{
	/**
	 * @var User
	 *
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="NONE")
	 * @ORM\ManyToOne(targetEntity="\PA036\AccountBundle\Entity\User")
	 * @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
	 */
	private $user;

    /**
     * @var Post
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="likes")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="post_id")
     */
    private $post;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timestamp", type="datetime", nullable=false)
     */
    private $timestamp;


	public function setUser(User $user)
	{
		$this->user = $user;
	}


	/** @return User */
	public function getUser()
	{
		return $this->user;
	}


	public function setPost(Post $post)
	{
		$this->post = $post;
	}


	/** @return Post */
	public function getPost()
	{
		return $this->post;
	}


	/** @param \DateTime $timestamp */
	public function setTimestamp($timestamp)
	{
		$this->timestamp = $timestamp;
	}


	/** @return \DateTime */
	public function getTimestamp()
	{
		return $this->timestamp;
	}
}
