<?php

namespace Symfony\Bundle\SecurityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class SecurityController extends Controller
{
    /**
     * @Route("/login")
     * @Template()
     */
    public function loginAction()
    {
    }

    /**
     * @Route("/test")
     * @Template()
     */
    public function testAction()
    {
    }

}
