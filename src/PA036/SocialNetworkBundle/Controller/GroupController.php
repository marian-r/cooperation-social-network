<?php

namespace PA036\SocialNetworkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/group")
 */
class GroupController extends Controller {

    /**
     * @Route("/", name="group_list")
     * @Template()
     */
    public function listAction() {
        return array('name' => "xxx");
    }

}
