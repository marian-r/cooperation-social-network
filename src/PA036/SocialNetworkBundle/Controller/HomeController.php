<?php

namespace PA036\SocialNetworkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PA036\SocialNetworkBundle\Entity\Post;

class HomeController extends BaseController
{
    /**
     * @Route("", name="home")
     * @Template("PA036SocialNetworkBundle:Group:group.html.twig")
     */
    public function indexAction() {
        $form = $this->createFormBuilder(new Post())
                ->add('text', 'text')
                ->add('add', 'submit')
                ->getForm();
        
        return array(
		        'form_post_add' => $form->createView()
        );
    }
}
