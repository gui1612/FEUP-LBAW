CREATE schema IF NOT EXISTS lbaw2264;
SET search_path TO lbaw2264;

DROP TYPE IF EXISTS ReportState CASCADE;
DROP TYPE IF EXISTS ReportType CASCADE;
DROP TYPE IF EXISTS NotificationType CASCADE;
DROP TYPE IF EXISTS RatingType CASCADE;

DROP TABLE IF EXISTS Users CASCADE;
DROP TABLE IF EXISTS Forums CASCADE;
DROP TABLE IF EXISTS ForumOwners CASCADE;
DROP TABLE IF EXISTS Posts CASCADE;
DROP TABLE IF EXISTS Comments CASCADE;
DROP TABLE IF EXISTS Ratings CASCADE;
DROP TABLE IF EXISTS Follows CASCADE;
DROP TABLE IF EXISTS Reports CASCADE;
DROP TABLE IF EXISTS Notifications CASCADE;
DROP TABLE IF EXISTS PostImages CASCADE;

----------------------------------------------------------------------
-- Types
----------------------------------------------------------------------

CREATE TYPE ReportState AS ENUM ('proposed', 'ongoing', 'approved', 'denied');
CREATE TYPE ReportType AS ENUM ('post', 'comment', 'forum');
CREATE TYPE NotificationType AS ENUM ('follow_user', 'post_comment', 'content_reported', 'like');
CREATE TYPE RatingType AS ENUM ('like', 'dislike');


-----------------------------------------
-- Tables
-----------------------------------------

CREATE TABLE Users (
  id SERIAL CONSTRAINT user_id_pk PRIMARY KEY,
  created_at TIMESTAMP WITHOUT TIME ZONE DEFAULT NOW() CONSTRAINT user_created_at_nn NOT NULL CONSTRAINT user_created_at_before_now CHECK (created_at <= NOW()),
  email TEXT CONSTRAINT user_email_uk UNIQUE,
  password TEXT,
  username TEXT CONSTRAINT user_username_nn NOT NULL CONSTRAINT user_username_uk UNIQUE,
  first_name TEXT,
  last_name TEXT,
  bio TEXT,
  reputation INTEGER DEFAULT 0 CONSTRAINT user_reputation_nn NOT NULL,
  block_reason TEXT,
  profile_picture TEXT,
  banner_picture TEXT,
  is_admin BOOLEAN DEFAULT FALSE CONSTRAINT user_is_admin_nn NOT NULL,
  remember_token TEXT -- Laravel
);

CREATE TABLE Forums (
  id SERIAL CONSTRAINT forum_id_pk PRIMARY KEY,
  created_at TIMESTAMP WITHOUT TIME ZONE DEFAULT NOW() CONSTRAINT forum_created_at_nn NOT NULL CONSTRAINT forum_created_at_before_now CHECK (created_at <= NOW()),
  name TEXT CONSTRAINT forum_name_nn NOT NULL CONSTRAINT forum_name_uk UNIQUE,
  description TEXT,
  forum_picture TEXT,
  banner_picture TEXT,
  hidden BOOLEAN DEFAULT FALSE CONSTRAINT forum_hidden_nn NOT NULL
);

CREATE TABLE ForumOwners (
  forum_id INTEGER CONSTRAINT forum_owners_ref_forum REFERENCES Forums CONSTRAINT forum_owner_forum_id_nn NOT NULL,
  owner_id INTEGER CONSTRAINT forum_owners_ref_owner REFERENCES Users CONSTRAINT forum_owner_owner_id_nn NOT NULL,
  CONSTRAINT forum_owner_pk PRIMARY KEY (forum_id, owner_id)
);

CREATE TABLE Posts (
  id SERIAL CONSTRAINT post_id_pk PRIMARY KEY,
  created_at TIMESTAMP WITHOUT TIME ZONE DEFAULT NOW() CONSTRAINT post_created_at_nn NOT NULL CONSTRAINT post_created_at_before_now CHECK (created_at <= NOW()),
  last_edited TIMESTAMP WITHOUT TIME ZONE DEFAULT NOW() CONSTRAINT post_last_edited_nn NOT NULL CONSTRAINT post_last_edited_before_now CHECK (created_at <= last_edited),
  title TEXT CONSTRAINT post_title_nn NOT NULL,
  body TEXT CONSTRAINT post_body_nn NOT NULL,
  rating INTEGER DEFAULT 0 CONSTRAINT post_rating_nn NOT NULL,
  owner_id INTEGER CONSTRAINT post_ref_owner REFERENCES Users CONSTRAINT post_owner_id_nn NOT NULL,
  forum_id INTEGER CONSTRAINT post_ref_forum REFERENCES Forums CONSTRAINT post_forum_id_nn NOT NULL,
  hidden BOOLEAN DEFAULT FALSE CONSTRAINT post_hidden_nn NOT NULL
);

