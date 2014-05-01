<?php

namespace PA036\SocialNetworkBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use PA036\AccountBundle\Entity\User;

/**
 * @ORM\Table(name="conversations")
 * @ORM\Entity
 */
class Conversation
{
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="conversation_id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $conversationId;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="name", type="string", length=50, nullable=false)
	 * @Assert\NotBlank()
	 */
	private $name;

	/**
	 * @var Collection|User[]
	 *
	 * @ORM\OneToMany(targetEntity="ConversationMember", mappedBy="conversation")
	 */
	private $members;


	public function __construct()
	{
		$this->members = new ArrayCollection();
	}


	public final function getConversationId()
	{
		return $this->conversationId;
	}


	public function setName($name)
	{
		$this->name = $name;
	}


	public function getName()
	{
		return $this->name;
	}


    /** @var Collection|User[] */
	public function getMembers()
	{
		return $this->members;
	}
}
