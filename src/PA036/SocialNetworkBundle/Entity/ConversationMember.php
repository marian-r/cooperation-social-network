<?php

namespace PA036\SocialNetworkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PA036\AccountBundle\Entity\User;
use PA036\SocialNetworkBundle\Entity\Message;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Table(name="conversation_members")
 * @ORM\Entity
 */
class ConversationMember
{
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="member_id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $memberId;

	/**
	 * @var Conversation
	 *
	 * @ORM\ManyToOne(targetEntity="Conversation", inversedBy="members")
	 * @ORM\JoinColumn(name="conversation_id", referencedColumnName="conversation_id")
	 * })
	 */
	private $conversation;

	/**
	 * @var User
	 *
	 * @ORM\ManyToOne(targetEntity="\PA036\AccountBundle\Entity\User")
	 * @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
	 */
	private $user;

    /**
     * @var Collection|Message[]
     *
     * @ORM\OneToMany(targetEntity="Message", mappedBy="member")
     */
    private $messages;

	public final function getMemberId()
	{
		return $this->memberId;
	}


	/** @return \PA036\SocialNetworkBundle\Entity\Conversation */
	public function getConversation()
	{
		return $this->conversation;
	}


	/** @return \PA036\AccountBundle\Entity\User */
	public function getUser()
	{
		return $this->user;
	}

    public function getMessages()
    {
        return $this->messages;
    }
}