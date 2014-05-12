<?php

namespace PA036\SocialNetworkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PA036\SocialNetworkBundle\Entity\Post;

/**
 * @ORM\Table(name="attachments", indexes={@ORM\Index(name="IDX_47C4FAD6C54C8C93", columns={"type_id"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Attachment {

    /**
     * @var integer
     *
     * @ORM\Column(name="attachment_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $attachmentId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="binary_data", type="blob", nullable=false)
     */
    private $binaryData;

    /**
     * @var Post
     *
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="attachments", cascade={"persist"})
     * @ORM\JoinColumn(name="post_id", referencedColumnName="post_id")
     */
    private $post;

    /**
     * @var Message
     *
     * @ORM\ManyToOne(targetEntity="Message", inversedBy="attachments")
     * @ORM\JoinColumn(name="message_id", referencedColumnName="message_id")
     */
    private $message;

    /**
     * @var AttachmentType
     *
     * @ORM\ManyToOne(targetEntity="AttachmentType")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="type_id")
     */
    private $type;

    /**
     * Virtual field used for handling the file
     */
    private $fileHandler;

    public final function getAttachmentId() {
        return $this->attachmentId;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }

    public function setBinaryData($binaryData) {
        $this->binaryData = $binaryData;
    }

    public function getBinaryData() {
        return $this->binaryData;
    }

    public function setMessage(Message $message = NULL) {
        $this->message = $message;
    }

    /** @return Message */
    public function getMessage() {
        return $this->message;
    }

    public function setPost(Post $post = NULL) {
        $this->post = $post;
    }

    /** @return Post */
    public function getPost() {
        return $this->post;
    }

    public function setType(AttachmentType $type) {
        $this->type = $type;
    }

    /** @return AttachmentType */
    public function getType() {
        return $this->type;
    }

    public function getFileHandler() {
        return $this->fileHandler;
    }

    public function setFileHandler($fileHandler) {
        $this->fileHandler = $fileHandler;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function saveFileContent() {
	    $tmpName = md5(uniqid(mt_rand(), true)) . '.' . $this->fileHandler->guessExtension();
	    $tmpDir = '../web/tmp';
	    $tmpPath = "$tmpDir/$tmpName";
	    try {
		    $this->name = $this->fileHandler->getClientOriginalName();
		    $this->fileHandler->move($tmpDir, $tmpName);
	    } catch (\Exception $e) {
		    print_r($e);
	    }
	    $this->setBinaryData(file_get_contents($tmpPath));
	    unlink($tmpPath);
    }
}
