<?php

namespace PA036\SocialNetworkBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Marian Rusnak
 *
 * @Route("/attachment")
 */
class AttachmentController extends BaseController
{
	/**
	 * @Route("/download/{id}")
	 */
	public function downloadAction($id)
	{
		$post = $this->findPostById($id);
		$attachment = $post->getAttachments()->first();

		$fileName = $attachment->getName();

		$response = new Response();
		$response->headers->set('Cache-Control', 'private');
		$response->headers->set('Content-Disposition', 'attachment; filename="' . $fileName . '";');
		//$response->headers->set('Content-length', filesize($filename));

		$response->setContent(stream_get_contents($attachment->getBinaryData()));

		return $response;
	}
} 