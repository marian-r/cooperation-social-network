<?php

namespace PA036\SocialNetworkBundle\Entity;

use Doctrine\ORM\EntityRepository;

class GroupRepository extends EntityRepository {

    function addGroup($group, $username) {
        $em = $this->getEntityManager();

        $user = $em->getRepository('PA036AccountBundle:User')->loadUserByUsername($username);

        $em->persist($group);
        $em->flush();

        $userGroupMap = new UserGroupMap();
        $userGroupMap->setUser($user);
        $userGroupMap->setIsAdmin(true);
        $userGroupMap->setGroup($group);

        $em->persist($userGroupMap);
        $em->flush();

        return true;
    }

    function getMyGroup($username) {
        $cb = $this->getEntityManager()->createQueryBuilder();

        $query = $cb
                ->select('g.groupId AS groupId, g.name AS name, g.description AS description, userGroupMap.isAdmin AS isAdmin')
                ->from('PA036\SocialNetworkBundle\Entity\UserGroupMap', 'userGroupMap')
                ->join('userGroupMap.user', 'u')
                ->join('userGroupMap.group', 'g')
                ->where('u.email = :email AND userGroupMap.isAdmin = :isAdmin')
                ->setParameters(array("email" => $username, "isAdmin" => false));

        return $query->getQuery()->getResult();
    }

    function getMyAdminGroup($username) {
        $cb = $this->getEntityManager()->createQueryBuilder();

        $query = $cb
                ->select('g.groupId, g.name, g.description, userGroupMap.isAdmin')
                ->from('PA036\SocialNetworkBundle\Entity\UserGroupMap', 'userGroupMap')
                ->join('userGroupMap.user', 'u')
                ->join('userGroupMap.group', 'g')
                ->where('u.email = :email AND userGroupMap.isAdmin = :isAdmin')
                ->setParameters(array("email" => $username, "isAdmin" => true));

        return $query->getQuery()->getResult();
    }

    function leaveGroup($username, $groupId) {
//        $cb = $this->getEntityManager()->createQueryBuilder();
//
//        $query = $cb
//                ->select('g.groupId, g.name, g.description, userGroupMap.isAdmin')
//                ->from('PA036\SocialNetworkBundle\Entity\UserGroupMap', 'userGroupMap')
//                ->join('userGroupMap.user', 'u')
//                ->join('userGroupMap.group', 'g')
//                ->where('u.email = :email AND userGroupMap.isAdmin = :isAdmin')
//                ->setParameters(array("email" => $username, "isAdmin" => true));
        $em = $this->getEntityManager();

        $user = $em->getRepository('PA036AccountBundle:User')->loadUserByUsername($username);
        $group = $em->getRepository('PA036SocialNetworkBundle:Group')->findOneBy(array("groupId" => $groupId));
        $userGroupMap = $em->getRepository('PA036SocialNetworkBundle:UserGroupMap')->findOneBy(array("user" => $user, "group" => $group));
        
        $em->remove($userGroupMap);
        $em->flush();
        
        return true;
    }

}