<?php

namespace PA036\SocialNetworkBundle\Model\Domain;

use Doctrine\Common\Persistence\ObjectManager ;

/**
 * 
 * @author Marian Rusnak
 */
abstract class BaseService
{
	/** @var ObjectManager */
	protected $entityManager;


	public function __construct(ObjectManager $entityManager)
	{
		$this->entityManager = $entityManager;
	}
}
