<?php

namespace PA036\SocialNetworkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ConversationMembers
 *
 * @ORM\Table(name="conversation_members", uniqueConstraints={@ORM\UniqueConstraint(name="conversation_members_conversation_id_user_id_key", columns={"conversation_id", "user_id"})}, indexes={@ORM\Index(name="IDX_DEF6DCF59AC0396", columns={"conversation_id"}), @ORM\Index(name="IDX_DEF6DCF5A76ED395", columns={"user_id"})})
 * @ORM\Entity
 */
class ConversationMembers
{
    /**
     * @var integer
     *
     * @ORM\Column(name="member_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="conversation_members_member_id_seq", allocationSize=1, initialValue=1)
     */
    private $memberId;

    /**
     * @var \Conversations
     *
     * @ORM\ManyToOne(targetEntity="Conversations")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="conversation_id", referencedColumnName="conversation_id")
     * })
     */
    private $conversation;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
     * })
     */
    private $user;


}
