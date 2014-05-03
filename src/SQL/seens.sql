-- ******************************
-- SQL script for managing seens
-- ******************************

CREATE OR REPLACE FUNCTION add_seen(user_id int, post_id int) RETURNS seens AS $$
DECLARE
  seen seens%ROWTYPE;
BEGIN

  INSERT INTO seens (user_id, post_id, "timestamp")
  VALUES (user_id, post_id, cast (NOW() as timestamp(0))) RETURNING * INTO seen;

  RETURN seen;
END;
$$ LANGUAGE plpgsql;


CREATE OR REPLACE FUNCTION update_seens() RETURNS TRIGGER AS $_$
BEGIN
  UPDATE posts
  SET seens_count=seens_count + 1
  WHERE posts.post_id=NEW.post_id;
    RETURN NEW;


END $_$ LANGUAGE 'plpgsql';


DROP TRIGGER IF EXISTS seen_added ON seens;

CREATE TRIGGER seen_added
AFTER INSERT ON seens
FOR EACH ROW EXECUTE PROCEDURE update_seens();