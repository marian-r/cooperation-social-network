<?php

namespace PA036\SocialNetworkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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

        $form = $this->createFormBuilder($group)
                ->add('groupId', 'hidden')
                ->add('name', 'text')
                ->add('description', 'textarea')
                ->add('edit', 'submit')
                ->add('remove', 'submit')
                ->getForm();

        $form->handleRequest($request);

        if ($request->isMethod('POST')) {
            if ($form->isValid()) {
                $group = $form->getData();
	            $this->getGroupService()->saveGroup($group);

                $response['status'] = "true";

                return new Response(json_encode_ex($response));
            }
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/remove", name="group_remove")
     * @Template()
     */
    public function removeAction(Request $request) {
	    $groupId = $request->request->get("id");
	    $group = $this->findGroupById($groupId);

        if ($request->isMethod('POST')) {
	        // TODO: remove
	        $em = $this->getDoctrine()->getManager();
            $em->remove($group);
            $em->flush();

            $response['status'] = "true";

            return new Response(json_encode_ex($response));
        }
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
	    $this->getGroupService()->leaveGroup($this->getUser());
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
