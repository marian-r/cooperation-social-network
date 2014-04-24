<?php

namespace PA036\SocialNetworkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PA036\SocialNetworkBundle\Entity\Group;

/**
 * Post
 *
 * @ORM\Table(name="posts", indexes={@ORM\Index(name="IDX_885DBAFAFE54D947", columns={"group_id"}), @ORM\Index(name="IDX_885DBAFA727ACA70", columns={"parent_id"})})
 * @ORM\Entity
 */
class Post implements \JsonSerializable {

    /**
     * @var integer
     *
     * @ORM\Column(name="post_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="posts_post_id_seq", allocationSize=1, initialValue=1)
     */
    private $postId;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $userId;

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
     * @var \Group
     *
     * @ORM\ManyToOne(targetEntity="Group")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="group_id", referencedColumnName="group_id")
     * })
     */
    private $group;

    /**
     * @var \Post
     *
     * @ORM\ManyToOne(targetEntity="Post")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="parent_id", referencedColumnName="post_id")
     * })
     */
    private $parent;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="PA036\AccountBundle\Entity\User", mappedBy="post")
     */
    private $user;

    /**
     * Constructor
     */
    public function __construct() {
        $this->user = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getPostId() {
        return $this->postId;
    }

    public function setPostId($postId) {
        $this->postId = $postId;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function getText() {
        return $this->text;
    }

    public function setText($text) {
        $this->text = $text;
    }

    public function getTimestamp() {
        return $this->timestamp;
    }

    public function setTimestamp(\DateTime $timestamp) {
        $this->timestamp = $timestamp;
    }

    public function getLikesCount() {
        return $this->likesCount;
    }

    public function setLikesCount($likesCount) {
        $this->likesCount = $likesCount;
    }

    public function getSeensCount() {
        return $this->seensCount;
    }

    public function setSeensCount($seensCount) {
        $this->seensCount = $seensCount;
    }

    public function getGroup() {
        return $this->group;
    }

    public function setGroup(Group $group) {
        $this->group = $group;
    }

    public function getParent() {
        return $this->parent;
    }

    public function setParent(Post $parent) {
        $this->parent = $parent;
    }

    public function getUser() {
        return $this->user;
    }

    public function setUser(\Doctrine\Common\Collections\Collection $user) {
        $this->user = $user;
    }

    public function jsonSerialize() {
        return array(
            'postId' => $this->postId,
            'text' => $this->text
        );
    }

    public function __toString() {
        return $this->postId . '';
    }

}
