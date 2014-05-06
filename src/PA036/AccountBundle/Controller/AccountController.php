<?php

namespace PA036\AccountBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PA036\AccountBundle\Entity\User;
use PA036\AccountBundle\Form\Model\ChangePassword;
use PA036\AccountBundle\Form\Type\ChangePasswordType;

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
                    'options' => array('attr' => array('class' => 'password-field input-block-level')),
                    'required' => true,
                    'first_options' => array('label' => 'Password'),
                    'second_options' => array('label' => 'Repeat Password'),
                ))
                ->add('register', 'submit')
                ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $user = $form->getData();
            $user->setLastLogin(new \DateTime(date('Y-m-d H:i:s')));
            
            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($user);
            $password = $encoder->encodePassword($user->getPassword(), $user->getSalt());
            $user->setPassword($password);
            
            $this->get('pa036_account.service.user')->saveUser($user);

            return $this->redirect($this->generateUrl('login'));
        }

        return $this->render('PA036AccountBundle:Account:register.html.twig',
		        array('form' => $form->createView())
        );
    }

    /**
     * @Route("/account/edit", name="account_edit")
     * @Template()
     */
    public function editAction(Request $request) {
	    $userService = $this->get('pa036_account.service.user');

	    $username = $this->get('security.context')->getToken()->getUser()->getUsername();
        $info = array();

        $user = $this->getDoctrine()
		        ->getManager()
		        ->getRepository('PA036AccountBundle:User')
		        ->loadUserByUsername($username);

        $form_account = $this->createFormBuilder($user)
                ->add('firstName', 'text')
                ->add('lastName', 'text')
                ->add('change', 'submit')
                ->getForm();

        $form_account->handleRequest($request);

        if ($request->isMethod('POST') && $form_account->isValid()) {
            $user_edit = $form_account->getData();
	        $userService->saveUser($user_edit);

	        $info['account_change_success'] = 'Account Informations Successfully Changed.';
        }

        $changePasswordModel = new ChangePassword();
        $form_pass = $this->createForm(new ChangePasswordType(), $changePasswordModel);

        $form_pass->handleRequest($request);

        if ($form_pass->isSubmitted() && $form_pass->isValid()) {

            $changePassword = $form_pass->getData();

            $encoder = $this->get('security.encoder_factory')->getEncoder($user);
            $password = $encoder->encodePassword($changePassword->getNewPassword(), $user->getSalt());
            $user->setPassword($password);

	        $userService->saveUser($user);

            $info['account_change_pass_success'] = 'Password Successfully Changed.';
        }

        return array('form_account_edit' => $form_account->createView(), 'form_password_edit' => $form_pass->createView(), "info" => $info);
    }

}
