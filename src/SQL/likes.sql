-- ******************************
-- SQL script for managing likes
-- ******************************


CREATE OR REPLACE FUNCTION add_like(user_id int, post_id int) RETURNS likes AS $$
DECLARE
  like_row likes%ROWTYPE;
BEGIN

  INSERT INTO likes (user_id, post_id, "timestamp")
  VALUES (user_id, post_id, cast (NOW() as timestamp(0))) RETURNING * INTO like_row;

  RETURN like_row;
END;
$$ LANGUAGE plpgsql;


CREATE OR REPLACE FUNCTION update_likes() RETURNS TRIGGER AS $$
BEGIN
  UPDATE posts
  SET likes_count=likes_count + 1
  WHERE posts.post_id=NEW.post_id;
    RETURN NEW;


END;
$$ LANGUAGE plpgsql;


DROP TRIGGER IF EXISTS like_added ON likes;

CREATE TRIGGER like_added
AFTER INSERT ON likes
FOR EACH ROW EXECUTE PROCEDURE update_likes();