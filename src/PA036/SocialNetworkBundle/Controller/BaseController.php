<?php

namespace PA036\SocialNetworkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use PA036\AccountBundle\Entity\User;
use PA036\SocialNetworkBundle\Service\IGroupService;
use PA036\SocialNetworkBundle\Service\IPostService;
use PA036\SocialNetworkBundle\Service\IMessageService;

/**
 * 
 * @author Marian Rusnak
 */
abstract class BaseController extends Controller
{
	/** @var User */
	private $user;

	/** @var IGroupService */
	private $groupService;

	/** @var IPostService */
	private $postService;

	/** @var IMessageService */
	private $messageService;


	/** @return User */
	public function getUser()
	{
		if ($this->user === NULL) {
			$this->user = $this->get('security.context')->getToken()->getUser();
		}
		return $this->user;
	}


	/** @return IGroupService */
	public function getGroupService()
	{
		if ($this->groupService === NULL) {
			$this->groupService = $this->getService('Group');
		}
		return $this->groupService;
	}


	/** @return IPostService */
	public function getPostService()
	{
		if ($this->postService === NULL) {
			$this->postService = $this->getService('Post');
		}
		return $this->postService;
	}


	/** @return IMessageService */
	public function getMessageService()
	{
		if ($this->messageService === NULL) {
			$this->messageService = $this->getService('Message');
		}
		return $this->messageService;
	}


	protected function getService($entityName)
	{
		return $this->get("pa036_social_network.service." . strtolower($entityName));
	}


	protected function findGroupById($groupId)
	{
		return $this->findEntity('Group', array("groupId" => $groupId));
	}


	protected function findPostById($postId)
	{
		return $this->findEntity('Post', array("postId" => $postId));
	}


	private function findEntity($entityName, array $filter)
	{
        return $this->getDoctrine()
		        ->getManager()
		        ->getRepository("PA036SocialNetworkBundle:$entityName")
		        ->findOneBy($filter);
	}
}
