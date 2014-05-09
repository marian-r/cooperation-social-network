<?php
/**
 * User: V. Jurenka
 * Date: 9.5.2014
 * Time: 11:18
 */

namespace PA036\SocialNetworkBundle\Form;

use Symfony\Component\Form\DataTransformerInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\Exception\UnexpectedTypeException;

use Doctrine\Common\Collections\Collection;

class UsersToIdsTransformer  implements DataTransformerInterface
{
    public $em;

    public function transform($users)
    {
        if (null === $users) {
            return "";
        }
        if (!$users instanceof Collection) {
            throw new UnexpectedTypeException($users, ' Doctrine\Common\Collections\Collection');
        }
        $idsArray = array();
        foreach ($users as $user) {
            $idsArray[] = $user->getUserId();
        }
        $ids = implode(",", $idsArray);
        return $ids;
    }

    public function reverseTransform($ids)
    {
        $users = new ArrayCollection();

        if ('' === $ids || null === $ids) {
            return $users;
        }

        if (!is_string($ids)) {
            throw new UnexpectedTypeException($ids, 'string');
        }

        $idsArray = explode(",", $ids);
        $idsArray = array_filter ($idsArray, 'is_numeric');
        foreach ($idsArray as $id) {
            $user = $this->em->getRepository('PA036\AccountBundle\Entity\User')->findOneBy(array('userId' => $id));
            $users->add($user);
        }
        return $users;
    }
}
