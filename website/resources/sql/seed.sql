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
  id SERIAL CONSTRAINT userIdPk PRIMARY KEY,
  createdAt TIMESTAMP WITHOUT TIME ZONE DEFAULT NOW() CONSTRAINT userCreatedAtNn NOT NULL CONSTRAINT userCreatedAtBeforeNow CHECK (createdAt <= NOW()),
  email TEXT CONSTRAINT userEmailUk UNIQUE,
  pwHash TEXT,
  username TEXT CONSTRAINT userUsernameNn NOT NULL CONSTRAINT userUsernameUk UNIQUE,
  firstName TEXT,
  lastName TEXT,
  bio TEXT,
  reputation INTEGER DEFAULT 0 CONSTRAINT userReputationNn NOT NULL,
  blockReason TEXT,
  profilePicture TEXT,
  bannerPicture TEXT,
  isAdmin BOOLEAN DEFAULT FALSE CONSTRAINT userIsAdminNn NOT NULL
);

CREATE TABLE Forums (
  id SERIAL CONSTRAINT forumIdPk PRIMARY KEY,
  createdAt TIMESTAMP WITHOUT TIME ZONE DEFAULT NOW() CONSTRAINT forumCreatedAtNn NOT NULL CONSTRAINT forumCreatedAtBeforeNow CHECK (createdAt <= NOW()),
  name TEXT CONSTRAINT forumNameNn NOT NULL CONSTRAINT forumNameUk UNIQUE,
  description TEXT,
  forumPicture TEXT,
  bannerPicture TEXT,
  hidden BOOLEAN DEFAULT FALSE CONSTRAINT forumHiddenNn NOT NULL
);

CREATE TABLE ForumOwners (
  forumId INTEGER CONSTRAINT forumOwnersRefForum REFERENCES Forums CONSTRAINT forumOwnerForumIdNn NOT NULL,
  ownerId INTEGER CONSTRAINT forumOwnersRefOwner REFERENCES Users CONSTRAINT forumOwnerOwnerIdNn NOT NULL,
  CONSTRAINT forumOwnerPk PRIMARY KEY (forumId, ownerId)
);

CREATE TABLE Posts (
  id SERIAL CONSTRAINT postIdPk PRIMARY KEY,
  createdAt TIMESTAMP WITHOUT TIME ZONE DEFAULT NOW() CONSTRAINT postCreatedAtNn NOT NULL CONSTRAINT postCreatedAtBeforeNow CHECK (createdAt <= NOW()),
  lastEdited TIMESTAMP WITHOUT TIME ZONE DEFAULT NOW() CONSTRAINT postLastEditedNn NOT NULL CONSTRAINT postLastEditedBeforeNow CHECK (createdAt <= lastEdited),
  title TEXT CONSTRAINT postTitleNn NOT NULL,
  body TEXT CONSTRAINT postBodyNn NOT NULL,
  rating INTEGER DEFAULT 0 CONSTRAINT postRatingNn NOT NULL,
  ownerId INTEGER CONSTRAINT postRefOwner REFERENCES Users CONSTRAINT postOwnerIdNn NOT NULL,
  forumId INTEGER CONSTRAINT postRefForum REFERENCES Forums CONSTRAINT postForumIdNn NOT NULL,
  hidden BOOLEAN DEFAULT FALSE CONSTRAINT postHiddenNn NOT NULL
);

CREATE TABLE Comments (
  id SERIAL CONSTRAINT commentIdPk PRIMARY KEY,
  createdAt TIMESTAMP WITHOUT TIME ZONE DEFAULT NOW() CONSTRAINT commentCreatedAtNn NOT NULL CONSTRAINT commentCreatedAtBeforeNow CHECK (createdAt <= NOW()),
  lastEdited TIMESTAMP WITHOUT TIME ZONE DEFAULT NOW() CONSTRAINT commentLastEditedNn NOT NULL CONSTRAINT commentLastEditedBeforeNow CHECK (createdAt <= lastEdited),
  body TEXT CONSTRAINT commentBodyNn NOT NULL,
  rating INTEGER DEFAULT 0 CONSTRAINT commentRatingNn NOT NULL,
  ownerId INTEGER CONSTRAINT commentRefOwner REFERENCES Users CONSTRAINT commentOwnerIdNn NOT NULL,
  postId INTEGER CONSTRAINT commentRefPost REFERENCES Posts CONSTRAINT commentPostIdNn NOT NULL,
  hidden BOOLEAN DEFAULT FALSE CONSTRAINT commentHiddenNn NOT NULL
);

CREATE TABLE Ratings (
  ownerId INTEGER CONSTRAINT ratingRefOwner REFERENCES Users CONSTRAINT ratingOwnerIdNn NOT NULL,
  ratedPostId INTEGER CONSTRAINT ratingRefRatedPost REFERENCES Posts,
  ratedCommentId INTEGER CONSTRAINT ratingRefRatedComment REFERENCES Comments,
  type RatingType CONSTRAINT ratingTypeNn NOT NULL,
  CONSTRAINT ratingPk PRIMARY KEY (ownerId, ratedPostId, ratedCommentId),

  CONSTRAINT ratingXorRefs CHECK ((ratedPostId IS NULL) <> (ratedCommentId IS NULL))
);

