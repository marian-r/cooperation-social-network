-- *************************
-- SQL for managing posts
-- *************************

CREATE OR REPLACE FUNCTION add_post(parent_id int, group_id int, user_id int, post_text varchar) RETURNS posts AS $$
DECLARE
  post posts%ROWTYPE;
BEGIN

  INSERT INTO posts (parent_id, group_id, user_id, text, "timestamp", likes_count, seens_count)
  VALUES (parent_id, group_id, user_id, post_text, cast (NOW() as timestamp(0)),0,0) RETURNING * INTO post;

  RETURN post;
END;
$$ LANGUAGE plpgsql;

