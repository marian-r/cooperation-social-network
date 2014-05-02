<?php
/**
 * User: V
 * Date: 2.5.2014
 * Time: 16:26
 */
namespace PA036\SocialNetworkBundle\Services;

use \PA036\SocialNetworkBundle\Model\Domain\BaseService;
use PA036\AccountBundle\Entity\User;
use PA036\SocialNetworkBundle\Entity\Group;
use Doctrine\ORM\Query\ResultSetMapping;
use \PA036\SocialNetworkBundle\Model\Domain\IGroupService;

class GroupService extends BaseService implements IGroupService
{

    /**
     * @param Group $group
     * @param User $user
     * @return Group
     */
    function addGroup(Group $group, User $user)
    {
        $rsm = new ResultSetMapping();

        $query = $this->entityManager->createNativeQuery('select create_group( :admin_id, :members, :name, :description)', $rsm);
        $query->setParameter(":admin_id", $user->getUserId());
        $query->setParameter(":members", "{" . implode(",", array($user->getUserId())) . "}");
        $query->setParameter(":name", $group->getName());
        $query->setParameter(":description", $group->getDescription());

        return $query->getResult();
    }

    /**
     * @param Group $group
     * @return void
     */
    function saveGroup(Group $group)
    {

    }

    /**
     * @param Group $group
     * @param User $user
     * @return void
     */
    function joinGroup(Group $group, User $user)
    {
        // TODO: Implement joinGroup() method.
    }

    /**
     * @param Group $group
     * @param User $user
     * @return void
     */
    function leaveGroup(Group $group, User $user)
    {
        // TODO: Implement leaveGroup() method.
    }
}
