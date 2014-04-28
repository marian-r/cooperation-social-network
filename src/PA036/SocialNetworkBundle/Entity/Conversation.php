<?php

namespace PA036\SocialNetworkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Conversation
 *
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
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="conversations_conversation_id_seq", allocationSize=1, initialValue=1)
     */
    private $conversationId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name;


}
