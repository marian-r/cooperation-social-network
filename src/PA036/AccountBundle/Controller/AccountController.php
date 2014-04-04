<?php

namespace PA036\AccountBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PA036\AccountBundle\Entity\User;

class AccountController extends Controller {

    /**
     * @Route("/register", name="account_register")
     * @Template()
     */
    public function registerAction(Request $request) {
        $user = new User();
        $form = $this->createFormBuilder($user)
                ->add('firstName', 'text')
                ->add('lastName', 'text')
                ->add('email', 'text')
                ->add('password', 'repeated', array(
                    'type' => 'password',
                    'options' => array('attr' => array('class' => 'password-field')),
                    'required' => true,
                    'first_options' => array('label' => 'Password'),
                    'second_options' => array('label' => 'Repeat Password'),
                ))
                ->add('register', 'submit')
                ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $user = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirect($this->generateUrl('login'));
        }

        return $this->render(
                        'PA036AccountBundle:Account:register.html.twig', array('form' => $form->createView())
        );
    }
}