CREATE TABLE Follows (
  ownerId INTEGER CONSTRAINT followRefOwner REFERENCES Users CONSTRAINT followOwnerIdNn NOT NULL,
  followedUserId INTEGER CONSTRAINT followRefFollowedUser REFERENCES Users,
  followedForumId INTEGER CONSTRAINT followRefFollowedForum REFERENCES Forums,
  CONSTRAINT followPk PRIMARY KEY (ownerId, followedUserId, followedForumId),

  CONSTRAINT followXorRefs CHECK ((followedUserId IS NULL) <> (followedForumId IS NULL)),
  CONSTRAINT followNoSelfFollow CHECK (followedUserId <> ownerId)
);

CREATE TABLE Reports (
  id SERIAL CONSTRAINT reportPk PRIMARY KEY, 
  createdAt TIMESTAMP WITHOUT TIME ZONE DEFAULT NOW() CONSTRAINT reportCreatedAtNn NOT NULL CONSTRAINT reportCreatedAtBeforeNow CHECK (createdAt <= NOW()),
  reason TEXT CONSTRAINT reportTextNn NOT NULL,
  state ReportState DEFAULT 'proposed' CONSTRAINT reportStateNn NOT NULL,
  archived BOOLEAN DEFAULT FALSE CONSTRAINT reportArchivedNn NOT NULL,
  type ReportType CONSTRAINT reportTypeNn NOT NULL,
  reporterId INTEGER CONSTRAINT reportRefReporter REFERENCES Users CONSTRAINT reportReporterIdNn NOT NULL,
  forumId INTEGER CONSTRAINT reportRefForum REFERENCES Forums,
  postId INTEGER CONSTRAINT reportRefPost REFERENCES Posts,
  commentId INTEGER CONSTRAINT reportRefComment REFERENCES Comments,

  CONSTRAINT reportXorRefForum CHECK ((type = 'forum') = (forumId IS NOT NULL)),
  CONSTRAINT reportXorRefComment CHECK ((type = 'comment') = (commentId IS NOT NULL)),
  CONSTRAINT reportXorRefPost CHECK ((type = 'post') = (postId IS NOT NULL))
);

CREATE TABLE Notifications (
  id SERIAL CONSTRAINT notificationPk PRIMARY KEY,
  createdAt TIMESTAMP WITHOUT TIME ZONE DEFAULT NOW() CONSTRAINT notificationCreatedAtNn NOT NULL CONSTRAINT notificationCreatedAtBeforeNow CHECK (createdAt <= NOW()),
  read BOOLEAN DEFAULT FALSE CONSTRAINT notificationReadNn NOT NULL,
  type NotificationType CONSTRAINT notificationTypeNn NOT NULL,
  receiverId INTEGER CONSTRAINT notificationRefReceiver REFERENCES Users CONSTRAINT notificationReceiverIdNn NOT NULL,

  followOwnerId INTEGER,
  followedUserId INTEGER,
  followedForumId INTEGER,
  CONSTRAINT notificationRefFollow FOREIGN KEY (followOwnerId, followedUserId, followedForumId) REFERENCES Follows(ownerId, followedUserId, followedForumId),
  
  commentId INTEGER CONSTRAINT notificationRefComment REFERENCES Comments,
  reportId INTEGER CONSTRAINT notificationRefReport REFERENCES Reports,

  ratingOwnerId INTEGER,
  ratedPostId INTEGER,
  ratedCommentId INTEGER,
  CONSTRAINT notificationRefRating FOREIGN KEY (ratingOwnerId, ratedPostId, ratedCommentId) REFERENCES Ratings(ownerId, ratedPostId, ratedCommentId),
  

  CONSTRAINT notificationXorRefFollow CHECK ((type = 'follow_user') = (followOwnerId IS NOT NULL AND ((followedUserId IS NULL) <> (followedForumId IS NULL)))),
  CONSTRAINT notificationXorRefComment CHECK ((type = 'post_comment') = (commentId IS NOT NULL)),
  CONSTRAINT notificationXorRefReport CHECK ((type = 'content_reported') = (reportId IS NOT NULL)),
  CONSTRAINT notificationXorRefRating CHECK ((type = 'like') = (ratingOwnerId IS NOT NULL AND ((ratedPostId IS NULL) <> (ratedCommentId IS NULL))))
);

CREATE TABLE PostImages (
    id SERIAL CONSTRAINT postImagePk PRIMARY KEY,
    path TEXT CONSTRAINT postImagePathNn NOT NULL,
    caption TEXT CONSTRAINT postImageCaption NOT NULL,
    postId INTEGER CONSTRAINT postImageRefPost REFERENCES Posts CONSTRAINT postImagePostIdNn NOT NULL
);
