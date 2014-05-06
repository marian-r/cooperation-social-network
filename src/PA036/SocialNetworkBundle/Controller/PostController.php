<?php

namespace PA036\SocialNetworkBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PostController extends BaseController
{
	/**
	 * @Route("/post/add", name="post_add")
	 */
	public function addAction(Request $request)
	{
		$text = $request->request->get("form_text");

		$groupId = $request->request->get("group_id");
		$group = (!empty($groupId)) ? $this->findGroupById($groupId) : NULL;

		$parent_id = $request->request->get("parent_id");
		if (empty($parent_id)) {
			$return = $this->getPostService()
					->addPost($this->getUser(), $text, $group, $request->files);
		} else {
			$parentPost = $this->findPostById($parent_id);
			$this->getPostService()->commentPost($parentPost, $this->getUser(), $text);
		}

		$response['status'] = "true";

		return new Response(json_encode_ex($response));
	}


	/**
	 * @Route("/posts", name="posts")
	 * @Template("PA036SocialNetworkBundle:Group:group.html.twig")
	 */
	public function groupPostsAction(Request $request)
	{
		$group_id = $request->request->get("group_id");
		$group = (!empty($group_id)) ? $this->findGroupById($group_id) : NULL;
		$posts = $this->getPostService()->findPostsByGroup($group);

		$response['posts'] = array();
		foreach ($posts as $post) {
			$response['posts'][$post->getPostId()]['post'] = $post;

			foreach ($post->getComments() as $comment) {
				$response['posts'][$post->getPostId()]['comments'][] = $comment;
			}
		}

		return new Response(json_encode_ex($response));
	}
}
