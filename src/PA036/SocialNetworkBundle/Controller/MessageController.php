<?php
/**
 * User: V. Jurenka
 * Date: 8.5.2014
 * Time: 11:40
 */
namespace PA036\SocialNetworkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use PA036\SocialNetworkBundle\Form\UsersToIdsTransformer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use PA036\SocialNetworkBundle\Entity\Conversation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PA036\SocialNetworkBundle\Entity\Message;

class MessageController extends BaseController
{

    /**
     * @Route("/add", name="new_conversation")
     * @Template()
     */
    public function addAction(Request $request) {
        $conversation = new Conversation();

        $transformer = new UsersToIdsTransformer();
        $transformer->em = $this->getDoctrine()->getManager();

        $builder = $this->createFormBuilder($conversation)
            ->add('name', 'text')->add('initialMessage', 'textarea');
        $builder->add(
            $builder->create('members', 'text', array(
                'required' => false,
                'mapped' => false
            ))->addModelTransformer($transformer)
        );

        $builder->add('add', 'submit');

        $form = $builder->getForm();

        $form->handleRequest($request);

        if ($request->isMethod('POST')) {
            if ($form->isValid()) {
                $conversation = $form->getData();
                $service = $this->getMessageService();


                $members = array();
                if(!empty($_POST['form']['members'])){
                    foreach(explode(',',$_POST['form']['members']) as $user_id){
                        $members[] = $this->findUserById($user_id);
                    }
                }

                if ($service->startConversation($this->getUser(), $members, $conversation->getInitialMessage(), $conversation->getName())) {
                    $response['status'] = "true";
                } else {
                    $response['status'] = "false";
                }
                return new Response(json_encode_ex($response));
            }
        }

        return array('form' => $form->createView());
    }
}