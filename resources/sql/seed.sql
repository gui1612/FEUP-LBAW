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
DROP TABLE IF EXISTS PasswordResets CASCADE;

----------------------------------------------------------------------
-- Types
----------------------------------------------------------------------

CREATE TYPE ReportState AS ENUM ('proposed', 'ongoing', 'approved', 'denied');
CREATE TYPE ReportType AS ENUM ('post', 'comment', 'forum');
CREATE TYPE NotificationType AS ENUM ('follow_forum', 'follow_user', 'post_comment', 'content_reported', 'content_rated');
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
  remember_token TEXT, -- Laravel
  provider TEXT, -- Laravel
  provider_id TEXT -- Laravel
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
  forum_id INTEGER CONSTRAINT forum_owners_ref_forum REFERENCES Forums ON DELETE CASCADE CONSTRAINT forum_owner_forum_id_nn NOT NULL,
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
  CONSTRAINT rating_refs_post_uk UNIQUE (owner_id, rated_post_id),
  CONSTRAINT rating_refs_comment_uk UNIQUE (owner_id, rated_comment_id),

  CONSTRAINT rating_xor_refs CHECK ((rated_post_id IS NULL) <> (rated_comment_id IS NULL))
);

CREATE TABLE Follows (
  id SERIAL CONSTRAINT follows_pk PRIMARY KEY, 
  owner_id INTEGER CONSTRAINT follow_ref_owner REFERENCES Users CONSTRAINT follow_owner_id_nn NOT NULL,
  followed_user_id INTEGER CONSTRAINT follow_ref_followed_user REFERENCES Users,
  followed_forum_id INTEGER CONSTRAINT follow_ref_followed_forum REFERENCES Forums ON DELETE CASCADE,
  CONSTRAINT follow_refs_user_uk UNIQUE (owner_id, followed_user_id),
  CONSTRAINT follow_refs_forum_uk UNIQUE (owner_id, followed_forum_id),

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

  follow_id INTEGER CONSTRAINT notification_ref_follow REFERENCES Follows ON DELETE CASCADE,
  comment_id INTEGER CONSTRAINT notification_ref_comment REFERENCES Comments ON DELETE CASCADE,
  report_id INTEGER CONSTRAINT notification_ref_report REFERENCES Reports ON DELETE CASCADE,
  rating_id INTEGER CONSTRAINT notification_ref_rating REFERENCES Ratings ON DELETE CASCADE,

  CONSTRAINT notification_xor_ref_follow CHECK ((type = 'follow_user') = (follow_id IS NOT NULL)),
  CONSTRAINT notification_xor_ref_comment CHECK ((type = 'post_comment') = (comment_id IS NOT NULL)),
  CONSTRAINT notification_xor_ref_report CHECK ((type = 'content_reported') = (report_id IS NOT NULL)),
  CONSTRAINT notification_xor_ref_rating CHECK ((type = 'content_rated') = (rating_id IS NOT NULL))
);

CREATE TABLE PostImages (
    id SERIAL CONSTRAINT post_image_pk PRIMARY KEY,
    path TEXT CONSTRAINT post_image_path_nn NOT NULL,
    caption TEXT CONSTRAINT post_image_caption NOT NULL,
    post_id INTEGER CONSTRAINT post_image_ref_post REFERENCES Posts ON DELETE CASCADE CONSTRAINT post_image_post_id_nn NOT NULL
);

CREATE TABLE PasswordResets (
    email TEXT NOT NULL,
    token TEXT NOT NULL,
    created_at TIMESTAMP WITHOUT TIME ZONE
);

-----------------------------------------
-- Indexes
-----------------------------------------

