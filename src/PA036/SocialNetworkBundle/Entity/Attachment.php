<?php

namespace PA036\SocialNetworkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Attachment
 *
 * @ORM\Table(name="attachments", uniqueConstraints={@ORM\UniqueConstraint(name="attachments_message_id_key", columns={"message_id"}), @ORM\UniqueConstraint(name="attachments_post_id_key", columns={"post_id"})}, indexes={@ORM\Index(name="IDX_47C4FAD6C54C8C93", columns={"type_id"})})
 * @ORM\Entity
 */
class Attachment
{
    /**
     * @var integer
     *
     * @ORM\Column(name="attachment_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="attachments_attachment_id_seq", allocationSize=1, initialValue=1)
     */
    private $attachmentId;

    /**
     * @var string
     *
     * @ORM\Column(name="binary_data", type="blob", nullable=false)
     */
    private $binaryData;

    /**
     * @var \Post
     *
     * @ORM\ManyToOne(targetEntity="Post")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="post_id", referencedColumnName="post_id")
     * })
     */
    private $post;

    /**
     * @var \AttachmentType
     *
     * @ORM\ManyToOne(targetEntity="AttachmentType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="type_id", referencedColumnName="type_id")
     * })
     */
    private $type;

    /**
     * @var \Message
     *
     * @ORM\ManyToOne(targetEntity="Message")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="message_id", referencedColumnName="message_id")
     * })
     */
    private $message;


}