CREATE TABLE Comments (
  id SERIAL CONSTRAINT comment_id_pk PRIMARY KEY,
  created_at TIMESTAMP WITHOUT TIME ZONE DEFAULT NOW() CONSTRAINT comment_created_at_nn NOT NULL CONSTRAINT comment_created_at_before_now CHECK (created_at <= NOW()),
  last_edited TIMESTAMP WITHOUT TIME ZONE DEFAULT NOW() CONSTRAINT comment_last_edited_nn NOT NULL CONSTRAINT comment_last_edited_before_now CHECK (created_at <= last_edited),
  body TEXT CONSTRAINT comment_body_nn NOT NULL,
  rating INTEGER DEFAULT 0 CONSTRAINT comment_rating_nn NOT NULL,
  owner_id INTEGER CONSTRAINT comment_ref_owner REFERENCES Users CONSTRAINT comment_owner_id_nn NOT NULL,
  post_id INTEGER CONSTRAINT comment_ref_post REFERENCES Posts CONSTRAINT comment_post_id_nn NOT NULL,
  hidden BOOLEAN DEFAULT FALSE CONSTRAINT comment_hidden_nn NOT NULL
);

CREATE TABLE Ratings (
  id SERIAL CONSTRAINT rating_pk PRIMARY KEY,
  owner_id INTEGER CONSTRAINT rating_ref_owner REFERENCES Users CONSTRAINT rating_owner_id_nn NOT NULL,
  rated_post_id INTEGER CONSTRAINT rating_ref_rated_post REFERENCES Posts,
  rated_comment_id INTEGER CONSTRAINT rating_ref_rated_comment REFERENCES Comments,
  type RatingType CONSTRAINT rating_type_nn NOT NULL,
  CONSTRAINT rating_refs_uk UNIQUE (owner_id, rated_post_id, rated_comment_id),

  CONSTRAINT rating_xor_refs CHECK ((rated_post_id IS NULL) <> (rated_comment_id IS NULL))
);

CREATE TABLE Follows (
  id SERIAL CONSTRAINT follows_pk PRIMARY KEY, 
  owner_id INTEGER CONSTRAINT follow_ref_owner REFERENCES Users CONSTRAINT follow_owner_id_nn NOT NULL,
  followed_user_id INTEGER CONSTRAINT follow_ref_followed_user REFERENCES Users,
  followed_forum_id INTEGER CONSTRAINT follow_ref_followed_forum REFERENCES Forums,
  CONSTRAINT follow_refs_uk UNIQUE (owner_id, followed_user_id, followed_forum_id),

  CONSTRAINT follow_xor_refs CHECK ((followed_user_id IS NULL) <> (followed_forum_id IS NULL)),
  CONSTRAINT follow_no_self_follow CHECK (followed_user_id <> owner_id)
);

CREATE TABLE Reports (
  id SERIAL CONSTRAINT report_pk PRIMARY KEY, 
  created_at TIMESTAMP WITHOUT TIME ZONE DEFAULT NOW() CONSTRAINT report_created_at_nn NOT NULL CONSTRAINT report_created_at_before_now CHECK (created_at <= NOW()),
  reason TEXT CONSTRAINT report_text_nn NOT NULL,
  state ReportState DEFAULT 'proposed' CONSTRAINT report_state_nn NOT NULL,
  archived BOOLEAN DEFAULT FALSE CONSTRAINT report_archived_nn NOT NULL,
  type ReportType CONSTRAINT report_type_nn NOT NULL,
  reporter_id INTEGER CONSTRAINT report_ref_reporter REFERENCES Users CONSTRAINT report_reporter_id_nn NOT NULL,
  forum_id INTEGER CONSTRAINT report_ref_forum REFERENCES Forums,
  post_id INTEGER CONSTRAINT report_ref_post REFERENCES Posts,
  comment_id INTEGER CONSTRAINT report_ref_comment REFERENCES Comments,

  CONSTRAINT report_xor_ref_forum CHECK ((type = 'forum') = (forum_id IS NOT NULL)),
  CONSTRAINT report_xor_ref_comment CHECK ((type = 'comment') = (comment_id IS NOT NULL)),
  CONSTRAINT report_xor_ref_post CHECK ((type = 'post') = (post_id IS NOT NULL))
);

