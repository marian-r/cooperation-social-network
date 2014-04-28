<?php

namespace PA036\SocialNetworkBundle\Model\Domain;

use PA036\AccountBundle\Entity\User;
use PA036\SocialNetworkBundle\Entity\Group;

/**
 * 
 * @author Marian Rusnak
 */
class GroupService extends BaseService implements IGroupService
{
	/**
	 * @param Group $group
	 * @param User $user
	 * @return Group
	 */
	function addGroup(Group $group, User $user)
	{
		// TODO: Implement addGroup() method.
	}


	/**
	 * @param Group $group
	 * @return void
	 */
	function saveGroup(Group $group)
	{
		// TODO: Implement saveGroup() method.
	}


	/**
	 * @param Group $group
	 * @param User $user
	 * @return void
	 */
	function joinGroup(Group $group, User $user)
	{
		// TODO: Implement joinGroup() method.
	}


	/**
	 * @param Group $group
	 * @param User $user
	 * @return void
	 */
	function leaveGroup(Group $group, User $user)
	{
		// TODO: Implement leaveGroup() method.
	}


	/**
	 * @param User $user
	 * @return Group[]
	 */
	function findGroupsByUser(User $user)
	{
		// TODO: Implement findGroupsByUser() method.
	}
}