CREATE INDEX idx_user_username ON Users USING HASH(username);
CREATE INDEX idx_rated_content ON Ratings USING HASH(owner_id); 
CREATE INDEX idx_rated_post ON Ratings USING HASH(rated_post_id); 
CREATE INDEX idx_rated_comment ON Ratings USING HASH(rated_comment_id); 
CREATE INDEX idx_post_created_at ON Posts USING BTREE(created_at);
CREATE INDEX idx_post_rating ON Posts USING BTREE(rating);
CREATE INDEX idx_posts ON Posts USING HASH(owner_id);
CREATE INDEX idx_posts_forum ON Posts USING HASH(forum_id);
CREATE INDEX idx_comment_created_at ON Comments USING BTREE(created_at);
CREATE INDEX idx_follows ON Follows USING HASH(owner_id);
CREATE INDEX idx_user_followers ON Follows USING HASH(followed_user_id);
CREATE INDEX idx_forum_followers ON Follows USING HASH(followed_forum_id);
CREATE INDEX idx_user_notifications ON Notifications USING HASH(receiver_id);
CREATE INDEX idx_notifications_created_at ON Notifications USING BTree(created_at);
CREATE INDEX idx_password_resets ON PasswordResets USING HASH(email);


-----------------------------------------
-- Triggers
-----------------------------------------

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
  IF NOT EXISTS (SELECT * FROM Forums WHERE Forums.id = OLD.forum_id) THEN
    RETURN OLD;
  END IF;

  IF NOT EXISTS (SELECT * FROM ForumOwners WHERE ForumOwners.forum_id = OLD.forum_id AND ForumOwners.owner_id <> OLD.owner_id) THEN
    RAISE EXCEPTION 'A forum must have at least one owner.';
  END IF;
  RETURN OLD;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER at_least_one_forum_owner
  AFTER DELETE ON ForumOwners
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

CREATE OR REPLACE FUNCTION notify_reported_content_owners() RETURNS TRIGGER AS
$BODY$
DECLARE
  receivers TEXT;
  receiver INTEGER;
  id INTEGER;
BEGIN
  IF OLD.state <> 'approved' AND NEW.state = 'approved' THEN
    IF NEW.type = 'post' THEN
      receivers := 'SELECT posts.owner_id FROM lbaw2264.posts WHERE posts.id = $1';
      id := NEW.post_id;
    ELSIF NEW.type = 'comment' THEN
      receivers := 'SELECT comments.owner_id FROM lbaw2264.comments WHERE comments.id = $1';
      id := NEW.comment_id;
    ELSIF NEW.type = 'forum' THEN
      receivers := 'SELECT forumowners.owner_id FROM lbaw2264.forumowners WHERE forumowners.forum_id = $1';
      id := NEW.forum_id;
    END IF;

    FOR receiver IN EXECUTE receivers USING id LOOP
      INSERT INTO Notifications(type, receiver_id, report_id) VALUES ('content_reported', receiver, NEW.id);
    END LOOP;
  END IF;
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER notify_reported_content_owners
  BEFORE INSERT OR UPDATE ON Reports
  FOR EACH ROW
  EXECUTE PROCEDURE notify_reported_content_owners();

---

CREATE OR REPLACE FUNCTION archive_reported_content_reports() RETURNS TRIGGER AS
$BODY$
BEGIN
  IF OLD.state <> 'approved' AND NEW.state = 'approved' THEN
    IF NEW.type = 'post' THEN
      UPDATE Reports SET state = 'archived' WHERE post_id = NEW.post_id;
    ELSIF NEW.type = 'comment' THEN
      UPDATE Reports SET state = 'archived' WHERE comment_id = NEW.comment_id;
    ELSIF NEW.type = 'forum' THEN
      UPDATE Reports SET state = 'archived' WHERE forum_id = NEW.forum_id;
    END IF;
  END IF;
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER archive_reported_content_reports
  BEFORE INSERT OR UPDATE ON Reports
  FOR EACH ROW
  EXECUTE PROCEDURE notify_reported_content_owners();

---

CREATE OR REPLACE FUNCTION hide_reported_content() RETURNS TRIGGER AS
$BODY$
BEGIN
  IF OLD.state <> 'approved' AND NEW.state = 'approved' THEN
    IF NEW.type = 'post' THEN
      UPDATE Posts SET hidden = TRUE WHERE id = NEW.post_id;
    ELSIF NEW.type = 'comment' THEN
      UPDATE Comments SET hidden = TRUE WHERE id = NEW.comment_id;
    ELSIF NEW.type = 'forum' THEN
      UPDATE Forums SET hidden = TRUE WHERE id = NEW.forum_id;
    END IF;
  END IF;
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER hide_reported_content
  BEFORE INSERT OR UPDATE ON Reports
  FOR EACH ROW
  EXECUTE PROCEDURE hide_reported_content();

