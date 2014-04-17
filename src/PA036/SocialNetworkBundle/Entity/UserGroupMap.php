<?php

namespace PA036\SocialNetworkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserGroupMap
 *
 * @ORM\Table(name="user_group_map", indexes={@ORM\Index(name="IDX_10DFCF26FE54D947", columns={"group_id"})})
 * @ORM\Entity
 */
class UserGroupMap {

    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="\PA036\AccountBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
     * })
     */
    private $user;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_admin", type="boolean", nullable=false)
     */
    private $isAdmin;

    /**
     * @var \Group
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Group")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="group_id", referencedColumnName="group_id")
     * })
     */
    private $group;

    public function getUser() {
        return $this->user;
    }

    public function setUser(\PA036\AccountBundle\Entity\User $user) {
        $this->user = $user;
    }

    public function getIsAdmin() {
        return $this->isAdmin;
    }

    public function setIsAdmin($isAdmin) {
        $this->isAdmin = $isAdmin;
    }

    public function getGroup() {
        return $this->group;
    }

    public function setGroup(Group $group) {
        $this->group = $group;
    }



}
