----------------------------------------------------------------------
--- Types
----------------------------------------------------------------------

CREATE TYPE ReportState AS ENUM ('proposed', 'ongoing', 'approved', 'denied');
CREATE TYPE ReportType AS ENUM ('post', 'comment', 'forum');
CREATE TYPE NotificationType AS ENUM ('follow_user', 'post_comment', 'content_reported', 'like');
CREATE TYPE RatingType AS ENUM ('like', 'dislike');


-----------------------------------------
-- Tables
-----------------------------------------

CREATE TABLE Users (
  id SERIAL PRIMARY KEY,
  createdAt DATETIME NOT NULL DEFAULT NOW CONSTRAINT validCreation CHECK createdAt <= NOW,
  email TEXT CONSTRAINT userEmailUk UNIQUE,
  pwHash TEXT,
  username TEXT NOT NULL CONSTRAINT userUsernameUk UNIQUE,
  firstName TEXT,
  lastName TEXT,
  bio TEXT,
  reputation NOT NULL DEFAULT 0,
  blockReason TEXT,
  profilePicture TEXT,
  bannerPicture TEXT,
  isAdmin BOOLEAN NOT NULL DEFAULT FALSE
);

CREATE TABLE Forums (
  id SERIAL PRIMARY KEY,
  createdAt DATETIME NOT NULL DEFAULT NOW CONSTRAINT validCreation CHECK createdAt <= NOW,
  name TEXT NOT NULL CONSTRAINT forumNameUk UNIQUE,
  description TEXT,
  forumPicture TEXT,
  bannerPicture TEXT,
  hidden BOOLEAN NOT NULL DEFAULT FALSE
);

CREATE TABLE ForumOwners (
  forumId REFERENCES Forums NOT NULL,
  ownerId REFERENCES Users NOT NULL,
  PRIMARY KEY (forumId, ownerId)
);

CREATE TABLE Posts (
  id SERIAL PRIMARY KEY,
  createdAt DATETIME NOT NULL DEFAULT NOW CONSTRAINT validCreation CHECK createdAt <= NOW,
  lastEdited DATETIME NOT NULL DEFAULT NOW CONSTRAINT validEditionTime CHECK createdAt <= lastEdited,
  title TEXT NOT NULL,
  body TEXT NOT NULL,
  rating INT NOT NULL DEFAULT 0,
  ownerId REFERENCES Users NOT NULL,
  forumId REFERENCES Forums NOT NULL,
  hidden BOOLEAN NOT NULL DEFAULT FALSE
);

CREATE TABLE Comments (
  id SERIAL PRIMARY KEY,
  createdAt DATETIME NOT NULL DEFAULT NOW CONSTRAINT validCreation CHECK createdAt <= NOW,
  lastEdited DATETIME NOT NULL DEFAULT NOW CONSTRAINT validEditionTime CHECK createdAt <= lastEdited,
  body TEXT NOT NULL,
  rating INT NOT NULL DEFAULT 0,
  ownerId REFERENCES Users NOT NULL,
  postId REFERENCES Posts NOT NULL,
  hidden BOOLEAN NOT NULL DEFAULT FALSE
);

CREATE TABLE Ratings (
  ownerId REFERENCES Users NOT NULL,
  ratedPost REFERENCES Posts,
  ratedComment REFERENCES Comments,
  type RatingType NOT NULL,
  PRIMARY KEY (ownerId, ratedPost, ratedComment),

  CONSTRAINT validRatings CHECK ((ratedPost IS NULL) <> (ratedComment IS NULL))
);

CREATE TABLE Follows (
  ownerId REFERENCES Users NOT NULL,
  followedUser REFERENCES Users,
  followedForum REFERENCES Forums,
  PRIMARY KEY (ownerId, followedUser, followedForum)

  CONSTRAINT validFollow CHECK ((followedUser IS NULL) <> (followedForum IS NULL)),
  CONSTRAINT doesNotFollowThemselves CHECK (followedUser <> ownerId)
);

CREATE TABLE Reports (
  id SERIAL PRIMARY KEY, 
  createdAt DATETIME NOT NULL DEFAULT NOW CONSTRAINT validCreation CHECK createdAt <= NOW,
  reason TEXT NOT NULL,
  state ReportState NOT NULL DEFAULT ReportState.proposed,
  archived BOOLEAN NOT NULL DEFAULT FALSE,
  type ReportType NOT NULL,
  reporterId REFERENCES Users NOT NULL,
  forumId REFERENCES Forums,
  postId REFERENCES Posts,
  commentId REFERENCES Comments

  CONSTRAINT validReport CHECK ((forumId IS NULL) <> (postId IS NULL) <> (commentId IS NULL))
);

CREATE TABLE Notifications (
  id SERIAL PRIMARY KEY,
  createdAt DATETIME NOT NULL DEFAULT NOW CONSTRAINT validCreation CHECK createdAt <= NOW,
  type NotificationType NOT NULL,
  followId REFERENCES Follows,
  commentId REFERENCES Comments,
  ratingId REFERENCES Ratings,
  reportId REFERENCES Reports,

  CONSTRAINT validNotification CHECK ((followId IS NULL) <> (commentId IS NULL) <> (ratingId IS NULL))
);

CREATE TABLE PostImages (
    id SERIAL PRIMARY KEY,
    path TEXT NOT NULL,
    caption NOT NULL,
    postId REFERENCES Posts NOT NULL
);
