<?php

namespace PA036\SocialNetworkBundle\Service;

use PA036\SocialNetworkBundle\Entity\Conversation;
use PA036\SocialNetworkBundle\Entity\Message;
use PA036\AccountBundle\Entity\User;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 * User: V
 * Date: 3.5.2014
 * Time: 10:42
 */
class MessageService extends BaseService implements IMessageService
{

    private function createMessageMapping()
    {
        $rsm = new ResultSetMapping();

        $rsm->addEntityResult('PA036\SocialNetworkBundle\Entity\Message', 'm');
        $rsm->addFieldResult('m', 'message_id', 'messageId');
        $rsm->addFieldResult('m', 'body', 'body');
        $rsm->addFieldResult('m', 'timestamp', 'timestamp');
        $rsm->addMetaResult('m', 'member_id', 'member_id');

        return $rsm;
    }

    private function createConversationMapping()
    {
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
    function startConversation(User $user, $members, $messageBody, $conversationName = NULL)
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
        $params = array(':conversation_id' => $conversation->getConversationId());

        foreach ($users as $index => $user) {
            $user_id_param = ':user_id_' . $index;
            $query[] = "(:conversation_id, $user_id_param )";
            $params[$user_id_param] = $user->getUserId();
        }

        $query = $this->entityManager->createNativeQuery(
            'INSERT INTO conversation_members (conversation_id, user_id) VALUES ' . implode(", ", $query),
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
        $messages = array();
        foreach ($conversation->getMembers() as $member) {
            foreach ($member->getMessages() as $message) {
                $messages[] = $message;
            }
        }
        return $messages;
    }
}
