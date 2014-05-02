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
class GroupController extends Controller {

    /**
     * @Route("/add", name="group_add")
     * @Template()
     */
    public function addAction(Request $request) {
        $user = $this->get('security.context')->getToken()->getUser();
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
                $service = $this->get('pa036_social_network.service.group');

                if ($service->addGroup($group, $user)) {
                    $response['status'] = "true";
                } else {
                    $response['status'] = "false";
                }
                return new Response(json_encode($response));
            }
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/edit", name="group_edit")
     * @Template()
     */
    public function editAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $group = new Group();

        $groupId = $request->query->get("groupId");

        if ($groupId != null) {
            $em = $this->getDoctrine()->getManager();
            $group = $em->getRepository('PA036SocialNetworkBundle:Group')->findOneBy(array("groupId" => $groupId));
        }

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
                $em = $this->getDoctrine()->getManager();
                $em->merge($group);
                $em->flush();

                $response['status'] = "true";

                return new Response(json_encode($response));
            }
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/remove", name="group_remove")
     * @Template()
     */
    public function removeAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $group = $em->getRepository('PA036SocialNetworkBundle:Group')->findOneBy(array("groupId" => $request->request->get("id")));

        if ($request->isMethod('POST')) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($group);
            $em->flush();

            $response['status'] = "true";

            return new Response(json_encode($response));
        }
    }

    /**
     * @Route("/my", name="group_my")
     */
    public function myAction() {
        $username = $this->get('security.context')->getToken()->getUser()->getUsername();

        $em = $this->getDoctrine()->getManager();
        $groups = $em->getRepository('PA036SocialNetworkBundle:Group')->getMyGroup($username);

        $response['groups'] = $groups;

        return new Response(json_encode($response));
    }

    /**
     * @Route("/my/admin", name="group_my_admin")
     */
    public function myAdminAction() {
        $username = $this->get('security.context')->getToken()->getUser()->getUsername();

        $em = $this->getDoctrine()->getManager();
        $groups = $em->getRepository('PA036SocialNetworkBundle:Group')->getMyAdminGroup($username);

        $response['groups'] = $groups;

        return new Response(json_encode($response));
    }

    /**
     * @Route("/leave", name="group_leave")
     */
    public function leaveAction(Request $request) {
        $username = $this->get('security.context')->getToken()->getUser()->getUsername();

        $response = array();

        $em = $this->getDoctrine()->getManager();
        $leave = $em->getRepository('PA036SocialNetworkBundle:Group')->leaveGroup($username, $request->query->get("groupId"));

        if ($leave) {
            $response['status'] = "true";
        } else {
            $response['status'] = "false";
        }

        return new Response(json_encode($response));
    }

    /**
     * @Route("/{group_id}", name="group")
     * @Template("PA036SocialNetworkBundle:Group:group.html.twig")
     */
    public function groupAction($group_id) {
        $post = new Post();

        $form = $this->createFormBuilder($post)
                ->add('text', 'text')
                ->add('add', 'submit')
                ->getForm();

        return array('form_post_add' => $form->createView());
    }

}
