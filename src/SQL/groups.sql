-- *************************
-- SQL for managing groups
-- *************************



CREATE OR REPLACE FUNCTION create_group(admin_id int, members int[], group_name varchar, description varchar) RETURNS groups AS $$
DECLARE
  members_valid int[];
  gr_id int;
  mem_id int;
  my_group groups%ROWTYPE;
  member users%ROWTYPE;
BEGIN

  INSERT INTO groups (name, description) VALUES (group_name, description) RETURNING * INTO my_group;
  gr_id = my_group.group_id;

  FOR member IN (SELECT * FROM users u WHERE u.user_id = ANY(members)) LOOP
    INSERT INTO user_group_map (user_id, group_id, is_admin) VALUES (member.user_id, gr_id, false);
  END LOOP;

  UPDATE user_group_map
  SET is_admin=true
  WHERE user_id=admin_id AND group_id=gr_id;

  RETURN my_group;
END;
$$ LANGUAGE plpgsql;




CREATE OR REPLACE FUNCTION add_member(group_id int, member_id int) RETURNS groups AS $$
DECLARE
  my_group groups%ROWTYPE;
  member users%ROWTYPE;
BEGIN

 INSERT INTO user_group_map (user_id, group_id, is_admin) VALUES (member_id, group_id, false) RETURNING * INTO my_group;

  RETURN my_group;
END;
$$ LANGUAGE plpgsql;



CREATE OR REPLACE FUNCTION delete_member(my_group_id int, member_id int) RETURNS groups AS $$
DECLARE
  my_group groups%ROWTYPE;
  member users%ROWTYPE;
BEGIN

  DELETE FROM user_group_map
  WHERE user_id=member_id AND user_group_map.group_id=my_group_id
  RETURNING * INTO my_group;

  RETURN my_group;
END;
$$ LANGUAGE plpgsql;