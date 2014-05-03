-- *************************
-- SQL for managing users
-- *************************

CREATE OR REPLACE FUNCTION add_user(email varchar, first_name varchar, last_name varchar, my_password varchar, description varchar) RETURNS users AS $$
DECLARE
  my_user users%ROWTYPE;
BEGIN

  INSERT INTO users (email, first_name, last_name, "password", last_login, description)
  VALUES (email, first_name, last_name, my_password, cast (NOW() as timestamp(0)), description) RETURNING * INTO my_user;

  RETURN my_user;
END;
$$ LANGUAGE plpgsql;