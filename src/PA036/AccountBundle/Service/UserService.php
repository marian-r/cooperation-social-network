<?php

namespace PA036\AccountBundle\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\UnitOfWork;
use PA036\AccountBundle\Entity\User;

/**
 * 
 * @author Marian Rusnak
 */
class UserService implements IUserService
{
	/** @var EntityManager */
	protected $entityManager;


	public function __construct(EntityManager $entityManager)
	{
		$this->entityManager = $entityManager;
	}


	/**
	 * @param User $user
	 * @return void
	 */
	function saveUser(User $user)
	{
		if ($this->entityManager->getUnitOfWork()->getEntityState($user) === UnitOfWork::STATE_NEW) {
			$this->entityManager->persist($user);
		} else {
			$this->entityManager->merge($user);
		}
		$this->entityManager->flush();
	}
}