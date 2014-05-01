-- ******************************
-- SQL script for managing seens
-- ******************************

CREATE OR REPLACE FUNCTION add_seen(user_id int, post_id int) RETURNS seens AS $$
DECLARE
  seen seens%ROWTYPE;
BEGIN

  INSERT INTO seens (user_id, post_id, "timestamp")
  VALUES (user_id, post_id, NOW()) RETURNING * INTO seen;

  RETURN seen;
END;
$$ LANGUAGE plpgsql;
