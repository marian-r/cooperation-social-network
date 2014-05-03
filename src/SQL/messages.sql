-- *************************
-- SQL for managing messages
-- *************************

CREATE OR REPLACE FUNCTION start_conversation(user_id int, members int[], conversation_name varchar, message_body varchar) RETURNS conversations AS $$
DECLARE
  members_valid int[];
  con_id int;
  mem_id int;
  conversation conversations%ROWTYPE;
  member users%ROWTYPE;
BEGIN

  INSERT INTO conversations (name) VALUES (conversation_name) RETURNING * INTO conversation;
  con_id = conversation.conversation_id;

  FOR member IN (SELECT * FROM users u WHERE u.user_id = ANY(members)) LOOP
    INSERT INTO conversation_members (conversation_id, user_id) VALUES (con_id, member.user_id);
  END LOOP;

  INSERT INTO conversation_members (conversation_id, user_id)
    VALUES (con_id, user_id) RETURNING member_id INTO mem_id;

  INSERT INTO messages (member_id, body, "timestamp") VALUES (mem_id, message_body, cast (NOW() as timestamp(0)));

  RETURN conversation;
END;
$$ LANGUAGE plpgsql;




CREATE OR REPLACE FUNCTION send_message(sender_id int, con_id int, message_body varchar) RETURNS messages AS $$
DECLARE
  mem_id int;
  message messages%ROWTYPE;
BEGIN

  SELECT member_id
  FROM conversation_members
  WHERE user_id=sender_id AND conversation_id=con_id
  INTO mem_id;


  INSERT INTO messages (member_id, body, "timestamp") VALUES (mem_id, message_body, cast (NOW() as timestamp(0))) RETURNING * INTO message;

  RETURN message;
END;
$$ LANGUAGE plpgsql;