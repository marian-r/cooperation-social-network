<?php

namespace PA036\SocialNetworkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use PA036\SocialNetworkBundle\Entity\Group;

/**
 * @Route("/group")
 */
class GroupController extends Controller {

    /**
     * @Route("/add", name="group_add")
     * @Template()
     */
    public function addAction(Request $request) {
        $username = $this->get('security.context')->getToken()->getUser()->getUsername();

        $em = $this->getDoctrine()->getManager();

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
                if ($em->getRepository('PA036SocialNetworkBundle:Group')->addGroup($group, $username)) {
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
        $em = $this->getDoctrine()->getEntityManager();

        $group = new Group();

        $groupId = $request->query->get("groupId");

        if ($groupId != null) {
            $em = $this->getDoctrine()->getEntityManager();
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

        $em = $this->getDoctrine()->getEntityManager();
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

        $em = $this->getDoctrine()->getEntityManager();
        $groups = $em->getRepository('PA036SocialNetworkBundle:Group')->getMyGroup($username);

        $response['groups'] = $groups;

        return new Response(json_encode($response));
    }

    /**
     * @Route("/my/admin", name="group_my_admin")
     */
    public function myAdminAction() {
        $username = $this->get('security.context')->getToken()->getUser()->getUsername();

        $em = $this->getDoctrine()->getEntityManager();
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

        $em = $this->getDoctrine()->getEntityManager();
        $leave = $em->getRepository('PA036SocialNetworkBundle:Group')->leaveGroup($username, $request->query->get("groupId"));

        if ($leave) {
            $response['status'] = "true";
        } else {
            $response['status'] = "false";
        }

        return new Response(json_encode($response));
    }

    /**
     * @Route("/{groupId}", name="group")
     * @Template("PA036SocialNetworkBundle:Group:group.html.twig")
     */
    public function groupAction($groupId) {
        $username = $this->get('security.context')->getToken()->getUser()->getUsername();

        $em = $this->getDoctrine()->getEntityManager();
        $myGroups = $em->getRepository('PA036SocialNetworkBundle:Group')->getMyGroup($username);
        $myAdminGroups = $em->getRepository('PA036SocialNetworkBundle:Group')->getMyAdminGroup($username);
        
        $group = $em->getRepository('PA036SocialNetworkBundle:Group')->findBy(array("groupId" => $groupId));
        $posts = $em->getRepository('PA036SocialNetworkBundle:Post')->findBy(array("parent" => null, "group" => $group));
        
        return array('myGroups' => $myGroups, 'myAdminGroups' => $myAdminGroups, 'posts' => $posts, "groupId" => $groupId);
    }

}
