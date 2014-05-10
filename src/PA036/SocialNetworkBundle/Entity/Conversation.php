<?php

namespace PA036\SocialNetworkBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use PA036\AccountBundle\Entity\User;
use PA036\SocialNetworkBundle\Entity\Message;

/**
 * @ORM\Table(name="conversations")
 * @ORM\Entity
 */
class Conversation implements \JsonSerializable
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
	 * @var Collection|ConversationMember[]
	 *
	 * @ORM\OneToMany(targetEntity="ConversationMember", mappedBy="conversation")
	 */
	private $members;

    /**
     * @var string
     *
     */
    private $initialMessage;

    /**
     * @var Collection|Message[]
     */
    private $messages;

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


    /** @var Collection|ConversationMember[]
     * @return \Doctrine\Common\Collections\ArrayCollection|ConversationMember[]
     */
	public function getMembers()
	{
		return $this->members;
	}

    /**
     * @param string $initialMessage
     */
    public function setInitialMessage($initialMessage)
    {
        $this->initialMessage = $initialMessage;
    }

    /**
     * @return string
     */
    public function getInitialMessage()
    {
        return $this->initialMessage;
    }


    public function jsonSerialize()
    {
        return array(
            'id' => $this->getConversationId(),
            'name' => $this->getName(),
            'messages' => $this->getMessages(),
        );
    }

    public function setMessages($messages)
    {
        $this->messages = $messages;
    }

    public function getMessages()
    {
        return $this->messages;
    }


}
