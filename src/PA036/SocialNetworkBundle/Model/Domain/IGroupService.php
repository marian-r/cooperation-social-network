<?php

namespace PA036\SocialNetworkBundle\Model\Domain;

use PA036\AccountBundle\Entity\User;
use PA036\SocialNetworkBundle\Entity\Group;
use PA036\SocialNetworkBundle\Entity\UserGroupMap;

/**
 * 
 * @author Marian Rusnak
 */
interface IGroupService
{
	/**
	 * @param Group $group
	 * @param User $user
	 * @return Group
	 */
	function addGroup(Group $group, User $user);


	/**
	 * @param Group $group
	 * @return void
	 */
	function saveGroup(Group $group);


	/**
	 * @param Group $group
	 * @param User $user
	 * @return void
	 */
	function joinGroup(Group $group, User $user);


	/**
	 * @param Group $group
	 * @param User $user
	 * @return void
	 */
	function leaveGroup(Group $group, User $user);
} 