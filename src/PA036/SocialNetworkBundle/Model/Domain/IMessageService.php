<?php

namespace PA036\SocialNetworkBundle\Model\Domain;

use PA036\AccountBundle\Entity\User;
use PA036\SocialNetworkBundle\Entity\Conversation;
use PA036\SocialNetworkBundle\Entity\Message;

/**
 * 
 * @author Marian Rusnak
 */
interface IMessageService
{
	/**
	 * @param User $user
	 * @param User[] $members
	 * @param string $messageBody
	 * @return Conversation
	 */
	function startConversation(User $user, $members, $messageBody);


	/**
	 * @param Conversation $conversation
	 * @param User[] $users
	 * @return void
	 */
	function addUsersToConversation(Conversation $conversation, $users);


	/**
	 * @param User $user
	 * @param Conversation $conversation
	 * @param string $messageBody
	 * @param array $files
	 * @return Message
	 */
	function sendMessage(User $user, Conversation $conversation, $messageBody, $files = array());
}
