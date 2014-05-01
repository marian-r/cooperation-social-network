<?php

namespace PA036\SocialNetworkBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use PA036\AccountBundle\Entity\User;

/**
 * @ORM\Table(name="posts", indexes={
 *   @ORM\Index(name="IDX_885DBAFAFE54D947", columns={"group_id"}),
 *   @ORM\Index(name="IDX_885DBAFA727ACA70", columns={"parent_id"})
 * })
 * @ORM\Entity
 */
class Post implements \JsonSerializable
{
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="post_id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $postId;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="user_id", type="integer", nullable=false)
	 */
	private $userId;

	/**
	 * @var integer|NULL
	 *
	 * @ORM\Column(name="group_id", type="integer", nullable=true)
	 */
	private $groupId;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="text", type="text", nullable=false)
	 */
	private $text;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="timestamp", type="datetime", nullable=false)
	 */
	private $timestamp;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="likes_count", type="integer", nullable=false)
	 */
	private $likesCount;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="seens_count", type="integer", nullable=false)
	 */
	private $seensCount;

	/**
	 * @var Group|NULL
	 *
	 * @ORM\ManyToOne(targetEntity="Group", inversedBy="posts")
	 * @ORM\JoinColumn(name="group_id", referencedColumnName="group_id")
	 */
	private $group;

	/**
	 * @var Post|NULL
	 *
	 * @ORM\ManyToOne(targetEntity="Post", inversedBy="comments")
	 * @ORM\JoinColumn(name="parent_id", referencedColumnName="post_id")
	 */
	private $parent;

	/**
	 * @var Collection|Post[]
	 *
	 * @ORM\OneToMany(targetEntity="Post", mappedBy="parent")
	 */
	private $comments;

	/**
	 * @var User
	 *
	 * @ORM\ManyToOne(targetEntity="\PA036\AccountBundle\Entity\User")
	 * @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
	 */
	private $user;

	/**
	 * @var Collection|Like[]
	 *
	 * @ORM\OneToMany(targetEntity="Like", mappedBy="post")
	 */
	private $likes;

	/**
	 * @var Collection|Seen[]
	 *
	 * @ORM\OneToMany(targetEntity="Seen", mappedBy="post")
	 */
	private $seens;

	/**
	 * @var Collection|Attachment[]
	 *
	 * @ORM\OneToMany(targetEntity="Attachment", mappedBy="post")
	 */
	private $attachments;


	public function __construct()
	{
		$this->comments = new ArrayCollection();
		$this->likes = new ArrayCollection();
		$this->seens = new ArrayCollection();
		$this->attachments = new ArrayCollection();
	}


	public final function getPostId()
	{
		return $this->postId;
	}


	public final function getUserId()
	{
		return $this->userId;
	}


	public function getText()
	{
		return $this->text;
	}


	public function setText($text)
	{
		$this->text = $text;
	}


	public function getTimestamp()
	{
		return $this->timestamp;
	}


	public function setTimestamp(\DateTime $timestamp)
	{
		$this->timestamp = $timestamp;
	}


	public function getLikesCount()
	{
		return $this->likesCount;
	}


	public function setLikesCount($likesCount)
	{
		$this->likesCount = $likesCount;
	}


	public function getSeensCount()
	{
		return $this->seensCount;
	}


	public function setSeensCount($seensCount)
	{
		$this->seensCount = $seensCount;
	}


	public function getGroup()
	{
		return $this->group;
	}


	public function setGroup(Group $group = NULL)
	{
		$this->group = $group;
	}


	public function getParent()
	{
		return $this->parent;
	}


	public function getComments()
	{
		return $this->comments;
	}


	public function getUser()
	{
		return $this->user;
	}


	public function setUser(User $user)
	{
		$this->user = $user;
	}


	public function getLikes()
	{
		return $this->likes;
	}


	public function getSeens()
	{
		return $this->seens;
	}


	/** @return Collection|Attachment[] */
	public function getAttachments()
	{
		return $this->attachments;
	}


	public function jsonSerialize()
	{
		return array(
				'postId' => $this->postId,
				'text' => $this->text
		);
	}


	public function __toString()
	{
		return $this->text;
	}
}
