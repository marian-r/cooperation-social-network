<?php

namespace PA036\AccountBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class SecurityController extends Controller {

    /**
     * @Route("/login", name="login")
     * @Template()
     */
    public function loginAction(Request $request) {
        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_ANONYMOUSLY')) {
//            return $this->redirect($this->generateUrl('_iprobe_log'));
        }
        
        $session = $request->getSession();

        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                    SecurityContext::AUTHENTICATION_ERROR
            );
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render(
                        'PA036AccountBundle:Security:login.html.twig', array(
                    // last username entered by the user
                    'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                    'error' => $error,
                        )
        );
    }

    /**
     * @Route("/login_check", name="login_check")
     */
    public function securityCheckAction() {
        // The security layer will intercept this request
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction() {
        // The security layer will intercept this request
    }
}
