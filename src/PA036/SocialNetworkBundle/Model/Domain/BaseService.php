<?php

namespace PA036\SocialNetworkBundle\Model\Domain;

use Doctrine\ORM\EntityManager;

/**
 * 
 * @author Marian Rusnak
 */
abstract class BaseService
{
	/** @var EntityManager */
	protected $entityManager;


	public function __construct(EntityManager $entityManager)
	{
		$this->entityManager = $entityManager;
	}
}
