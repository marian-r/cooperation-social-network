<?php

namespace PA036\SocialNetworkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PA036\SocialNetworkBundle\Entity\Post;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use PA036\AccountBundle\Entity\User;
use PA036\SocialNetworkBundle\Entity\Attachment;
use PA036\SocialNetworkBundle\Entity\AttachmentType;
use Doctrine\Common\Collections\ArrayCollection;

class PostController extends Controller {

    /**
     * @Route("/post/add", name="post_add")
     */
    public function addAction(Request $request) {
        $username = $this->get('security.context')->getToken()->getUser()->getUsername();

        $em = $this->getDoctrine()->getManager();

        $user = new User();
        $user = $em->getRepository('PA036AccountBundle:User')->loadUserByUsername($username);

        $post = new Post();
        $post->setText($request->request->get("form_text"));
        $post->setLikesCount(0);
        $post->setSeensCount(0);
        $post->setUser($user);
        $post->setTimestamp(new \DateTime());

        $parent_id = $request->request->get("parent_id");

        if (!empty($parent_id)) {
            $post_parent = $em->getRepository('PA036SocialNetworkBundle:Post')->findOneBy(array("postId" => $parent_id));
            $post->setParent($post_parent);
        }

        $groupId = $request->request->get("group_id");

        if (!empty($groupId)) {
            $group = $em->getRepository('PA036SocialNetworkBundle:Group')->findOneBy(array("groupId" => $groupId));
            $post->setGroup($group);
        }

        if ($request->isMethod('POST')) {

            foreach ($request->files as $file) {
                $attachmentType = new AttachmentType();
                $attachmentType->setName($file->guessExtension());
                $em->persist($attachmentType);
                $em->flush();

                $attachment = new Attachment();
                $attachment->setFileHandler($request->files);

                $attachment->setType($attachmentType);
                $attachment->setFileHandler($file);

                $attachment->setPost($post);
                $em->persist($attachment);
                $em->flush();
            }

            $em->persist($post);
            $em->flush();

            $response['status'] = "true";

            return new Response(json_encode_ex($response));
        }
        return new Response();
    }

    /**
     * @Route("/posts", name="posts")
     * @Template("PA036SocialNetworkBundle:Group:group.html.twig")
     */
    public function groupPostsAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $group_id = $request->request->get("group_id");
        if (!empty($group_id)) {
            $group = $em->getRepository('PA036SocialNetworkBundle:Group')->findOneBy(array("groupId" => $group_id));
            $posts = $em->getRepository('PA036SocialNetworkBundle:Post')->findBy(array("parent" => null, "group" => $group), array('postId' => 'DESC'));
        } else {
            $posts = $em->getRepository('PA036SocialNetworkBundle:Post')->findBy(array("parent" => null, "group" => null), array('postId' => 'DESC'));
        }

        $response['posts'] = array();
        foreach ($posts as $post) {

            $comments = $em->getRepository('PA036SocialNetworkBundle:Post')->findBy(array("parent" => $post->getPostId()));

            $response['posts'][$post->getPostId()]['post'] = $post;

            foreach ($comments as $comment) {
                $response['posts'][$post->getPostId()]['comments'][] = $comment;
            }
        }

        return new Response(json_encode_ex($response));
    }

}
