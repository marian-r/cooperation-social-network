-- ******************************
-- SQL script for creating tables
-- ******************************


-- clear existing
DROP TABLE IF EXISTS "users" CASCADE;
DROP TABLE IF EXISTS "groups" CASCADE;
DROP TABLE IF EXISTS "user_group_map" CASCADE;
DROP TABLE IF EXISTS "posts" CASCADE;
DROP TABLE IF EXISTS "attachments" CASCADE;
DROP TABLE IF EXISTS "likes" CASCADE;
DROP TABLE IF EXISTS "conversations" CASCADE;
DROP TABLE IF EXISTS "conversation_members" CASCADE;
DROP TABLE IF EXISTS "messages" CASCADE;
DROP TABLE IF EXISTS "attachment_types" CASCADE;
DROP TABLE IF EXISTS "seens" CASCADE;


-- tables
CREATE TABLE "users" (
  "user_id"     SERIAL NOT NULL,
  "email"       varchar(80) NOT NULL UNIQUE, 
  "first_name"  varchar(50) NOT NULL, 
  "last_name"   varchar(50) NOT NULL, 
  "password"    varchar(255) NOT NULL, 
  "last_login"  timestamp NOT NULL, 
  "description" text, 
  PRIMARY KEY ("user_id")
);

CREATE TABLE "groups" (
  "group_id"    SERIAL NOT NULL,
  "name"        varchar(50) NOT NULL UNIQUE, 
  "description" text, 
  PRIMARY KEY ("group_id")
);

CREATE TABLE "user_group_map" (
  "user_id"  int4 NOT NULL, 
  "group_id" int4 NOT NULL, 
  "is_admin" bool NOT NULL, 
  PRIMARY KEY ("user_id", "group_id")
);

CREATE TABLE "posts" (
  "post_id"     SERIAL NOT NULL,
  "parent_id"   int4, 
  "group_id"    int4, 
  "user_id"     int4 NOT NULL, 
  "text"        text NOT NULL, 
  "timestamp"   timestamp NOT NULL, 
  "likes_count" int4 NOT NULL, 
  "seens_count" int4 NOT NULL, 
  PRIMARY KEY ("post_id")
);

CREATE TABLE "attachments" (
  "attachment_id" SERIAL NOT NULL,
  "post_id"       int4,
  "message_id"    int4,
  "type_id"       int4 NOT NULL, 
  "binary_data"   bytea NOT NULL, 
  PRIMARY KEY ("attachment_id"),
  CHECK (("post_id" IS NOT NULL AND "message_id" IS NULL) OR  ("post_id" IS NULL AND "message_id" IS NOT NULL))
);

CREATE TABLE "likes" (
  "user_id"   int4 NOT NULL, 
  "post_id"   int4 NOT NULL, 
  "timestamp" timestamp NOT NULL, 
  PRIMARY KEY ("user_id", "post_id")
);

CREATE TABLE "conversations" (
  "conversation_id" SERIAL NOT NULL,
  "name"            varchar(50),
  PRIMARY KEY ("conversation_id")
);

CREATE TABLE "conversation_members" (
  "member_id"       SERIAL NOT NULL,
  "conversation_id" int4 NOT NULL, 
  "user_id"         int4 NOT NULL, 
  PRIMARY KEY ("member_id"),
  UNIQUE ("conversation_id", "user_id")
);

CREATE TABLE "messages" (
  "message_id" SERIAL NOT NULL,
  "member_id"  int4 NOT NULL, 
  "body"       text NOT NULL, 
  "timestamp"  timestamp NOT NULL, 
  PRIMARY KEY ("message_id")
);

CREATE TABLE "attachment_types" (
  "type_id" SERIAL NOT NULL,
  "name"    varchar(50) NOT NULL, 
  PRIMARY KEY ("type_id")
);

CREATE TABLE "seens" (
  "user_id"   int4 NOT NULL, 
  "post_id"   int4 NOT NULL, 
  "timestamp" timestamp NOT NULL, 
  PRIMARY KEY ("user_id", "post_id")
);


-- foreign keys
ALTER TABLE "user_group_map" ADD CONSTRAINT "FK_user_group_group_id" FOREIGN KEY ("group_id") REFERENCES "groups" ("group_id");
ALTER TABLE "user_group_map" ADD CONSTRAINT "FK_user_group_user_id" FOREIGN KEY ("user_id") REFERENCES "users" ("user_id");
ALTER TABLE "posts" ADD CONSTRAINT "FK_posts_group_id" FOREIGN KEY ("group_id") REFERENCES "groups" ("group_id");
ALTER TABLE "posts" ADD CONSTRAINT "FK_posts_user_id" FOREIGN KEY ("user_id") REFERENCES "users" ("user_id");
ALTER TABLE "posts" ADD CONSTRAINT "FK_posts_parent_id" FOREIGN KEY ("parent_id") REFERENCES "posts" ("post_id");
ALTER TABLE "attachments" ADD CONSTRAINT "FK_attachment_post_id" FOREIGN KEY ("post_id") REFERENCES "posts" ("post_id");
ALTER TABLE "likes" ADD CONSTRAINT "FK_likes_user_id" FOREIGN KEY ("user_id") REFERENCES "users" ("user_id");
ALTER TABLE "likes" ADD CONSTRAINT "FK_likes_post_id" FOREIGN KEY ("post_id") REFERENCES "posts" ("post_id");
ALTER TABLE "conversation_members" ADD CONSTRAINT "FK_conversation_members_conversation_id" FOREIGN KEY ("conversation_id") REFERENCES "conversations" ("conversation_id");
ALTER TABLE "conversation_members" ADD CONSTRAINT "FK_conversation_members_user_id" FOREIGN KEY ("user_id") REFERENCES "users" ("user_id");
ALTER TABLE "messages" ADD CONSTRAINT "FK_messages_member_id" FOREIGN KEY ("member_id") REFERENCES "conversation_members" ("member_id");
ALTER TABLE "attachments" ADD CONSTRAINT "FK_attachment_type_id" FOREIGN KEY ("type_id") REFERENCES "attachment_types" ("type_id");
ALTER TABLE "attachments" ADD CONSTRAINT "FK_attachment_message_id" FOREIGN KEY ("message_id") REFERENCES "messages" ("message_id");
ALTER TABLE "seens" ADD CONSTRAINT "FK_seens_user_id" FOREIGN KEY ("user_id") REFERENCES "users" ("user_id");
ALTER TABLE "seens" ADD CONSTRAINT "FK_seens_post_id" FOREIGN KEY ("post_id") REFERENCES "posts" ("post_id");
