<?php

namespace PA036\SocialNetworkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="attachment_types")
 * @ORM\Entity
 */
class AttachmentType
{
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="type_id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $typeId;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="name", type="string", length=50, nullable=false)
	 * @Assert\NotBlank()
	 */
	private $name;


	public final function getTypeId()
	{
		return $this->typeId;
	}


	public function setName($name)
	{
		$this->name = $name;
	}


	public function getName()
	{
		return $this->name;
	}
}
