<?php

namespace PA036\SocialNetworkBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use PA036\AccountBundle\Entity\User;

/**
 * @ORM\Table(name="messages", indexes={@ORM\Index(name="IDX_DB021E967597D3FE", columns={"member_id"})})
 * @ORM\Entity
 */
class Message
{
    /**
     * @var integer
     *
     * @ORM\Column(name="message_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $messageId;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="text", nullable=false)
     */
    private $body;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timestamp", type="datetime", nullable=false)
     */
    private $timestamp;

    /**
     * @var User
     *
     * @ORM\OneToOne(targetEntity="ConversationMember")
     * @ORM\JoinColumn(name="member_id", referencedColumnName="member_id")
     */
    private $member;

	/**
	 * @var Collection|Attachment[]
	 *
	 * @ORM\OneToMany(targetEntity="Attachment", mappedBy="message")
	 */
	private $attachments;


	public function __construct($attachments)
	{
		$this->attachments = new ArrayCollection();
	}


	public final function getMessageId()
	{
		return $this->messageId;
	}


	public function setBody($body)
	{
		$this->body = $body;
	}


	public function getBody()
	{
		return $this->body;
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


	/** @return User */
	public function getMember()
	{
		return $this->member;
	}


	/** @return Collection|Attachment[] */
	public function getAttachments()
	{
		return $this->attachments;
	}
}
