#sessions database
CREATE DATABASE sessions;

USE sessions;

CREATE TABLE sessions (
    id int NOT NULL AUTO_INCREMENT,
    username VARCHAR(32) NOT NULL,
    token VARCHAR(64) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE session_variables (
    id int NOT NULL AUTO_INCREMENT,
    userid int NOT NULL,
    name VARCHAR(32) NOT NULL,
    value VARCHAR(64) NOT NULL,
    PRIMARY KEY (id)
);

#forums database
CREATE DATABASE forum;

USE forum;

CREATE TABLE users (
    id int NOT NULL AUTO_INCREMENT,
    username VARCHAR(32) NOT NULL,
    email VARCHAR(64) NOT NULL,
    password VARCHAR(32) NOT NULL,
    active int NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE registration_keys (
    id int NOT NULL AUTO_INCREMENT,
    userid int NOT NULL,
    token VARCHAR(32) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE forums (
    id int NOT NULL AUTO_INCREMENT,
    name VARCHAR(32) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE threads (
    id int NOT NULL AUTO_INCREMENT,
    forumid int NOT NULL,
    threadname VARCHAR(32) NOT NULL,
    userid int NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE posts (
    id int NOT NULL AUTO_INCREMENT,
    userid int NOT NULL,
    threadid int NOT NULL,
    date VARCHAR(32) NOT NULL,
    content TEXT NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE messages (
    id int NOT NULL AUTO_INCREMENT,
    toid int NOT NULL,
    fromid int NOT NULL,
    seen int NOT NULL,
    date VARCHAR(32) NOT NULL,
    content TEXT NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE loginnonces (
    id int NOT NULL AUTO_INCREMENT,
    username VARCHAR(32) NOT NULL,
    nonce int NOT NULL,
    PRIMARY KEY (id)
);