-- ---

CREATE OR REPLACE FUNCTION hide_hidden_forum_posts() RETURNS TRIGGER AS
$BODY$
BEGIN
  IF NOT OLD.hidden AND NEW.hidden THEN
    UPDATE Posts SET hidden = TRUE WHERE forum_id = NEW.id;
  END IF;
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER hide_hidden_forum_posts
  AFTER UPDATE ON Forums
  FOR EACH ROW
  EXECUTE PROCEDURE hide_hidden_forum_posts();

---

CREATE OR REPLACE FUNCTION hide_hidden_post_comments() RETURNS TRIGGER AS
$BODY$
BEGIN
  IF NOT OLD.hidden AND NEW.hidden THEN
    UPDATE Comments SET hidden = TRUE WHERE post_id = NEW.id;
  END IF;
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER hide_hidden_post_comments
  AFTER UPDATE ON Posts
  FOR EACH ROW
  EXECUTE PROCEDURE hide_hidden_post_comments();

---

CREATE OR REPLACE FUNCTION hide_blocked_user_content() RETURNS TRIGGER AS
$BODY$
BEGIN
  IF OLD.block_reason IS NULL AND NEW.block_reason IS NOT NULL THEN
    UPDATE Posts SET hidden = TRUE WHERE owner_id = NEW.id;
    UPDATE Comments SET hidden = TRUE WHERE owner_id = NEW.id;
    UPDATE Forums SET hidden = TRUE WHERE id IN (SELECT forum_id FROM ForumOwners WHERE owner_id = NEW.id);
  END IF;
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER hide_blocked_user_content
  AFTER UPDATE ON Users
  FOR EACH ROW
  EXECUTE PROCEDURE hide_blocked_user_content();

---

CREATE OR REPLACE FUNCTION notify_followed_user() RETURNS TRIGGER AS
$BODY$
BEGIN
  IF NEW.followed_user_id IS NOT NULL THEN
    INSERT INTO Notifications(type, receiver_id, follow_id) VALUES ('follow_user', NEW.followed_user_id, NEW.id);
  END IF;
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER notify_followed_user
  AFTER INSERT ON Follows
  FOR EACH ROW
  EXECUTE PROCEDURE notify_followed_user();

---

CREATE OR REPLACE FUNCTION notify_commented_post_owner() RETURNS TRIGGER AS
$BODY$
BEGIN
  INSERT INTO Notifications(type, receiver_id, comment_id) VALUES ('post_comment', (SELECT owner_id FROM Posts WHERE id = NEW.post_id), NEW.id);
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER notify_commented_post_owner
  AFTER INSERT ON Comments
  FOR EACH ROW
  EXECUTE PROCEDURE notify_commented_post_owner();

---

CREATE OR REPLACE FUNCTION notify_liked_content_owner() RETURNS TRIGGER AS
$BODY$
DECLARE
  receiver INTEGER;
BEGIN
  IF NEW.rated_post_id IS NOT NULL THEN
    INSERT INTO Notifications(type, receiver_id, rating_id) VALUES ('content_rated', (SELECT owner_id FROM Posts WHERE id = NEW.rated_post_id), NEW.id);
  ELSIF NEW.rated_comment_id IS NOT NULL THEN
    INSERT INTO Notifications(type, receiver_id, rating_id) VALUES ('content_rated', (SELECT owner_id FROM Comments WHERE id = NEW.rated_comment_id), NEW.id);
  END IF;
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER notify_liked_content_owner
  AFTER INSERT ON Ratings
  FOR EACH ROW
  EXECUTE PROCEDURE notify_liked_content_owner();

---