CREATE TABLE Notifications (
  id SERIAL CONSTRAINT notification_pk PRIMARY KEY,
  created_at TIMESTAMP WITHOUT TIME ZONE DEFAULT NOW() CONSTRAINT notification_created_at_nn NOT NULL CONSTRAINT notification_created_at_before_now CHECK (created_at <= NOW()),
  read BOOLEAN DEFAULT FALSE CONSTRAINT notification_read_nn NOT NULL,
  type NotificationType CONSTRAINT notification_type_nn NOT NULL,
  receiver_id INTEGER CONSTRAINT notification_ref_receiver REFERENCES Users CONSTRAINT notification_receiver_id_nn NOT NULL,

  follow_id INTEGER CONSTRAINT notification_ref_follow REFERENCES Follows,
  comment_id INTEGER CONSTRAINT notification_ref_comment REFERENCES Comments,
  report_id INTEGER CONSTRAINT notification_ref_report REFERENCES Reports,
  rating_id INTEGER CONSTRAINT notification_ref_rating REFERENCES Ratings,

  CONSTRAINT notification_xor_ref_follow CHECK ((type = 'follow_user') = (follow_id IS NOT NULL)),
  CONSTRAINT notification_xor_ref_comment CHECK ((type = 'post_comment') = (comment_id IS NOT NULL)),
  CONSTRAINT notification_xor_ref_report CHECK ((type = 'content_reported') = (report_id IS NOT NULL)),
  CONSTRAINT notification_xor_ref_rating CHECK ((type = 'like') = (rating_id IS NOT NULL))
);

CREATE TABLE PostImages (
    id SERIAL CONSTRAINT post_image_pk PRIMARY KEY,
    path TEXT CONSTRAINT post_image_path_nn NOT NULL,
    caption TEXT CONSTRAINT post_image_caption NOT NULL,
    post_id INTEGER CONSTRAINT post_image_ref_post REFERENCES Posts ON DELETE CASCADE CONSTRAINT post_image_post_id_nn NOT NULL
);

-- Indexes

CREATE INDEX idx_user_username ON Users USING HASH(username);
CREATE INDEX idx_rated_content ON Ratings USING HASH(owner_id); 
CREATE INDEX idx_rated_post ON Ratings USING HASH(rated_post_id); 
CREATE INDEX idx_rated_comment ON Ratings USING HASH(rated_comment_id); 
CREATE INDEX idx_post_created_at ON Posts USING BTREE(created_at);
CREATE INDEX idx_post_rating ON Posts USING BTREE(rating);
CREATE INDEX idx_posts ON Posts USING HASH(owner_id);
CREATE INDEX idx_posts ON Posts USING HASH(forum_id);
CREATE INDEX idx_comment_created_at ON Comments USING BTREE(created_at);
CREATE INDEX idx_follows ON Follows USING HASH(owner_id);
CREATE INDEX idx_user_followers ON Follows USING HASH(followed_user_id);
CREATE INDEX idx_forum_followers ON Follows USING HASH(followed_forum_id);
CREATE INDEX idx_user_notifications ON Notifications USING HASH(receiver_id);
CREATE INDEX idx_notifications_created_at ON Notifications USING BTree(created_at);


-- Triggers

CREATE OR REPLACE FUNCTION immutable_creation_date() RETURNS TRIGGER AS
$BODY$
BEGIN
  IF NEW.created_at <> OLD.created_at THEN
    RAISE EXCEPTION 'The creation date of content cannot be changed.';
  END IF;
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER immutable_user_creation_date
BEFORE INSERT OR UPDATE ON Users
FOR EACH ROW
EXECUTE PROCEDURE immutable_creation_date();

---

CREATE TRIGGER immutable_comment_creation_date
BEFORE INSERT OR UPDATE ON Comments
FOR EACH ROW
EXECUTE PROCEDURE immutable_creation_date();

---

CREATE TRIGGER immutable_post_creation_date
BEFORE INSERT OR UPDATE ON Posts
FOR EACH ROW
EXECUTE PROCEDURE immutable_creation_date();

---

CREATE TRIGGER immutable_forum_creation_date
BEFORE INSERT OR UPDATE ON Forums
FOR EACH ROW
EXECUTE PROCEDURE immutable_creation_date();

---

CREATE OR REPLACE FUNCTION update_last_edited() RETURNS TRIGGER AS
$BODY$
BEGIN
  NEW.last_edited = NOW();
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER update_comment_last_edited
BEFORE INSERT OR UPDATE ON Comments
FOR EACH ROW
EXECUTE PROCEDURE update_last_edited();

