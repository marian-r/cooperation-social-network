<?php

namespace PA036\SocialNetworkBundle\Service;

use PA036\SocialNetworkBundle\Model\Domain\BaseService;
use Doctrine\Common\Collections\ArrayCollection;
use PA036\SocialNetworkBundle\Entity\Conversation;
use PA036\SocialNetworkBundle\Entity\Message;
use PA036\AccountBundle\Entity\User;
use Doctrine\ORM\Query\ResultSetMapping;
use PA036\SocialNetworkBundle\Model\Domain\IMessageService;

/**
 * User: V
 * Date: 3.5.2014
 * Time: 10:42
 */
class MessageService extends BaseService implements IMessageService
{

    private function createMessageMapping()
    {
        //todo finish mapping
        $rsm = new ResultSetMapping();

        $rsm->addEntityResult('PA036\SocialNetworkBundle\Entity\Message', 'm');
        ///  $rsm->addFieldResult('p', 'post_id', 'postId');
//        $rsm->addFieldResult('p', 'text', 'text');

//        $rsm->addMetaResult('p', 'group_id', 'group_id');
        return $rsm;
    }

    private function createConversationMapping()
    {
        //todo finish mapping
        $rsm = new ResultSetMapping();

        $rsm->addEntityResult('PA036\SocialNetworkBundle\Entity\Conversation', 'c');
        $rsm->addFieldResult('c', 'conversation_id', 'conversationId');
        $rsm->addFieldResult('c', 'name', 'name');

        $rsm->addMetaResult('c', 'conversation_id', 'conversation_id');
        return $rsm;
    }


    /**
     * @param User $user
     * @param User[] $members
     * @param string $messageBody
     * @param string $conversationName
     * @return Conversation
     */
    function startConversation(User $user, $members, $messageBody, $conversationName = '')
    {
        $member_ids = array();

        if (is_array($members)) {
            foreach ($members as $member) {
                $member_ids[] = $member->getUserId();
            }
        }

        $query = $this->entityManager->createNativeQuery(
            'select * from start_conversation( :user_id, :member_ids, :conversation_name, :message_body)',
            $this->createConversationMapping()
        );
        $query->setParameter(":user_id", $user->getUserId());
        $query->setParameter(":member_ids", "{ " . implode(",", $member_ids) . " }");
        $query->setParameter(":conversation_name", $conversationName);
        $query->setParameter(":message_body", $messageBody);

        return $query->getSingleResult();
    }

    /**
     * @param Conversation $conversation
     * @param User[] $users
     * @return void
     */
    function addUsersToConversation(Conversation $conversation, $users)
    {
        if (empty($users)) {
            return;
        }

        $query = array();
        $params = new ArrayCollection();

        foreach ($users as $index => $user) {
            $user_id_param = ':user_id_' . $index;
            $query[] = "(:conversation_id, $user_id_param )";
            $params->set($user_id_param, $user->getUserId());
        }

        $query = $this->entityManager->createNativeQuery(
            'INSERT INTO `conversation_members` (conversation_id, user_id) VALUES ' . implode(", ", $query),
            new ResultSetMapping()
        );
        $query->setParameters($params);

        $result = $query->getResult();
    }

    /**
     * @param User $user
     * @param Conversation $conversation
     * @param string $messageBody
     * @param array $files
     * @return Message
     */
    function sendMessage(User $user, Conversation $conversation, $messageBody, $files = array())
    {
        $query = $this->entityManager->createNativeQuery(
            'select * from send_message(:user_id, :conversation_id, :message_body)',
            $this->createMessageMapping()
        );
        $query->setParameter(":user_id", $user->getUserId());
        $query->setParameter(":conversation_id", $conversation->getConversationId());
        $query->setParameter(":message_body", $messageBody);

        return $query->getSingleResult();
    }

    /**
     * @param Conversation $conversation
     * @return Message[]
     */
    function findMessagesByConversation(Conversation $conversation)
    {
        return
            $this->entityManager->getRepository('PA036\SocialNetworkBundle\Entity\Message')->findBy(
                array(
                    'Conversation' => $conversation ? $conversation->getConversationId() : null
                )
            );
    }
}
