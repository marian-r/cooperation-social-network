<?php

namespace PA036\AccountBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Users
 *
 * @ORM\Table(name="users", uniqueConstraints={@ORM\UniqueConstraint(name="users_email_key", columns={"email"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="PA036\AccountBundle\Entity\UsersRepository")
 */
class Users implements UserInterface, \Serializable {

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="users_user_id_seq", allocationSize=1, initialValue=1)
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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="PA036\SocialNetworkBundle\Entity\Groups", inversedBy="user")
     * @ORM\JoinTable(name="user_group_map",
     *   joinColumns={
     *     @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="group_id", referencedColumnName="group_id")
     *   }
     * )
     */
    private $group;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="PA036\SocialNetworkBundle\Entity\Posts", inversedBy="user")
     * @ORM\JoinTable(name="likes",
     *   joinColumns={
     *     @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="post_id", referencedColumnName="post_id")
     *   }
     * )
     */
    private $post;

    /*
     * Other vars
     */
    private $salt;
    private $isActive;

    /**
     * Constructor
     */
    public function __construct() {
        $this->group = new \Doctrine\Common\Collections\ArrayCollection();
        $this->post = new \Doctrine\Common\Collections\ArrayCollection();

        $this->isActive = true;
    }

    public function eraseCredentials() {
        return true;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 13));
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

    public function getUserId() {
        return $this->userId;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
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

    public function getGroup() {
        return $this->group;
    }

    public function setGroup(\Doctrine\Common\Collections\Collection $group) {
        $this->group = $group;
    }

    public function getPost() {
        return $this->post;
    }

    public function setPost(\Doctrine\Common\Collections\Collection $post) {
        $this->post = $post;
    }

    public function getIsActive() {
        return $this->isActive;
    }

    public function setIsActive($isActive) {
        $this->isActive = $isActive;
    }

}
