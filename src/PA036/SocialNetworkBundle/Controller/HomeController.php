<?php

namespace PA036\SocialNetworkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PA036\SocialNetworkBundle\Entity\Post;

class HomeController extends Controller {

    /**
     * @Route("", name="home")
     * @Template("PA036SocialNetworkBundle:Group:group.html.twig")
     */
    public function indexAction() {
        $username = $this->get('security.context')->getToken()->getUser()->getUsername();

        $em = $this->getDoctrine()->getEntityManager();
        $myGroups = $em->getRepository('PA036SocialNetworkBundle:Group')->getMyGroup($username);
        $myAdminGroups = $em->getRepository('PA036SocialNetworkBundle:Group')->getMyAdminGroup($username);
        
        $posts = $em->getRepository('PA036SocialNetworkBundle:Post')->findBy(array("parent" => null));

        $post = new Post();

        $form = $this->createFormBuilder($post)
                ->add('text', 'text')
                ->add('add', 'submit')
                ->getForm();
        
        return array('myGroups' => $myGroups, 'myAdminGroups' => $myAdminGroups, 'posts' => $posts, 'form_post_add' => $form->createView());
    }

}