CREATE OR REPLACE FUNCTION update_user_rating() RETURNS TRIGGER AS
$BODY$
DECLARE
  table_name TEXT;
  content_id INTEGER;
  user_id INTEGER;
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


      IF NEW.rated_post_id IS NOT NULL THEN
        table_name := 'posts';
        content_id := NEW.rated_post_id;
        SELECT owner_id INTO user_id FROM Posts WHERE id = NEW.rated_post_id;
      ELSE
        table_name := 'comments';
        content_id := NEW.rated_comment_id;
        SELECT owner_id INTO user_id FROM Comments WHERE id = NEW.rated_comment_id;
      END IF;
    END IF;
      
    IF TG_OP = 'DELETE' THEN
      IF OLD.type = 'like' THEN
        rating_diff := -1;
      ELSE
        rating_diff := 1;
      END IF;

      IF OLD.rated_post_id IS NOT NULL THEN
        table_name := 'posts';
        content_id := OLD.rated_post_id;
        SELECT owner_id INTO user_id FROM Posts WHERE id = OLD.rated_post_id;
      ELSE
        table_name := 'comments';
        content_id := OLD.rated_comment_id;
        SELECT owner_id INTO user_id FROM Comments WHERE id = OLD.rated_comment_id;
      END IF;
    END IF;

  EXECUTE 'UPDATE ' || quote_ident(table_name) ||
    ' SET rating = rating + $1
    WHERE id = $2' USING rating_diff, content_id;

  UPDATE Users
    SET reputation = reputation + rating_diff
    WHERE id = user_id;

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

CREATE OR REPLACE FUNCTION no_post_delete_with_likes_or_comments() RETURNS TRIGGER AS
$BODY$
BEGIN
  IF EXISTS (SELECT * FROM Ratings WHERE Ratings.rated_post_id = OLD.id) THEN
    RAISE EXCEPTION 'A post cannot be deleted if it has ratings';
  END IF;

  IF EXISTS (SELECT * FROM Comments WHERE Comments.post_id = OLD.id) THEN
    RAISE EXCEPTION 'A post cannot be deleted if it has comments';
  END IF;

  RETURN OLD;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER no_post_delete_with_likes_or_comments
  BEFORE DELETE ON Posts
  FOR EACH ROW
  EXECUTE PROCEDURE no_post_delete_with_likes_or_comments();


-----------------------------------------
-- FTS
-----------------------------------------

ALTER TABLE Users ADD COLUMN tsvector TSVECTOR;

CREATE OR REPLACE FUNCTION user_search_update() RETURNS TRIGGER AS $$
BEGIN
  IF TG_OP = 'INSERT' THEN 
    NEW.tsvector = (
      setweight(to_tsvector('english', NEW.first_name), 'A') ||
      setweight(to_tsvector('english',NEW.last_name), 'A') || 
      setweight(to_tsvector('english', NEW.bio), 'B')
    );
  END IF;
  
  IF TG_OP = 'UPDATE' THEN
    IF (NEW.first_name <> OLD.first_name OR NEW.last_name <> OLD.last_name OR NEW.bio <> OLD.bio) THEN
      NEW.tsvector = ( 
        setweight(to_tsvector('english',NEW.first_name), 'A') || 
        setweight(to_tsvector('english',NEW.last_name), 'A') || 
        setweight(to_tsvector('english',NEW.bio), 'B')
      );
    END IF;  
  END IF;
  RETURN NEW;
END 
$$ LANGUAGE 'plpgsql';

CREATE TRIGGER user_search_update
  BEFORE INSERT OR UPDATE ON Users
  FOR EACH ROW
  EXECUTE PROCEDURE user_search_update();

CREATE INDEX user_search ON Users USING GIST(tsvector); 

---

DROP AGGREGATE IF EXISTS tsvector_agg(tsvector) CASCADE;

-- https://gist.github.com/glittershark/6286217?permalink_comment_id=3041994#gistcomment-3041994
CREATE AGGREGATE tsvector_agg (tsvector) (
	STYPE = pg_catalog.tsvector,
	SFUNC = pg_catalog.tsvector_concat,
	INITCOND = ''
);

ALTER TABLE Posts ADD COLUMN tsvector TSVECTOR;
ALTER TABLE Comments ADD COLUMN tsvector TSVECTOR;

