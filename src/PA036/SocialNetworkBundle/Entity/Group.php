<?php

namespace PA036\SocialNetworkBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use PA036\AccountBundle\Entity\User;

/**
 * @ORM\Table(name="groups", uniqueConstraints={@ORM\UniqueConstraint(name="groups_name_key", columns={"name"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="PA036\SocialNetworkBundle\Entity\GroupRepository")
 */
class Group implements \JsonSerializable
{
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="group_id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $groupId;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="name", type="string", length=50, nullable=false)
	 * @Assert\NotBlank()
	 */
	private $name;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="description", type="text", nullable=true)
	 */
	private $description;

	/**
	 * @var Collection|User[]
	 *
	 * @ORM\ManyToMany(targetEntity="\PA036\AccountBundle\Entity\User")
	 * @ORM\JoinTable(name="user_group_map",
	 *      joinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="group_id")},
	 *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="user_id")}
	 * )
	 */
	private $users;

	/**
	 * @var Collection|Post[]
	 *
	 * @ORM\OneToMany(targetEntity="Post", mappedBy="group")
	 */
	private $posts;


	public function __construct()
	{
		$this->users = new ArrayCollection();
		$this->posts = new ArrayCollection();
	}


	public final function getGroupId()
	{
		return $this->groupId;
	}


	public function getName()
	{
		return $this->name;
	}


	public function setName($name)
	{
		$this->name = $name;
	}


	public function getDescription()
	{
		return $this->description;
	}


	public function setDescription($description)
	{
		$this->description = $description;
	}


	public function getUsers()
	{
		return $this->users;
	}


	public function getPosts()
	{
		return $this->posts;
	}


	public function jsonSerialize()
	{
		return array(
				'groupId' => $this->groupId,
				'name' => $this->name,
				'description' => $this->description
		);
	}
}
