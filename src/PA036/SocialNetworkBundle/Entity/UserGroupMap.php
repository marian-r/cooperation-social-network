<?php

namespace PA036\SocialNetworkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PA036\AccountBundle\Entity\User;

/**
 * @ORM\Table(name="user_group_map", indexes={@ORM\Index(name="IDX_10DFCF26FE54D947", columns={"group_id"})})
 * @ORM\Entity
 */
class UserGroupMap
{
	/**
	 * @var User
	 *
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="NONE")
	 * @ORM\ManyToOne(targetEntity="\PA036\AccountBundle\Entity\User", inversedBy="groupMaps")
	 * @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
	 */
	private $user;

	/**
	 * @var Group
	 *
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="NONE")
	 * @ORM\ManyToOne(targetEntity="Group")
	 * @ORM\JoinColumn(name="group_id", referencedColumnName="group_id")
	 */
	private $group;

	/**
	 * @var boolean
	 *
	 * @ORM\Column(name="is_admin", type="boolean", nullable=false)
	 */
	private $isAdmin;


	public function getUser()
	{
		return $this->user;
	}


	public function getGroup()
	{
		return $this->group;
	}


	public function getIsAdmin()
	{
		return $this->isAdmin;
	}


	public function setIsAdmin($isAdmin)
	{
		$this->isAdmin = $isAdmin;
	}
}
