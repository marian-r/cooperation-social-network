<?php

namespace PA036\SocialNetworkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use PA036\SocialNetworkBundle\Form\UsersToIdsTransformer;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use PA036\SocialNetworkBundle\Entity\Group;
use PA036\SocialNetworkBundle\Entity\Post;


/**
 * @Route("/group")
 */
class GroupController extends BaseController {

    /**
     * @Route("/add", name="group_add")
     * @Template()
     */
    public function addAction(Request $request) {
        $group = new Group();
        $form = $this->createFormBuilder($group)
                ->add('name', 'text')
                ->add('description', 'textarea')
                ->add('add', 'submit')
                ->getForm();

        $form->handleRequest($request);

        if ($request->isMethod('POST')) {
            if ($form->isValid()) {
                $group = $form->getData();
                $service = $this->getGroupService();

                if ($service->addGroup($group, $this->getUser())) {
                    $response['status'] = "true";
                } else {
                    $response['status'] = "false";
                }
                return new Response(json_encode_ex($response));
            }
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/edit", name="group_edit")
     * @Template()
     */
    public function editAction(Request $request) {
        $groupId = $request->query->get("groupId");
	    $group = ($groupId !== NULL) ? $this->findGroupById($groupId) : new Group();

        $transformer = new UsersToIdsTransformer();
        $transformer->em = $this->getDoctrine()
            ->getManager();

        $builder = $this->createFormBuilder($group)
                ->add('name', 'text')
                ->add('description', 'textarea');

        $builder->add(
            $builder->create('users', 'text', array(
                'required' => false,
                'mapped' => false
            ))->addModelTransformer($transformer)
        );

        $builder->add('edit', 'submit')->add('remove', 'submit');

        $form = $builder->getForm();
        $form->handleRequest($request);

        if ($request->isMethod('POST')) {
            if ($form->isValid()) {
                $group = $form->getData();
	            $this->getGroupService()->saveGroup($group);


                $old_users = $group->getUsers();
                $old_user_ids = array();
                foreach($old_users as $old_user){
                    $old_user_ids[] = $old_user->getUserId();
                }
                $new_user_ids = array();
                if(!empty($_POST['form']['users'])){
                    foreach(explode(',',$_POST['form']['users']) as $user_id){
                        $key = array_search(intval($user_id), $old_user_ids);
                        if($key !== FALSE){
                            unset($old_user_ids[$key]);
                        }
                        else{
                           $new_user_ids[] = $user_id;
                        }
                    }
                }

                foreach($old_user_ids as $removed_user_id){
                    $this->getGroupService()->leaveGroup($group, $this->findUserById($removed_user_id));
                }
                foreach($new_user_ids as $new_user_id){
                    $this->getGroupService()->joinGroup($group, $this->findUserById($new_user_id));
                }

                $response['status'] = "true";

                return new Response(json_encode_ex($response));
            }
        }

        $members = array();
        foreach($group->getUsers() as $user){
            $members[] = array(
                'id' => $user->getUserId(),
                'name' => $user->getFirstName() .' '.$user->getLastName(),
            );
        }
        $members = json_encode_ex($members);

        return array('form' => $form->createView(), 'members' => $members ,'id' => $groupId);
    }

    /**
     * @Route("/remove", name="group_remove")
     * @Template()
     */
    public function removeAction(Request $request) {
	    $groupId = $request->request->get("id");
	    $group = $this->findGroupById($groupId);

        if ($request->isMethod('POST')) {
	        $em = $this->getDoctrine()->getManager();
            $em->remove($group);
            $em->flush();

            $response['status'] = "true";
            return new Response(json_encode_ex($response));
        }
    }

    /**
     * @Route("/user_list", name="user_list")
     */
    public function userListAction(Request $request)
    {
        $value = $request->get('q');
        $users = $this->getDoctrine()
            ->getManager()
            ->getRepository("PA036AccountBundle:User")
            ->createQueryBuilder('u')
            ->where('u.firstName LIKE :q')
            ->orWhere('u.lastName LIKE :q')
            ->setParameter('q', $value.'%')
            ->getQuery()
            ->getResult();

        $json = array();
        foreach ($users as $user) {
            $json[] = array(
                'id' => $user->getUserId(),
                'name' => $user->getFirstName() .' '.$user->getLastName(),
            );
        }

        $response = new Response();
        $response->setContent(json_encode_ex($json));

        return $response;
    }

    /**
     * @Route("/my", name="group_my")
     */
    public function myAction() {
	    $response['groups'] = $this->getUser()->getGroups();
        return new Response(json_encode_ex($response));
    }

    /**
     * @Route("/my/admin", name="group_my_admin")
     */
    public function myAdminAction() {
	    $response['groups'] = $this->getUser()->getAdminGroups();
        return new Response(json_encode_ex($response));
    }

    /**
     * @Route("/leave", name="group_leave")
     */
    public function leaveAction(Request $request) {
        $group_id = $request->query->get("groupId");
	    $this->getGroupService()->leaveGroup($this->findGroupById($group_id), $this->getUser());
        $response = array('status' => "true");
        return new Response(json_encode_ex($response));
    }

    /**
     * @Route("/{group_id}", name="group")
     * @Template("PA036SocialNetworkBundle:Group:group.html.twig")
     */
    public function groupAction($group_id) {
        $form = $this->createFormBuilder(new Post())
                ->add('text', 'text')
                ->add('add', 'submit')
                ->getForm();

        return array('form_post_add' => $form->createView());
    }


}
