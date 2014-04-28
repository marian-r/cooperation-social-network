-- *************************
-- SQL for managing messages
-- *************************

CREATE OR REPLACE FUNCTION start_conversation(user_id int, members int[], message_body varchar) RETURNS conversations AS $$
DECLARE
  members_valid int[];
  con_id int;
  mem_id int;
  conversation conversations%ROWTYPE;
  member users%ROWTYPE;
BEGIN

  INSERT INTO conversations (name) VALUES ('Sample name') RETURNING * INTO conversation;
  con_id = conversation.conversation_id;

  FOR member IN (SELECT * FROM users u WHERE u.user_id = ANY(members)) LOOP
    INSERT INTO conversation_members (conversation_id, user_id) VALUES (con_id, member.user_id);
  END LOOP;

  INSERT INTO conversation_members (conversation_id, user_id)
    VALUES (con_id, user_id) RETURNING member_id INTO mem_id;

  INSERT INTO messages (member_id, body, "timestamp") VALUES (mem_id, message_body, NOW());

  RETURN conversation;
END;
$$ LANGUAGE plpgsql;
