<?php
/**
 * User: V
 * Date: 2.5.2014
 * Time: 16:26
 */
namespace PA036\SocialNetworkBundle\Service;

use \PA036\SocialNetworkBundle\Model\Domain\BaseService;
use PA036\AccountBundle\Entity\User;
use PA036\SocialNetworkBundle\Entity\Group;
use Doctrine\ORM\Query\ResultSetMapping;
use \PA036\SocialNetworkBundle\Model\Domain\IGroupService;

class GroupService extends BaseService implements IGroupService
{

    private function createGroupMapping(){
        $rsm = new ResultSetMapping();

        $rsm->addEntityResult('PA036\SocialNetworkBundle\Entity\Group', 'g');
        $rsm->addFieldResult('g', 'group_id', 'groupId');
        $rsm->addFieldResult('g', 'name', 'name');
        $rsm->addFieldResult('g', 'description', 'description');

        return $rsm;
    }

    /**
     * @param Group $group
     * @param User $user
     * @return Group
     */
    function addGroup(Group $group, User $user)
    {

        $query = $this->entityManager->createNativeQuery(
            'select * from create_group( :admin_id, :members, :name, :description)',
            $this->createGroupMapping()
        );
        $query->setParameter(":admin_id", $user->getUserId());
        $query->setParameter(":members", "{" . $user->getUserId() . "}");
        $query->setParameter(":name", $group->getName());
        $query->setParameter(":description", $group->getDescription());

        $groups =  $query->getResult();
        return count($groups) ? $groups[0] : null;
    }

    /**
     * @param Group $group
     * @return void
     */
    function saveGroup(Group $group)
    {
        $this->entityManager->persist($group);
    }

    /**
     * @param Group $group
     * @param User $user
     * @return void
     */
    function joinGroup(Group $group, User $user)
    {
        $rsm = new ResultSetMapping();

        $query = $this->entityManager->createNativeQuery(
            'select *from add_member( :group_id, :user_id)',
            $this->createGroupMapping()
        );
        $query->setParameter(":group_id", $group->getGroupId());
        $query->setParameter(":user_id", $user->getUserId());

        $group = $query->getResult();
    }

    /**
     * @param Group $group
     * @param User $user
     * @return void
     */
    function leaveGroup(Group $group, User $user)
    {
        $rsm = new ResultSetMapping();

        $query = $this->entityManager->createNativeQuery(
            'select *from delete_member( :group_id, :user_id)',
            $this->createGroupMapping()
        );
        $query->setParameter(":group_id", $group->getGroupId());
        $query->setParameter(":user_id", $user->getUserId());

        $group = $query->getResult();
    }
}
