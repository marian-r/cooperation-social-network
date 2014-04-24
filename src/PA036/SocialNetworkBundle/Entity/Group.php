<?php

namespace PA036\SocialNetworkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Groups
 *
 * @ORM\Table(name="groups", uniqueConstraints={@ORM\UniqueConstraint(name="groups_name_key", columns={"name"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="PA036\SocialNetworkBundle\Entity\GroupRepository")
 */
class Group implements \JsonSerializable {

    /**
     * @var integer
     *
     * @ORM\Column(name="group_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="groups_group_id_seq", allocationSize=1, initialValue=1)
     */
    private $groupId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="PA036\AccountBundle\Entity\User", mappedBy="group")
     */
    private $user;

    /**
     * Constructor
     */
    public function __construct() {
        $this->user = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getGroupId() {
        return $this->groupId;
    }

    public function setGroupId($groupId) {
        $this->groupId = $groupId;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getUser() {
        return $this->user;
    }

    public function setUser(\Doctrine\Common\Collections\Collection $user) {
        $this->user = $user;
    }

    public function jsonSerialize() {
        return array(
            'groupId' => $this->groupId,
            'name'=> $this->name,
            'Description' => $this->description
        );
    }


}
