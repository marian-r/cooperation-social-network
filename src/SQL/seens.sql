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


CREATE FUNCTION update_seens() RETURNS TRIGGER AS $_$
BEGIN
  UPDATE posts
  SET seens_count=seens_count + 1
  WHERE posts.post_id=NEW.post_id;
    RETURN NEW;


END $_$ LANGUAGE 'plpgsql';


CREATE TRIGGER seen_added
AFTER INSERT ON seens
FOR EACH ROW EXECUTE PROCEDURE update_seens();