<?php

namespace PA036\AccountBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use PA036\SocialNetworkBundle\Entity\UserGroupMap;
use PA036\SocialNetworkBundle\Entity\Post;

/**
 * @ORM\Table(name="users", uniqueConstraints={@ORM\UniqueConstraint(name="users_email_key", columns={"email"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="PA036\AccountBundle\Entity\UserRepository")
 */
class User implements UserInterface, \Serializable {

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=80, nullable=false)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=50, nullable=false)
     * @Assert\NotBlank()
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=50, nullable=false)
     * @Assert\NotBlank()
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $password;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_login", type="datetime", nullable=false)
     */
    private $lastLogin;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var Collection|UserGroupMap[]
     *
     * @ORM\OneToMany(targetEntity="\PA036\SocialNetworkBundle\Entity\UserGroupMap", mappedBy="user")
     */
    private $groupMaps;

    private $salt;
    private $isActive;

    public function __construct() {
        $this->groupsMaps = new ArrayCollection();

        $this->salt = '%%#$gfd9dg#fdg$8564%d$';
        $this->isActive = true;
    }

    public function eraseCredentials() {
        return true;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getRoles() {
        return array('ROLE_USER');
    }

    public function getSalt() {
        return $this->salt;
    }

    public function isEnabled() {
        return $this->isActive;
    }

    public function getUsername() {
        return $this->email;
    }

    public function serialize() {
        return serialize(array(
            $this->userId,
                // see section on salt below
                // $this->salt,
        ));
    }

    public function unserialize($serialized) {
        list (
                $this->userId,
                // see section on salt below
                // $this->salt
                ) = unserialize($serialized);
    }

    public final function getUserId() {
        return $this->userId;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function setFirstName($firstName) {
        $this->firstName = $firstName;
    }

    public function getLastName() {
        return $this->lastName;
    }

    public function setLastName($lastName) {
        $this->lastName = $lastName;
    }

    public function getLastLogin() {
        return $this->lastLogin;
    }

    public function setLastLogin(\DateTime $lastLogin) {
        $this->lastLogin = $lastLogin;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getGroupMaps() {
         $this->groupMaps;
    }

    public function setGroupMaps(Collection $groupMaps) {
        $this->groupMaps = $groupMaps;
    }

	public function getGroups()
	{
		$groups = new ArrayCollection();
		foreach ($this->groupMaps as $groupMap) {
			$groups->add($groupMap->getGroup());
		}
		return $groups;
	}

	public function getAdminGroups()
	{
		$groups = new ArrayCollection();
		foreach ($this->groupMaps as $groupMap) {
			if ($groupMap->getIsAdmin()) {
				$groups->add($groupMap->getGroup());
			}
		}
		return $groups;
	}

    public function getIsActive() {
        return $this->isActive;
    }

    public function setIsActive($isActive) {
        $this->isActive = $isActive;
    }

	public function getFullName()
	{
		return "$this->firstName $this->lastName";
	}
}