CREATE OR REPLACE FUNCTION post_search_update_post() RETURNS TRIGGER AS $$
BEGIN
  IF TG_OP = 'INSERT' THEN 
    NEW.tsvector = (
      setweight(to_tsvector('english', NEW.title), 'A') ||
      setweight(to_tsvector('english',NEW.body), 'A') ||
      setweight((SELECT tsvector_agg(tsvector) FROM Comments WHERE Comments.post_id = NEW.id), 'B')
    );
  END IF;
  
  IF TG_OP = 'UPDATE' THEN
    IF (NEW.title <> OLD.title OR NEW.body <> OLD.body) THEN
      NEW.tsvector = (
        setweight(to_tsvector('english', NEW.title), 'A') ||
        setweight(to_tsvector('english',NEW.body), 'A') ||
        setweight((SELECT tsvector_agg(tsvector) FROM Comments WHERE Comments.post_id = NEW.id), 'B')
      );
    END IF;  
  END IF;
  RETURN NEW;
END 
$$ LANGUAGE 'plpgsql';

CREATE TRIGGER post_search_update_post
  BEFORE INSERT OR UPDATE ON Posts
  FOR EACH ROW
  EXECUTE PROCEDURE post_search_update_post();

CREATE OR REPLACE FUNCTION post_search_update_comment() RETURNS TRIGGER AS $$
BEGIN
  IF TG_OP = 'INSERT' THEN 
    NEW.tsvector = (
      setweight(to_tsvector('english', NEW.body), 'A')
    );
  END IF;
  
  IF TG_OP = 'UPDATE' THEN
    IF (NEW.body <> OLD.body) THEN
      NEW.tsvector = (
        setweight(to_tsvector('english', NEW.body), 'A')
      );
    END IF;
  END IF;
  RETURN NEW;
END 
$$ LANGUAGE 'plpgsql';

CREATE TRIGGER post_search_update_comment
  BEFORE INSERT OR UPDATE ON Comments
  FOR EACH ROW
  EXECUTE PROCEDURE post_search_update_comment();

CREATE OR REPLACE FUNCTION post_search_update_post_with_comments() RETURNS TRIGGER AS $$
BEGIN
  UPDATE Posts SET tsvector = (
    setweight(to_tsvector('english', Posts.title), 'A') ||
    setweight(to_tsvector('english',Posts.body), 'A') ||
    setweight((SELECT tsvector_agg(tsvector) FROM Comments WHERE Comments.post_id = Posts.id), 'B')
  ) WHERE Posts.id = NEW.post_id;

  RETURN NEW;
END 
$$ LANGUAGE 'plpgsql';

CREATE TRIGGER post_search_update_post_with_comments
  AFTER INSERT OR UPDATE ON Comments
  FOR EACH ROW
  EXECUTE PROCEDURE post_search_update_post_with_comments();

CREATE INDEX post_search ON Posts USING GIST(tsvector);

---

ALTER TABLE Forums ADD COLUMN tsvector TSVECTOR;

CREATE OR REPLACE FUNCTION forum_search_update() RETURNS TRIGGER AS $$
BEGIN
  IF TG_OP = 'INSERT' THEN 
    NEW.tsvector = (
      setweight(to_tsvector('english', NEW.name), 'A') ||
      setweight(to_tsvector('english',NEW.description), 'B')
    );
  END IF;
  
  IF TG_OP = 'UPDATE' THEN
    IF (NEW.name <> OLD.name OR NEW.description <> OLD.description) THEN
      NEW.tsvector = ( 
        setweight(to_tsvector('english', NEW.name), 'A') ||
        setweight(to_tsvector('english',NEW.description), 'B')
      );
    END IF;  
  END IF;
  RETURN NEW;
END 
$$ LANGUAGE 'plpgsql';

CREATE TRIGGER forum_search_update
  BEFORE INSERT OR UPDATE ON Forums
  FOR EACH ROW
  EXECUTE PROCEDURE forum_search_update();

CREATE INDEX forum_search ON Forums USING GIST(tsvector); 