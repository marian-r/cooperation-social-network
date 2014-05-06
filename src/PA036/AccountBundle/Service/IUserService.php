<?php

namespace PA036\AccountBundle\Service;

use PA036\AccountBundle\Entity\User;

/**
 * 
 * @author Marian Rusnak
 */
interface IUserService
{
	/**
	 * @param User $user
	 * @return void
	 */
	function saveUser(User $user);
} 