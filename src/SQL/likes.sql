-- ******************************
-- SQL script for managing likes
-- ******************************


CREATE OR REPLACE FUNCTION add_like(user_id int, post_id int) RETURNS likes AS $$
DECLARE
  like likes%ROWTYPE;
BEGIN

  INSERT INTO likes (user_id, post_id, "timestamp")
  VALUES (user_id, post_id, NOW()) RETURNING * INTO like;

  RETURN like;
END;
$$ LANGUAGE plpgsql;