---

CREATE TRIGGER update_post_last_edited
BEFORE UPDATE ON Posts
FOR EACH ROW
EXECUTE PROCEDURE update_last_edited();

---

CREATE OR REPLACE FUNCTION at_least_one_forum_owner() RETURNS TRIGGER AS
$BODY$
BEGIN
  IF EXISTS (SELECT count(*) AS num_owners FROM ForumOwners WHERE ForumOwners.forum_id = OLD.forum_id HAVING num_owners > 1) THEN
    RAISE EXCEPTION 'A forum must have at least one owner.';
  END IF;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER at_least_one_forum_owner
  BEFORE UPDATE OR DELETE ON ForumOwners
  FOR EACH ROW
  EXECUTE PROCEDURE at_least_one_forum_owner();

---

CREATE OR REPLACE FUNCTION no_self_follow() RETURNS TRIGGER AS
$BODY$
BEGIN
  IF NEW.owner_id = NEW.followed_user_id THEN
    RAISE EXCEPTION 'An user cannot follow themselves.';
  END IF;
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER no_self_follow
  BEFORE INSERT OR UPDATE ON Follows
  FOR EACH ROW
  EXECUTE PROCEDURE no_self_follow();

---

CREATE OR REPLACE FUNCTION self_content_report() RETURNS TRIGGER AS
$BODY$
BEGIN
  IF NEW.type = 'post' AND NEW.reporter_id IN (SELECT owner_id FROM Posts WHERE id = NEW.post_id) THEN
    RAISE EXCEPTION 'A user cannot report their own posts';
  ELSIF NEW.type = 'comment' AND NEW.reporter_id IN (SELECT owner_id FROM Comments WHERE id = NEW.comment_id) THEN
    RAISE EXCEPTION 'A user cannot report their own comments';
  ELSIF NEW.type = 'forum' AND NEW.reporter_id IN (SELECT ForumOwners.owner_id FROM ForumOwners WHERE ForumOwners.forum_id = NEW.forum_id) THEN
    RAISE EXCEPTION 'A user cannot report their own forums';
  END IF;
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER self_content_report
  BEFORE INSERT OR UPDATE ON Reports
  FOR EACH ROW
  EXECUTE PROCEDURE self_content_report();

---

CREATE OR REPLACE FUNCTION update_user_rating() RETURNS TRIGGER AS
$BODY$
DECLARE
  ratings RECORD; -- (post, user, post_rating, user_rep)
  rating_diff INTEGER;
BEGIN

    IF TG_OP = 'INSERT' OR TG_OP = 'UPDATE' THEN
      IF TG_OP = 'INSERT' THEN
        IF NEW.type = 'like' THEN
          rating_diff := 1;
        ELSE
          rating_diff := -1;
        END IF;
      ELSIF TG_OP = 'UPDATE' THEN
        IF NEW.type = OLD.type THEN
          rating_diff := 0;
        ELSIF NEW.type = 'like' THEN
          rating_diff := 2;
        ELSE
          rating_diff := -2;
        END IF;
      END IF;

      SELECT NEW.rated_post_id AS post_id, Posts.owner_id AS user_id, Posts.rating AS post_rating, Users.reputation AS user_rep INTO ratings
        FROM Posts JOIN Users
        ON Posts.owner_id = Users.id
        WHERE Posts.id = NEW.rated_post_id;

    END IF;
      
    IF TG_OP = 'DELETE' THEN
      IF OLD.type = 'like' THEN
        rating_diff := -1;
      ELSE
        rating_diff := 1;
      END IF;

      SELECT OLD.rated_post_id AS post_id, Posts.owner_id AS user_id, Posts.rating AS post_rating, Users.reputation AS user_rep INTO ratings
        FROM Posts JOIN Users
        ON Posts.owner_id = Users.id
        WHERE Posts.id = OLD.rated_post_id;
    END IF;

  UPDATE Posts
    SET rating = ratings.post_rating + rating_diff
    WHERE id = ratings.post_id;

  UPDATE Users
    SET reputation = ratings.user_rep + rating_diff
    WHERE id = ratings.user_id;

  -- FIXME: faltam comments

  IF TG_OP = 'INSERT' OR TG_OP = 'UPDATE' THEN
    RETURN NEW;
  ELSIF TG_OP = 'DELETE' THEN
    RETURN OLD;
  END IF;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER update_user_rating
  AFTER INSERT OR UPDATE OR DELETE ON Ratings
  FOR EACH ROW
  EXECUTE PROCEDURE update_user_rating();

---
