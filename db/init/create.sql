CREATE DATABASE phptodo;
use phptodo;

CREATE TABLE users (
    uid INT(11) AUTO_INCREMENT NOT NULL,
    username VARCHAR(30) NOT NULL,
    password CHAR(32) NOT NULL,
    PRIMARY KEY (uid)
);

CREATE TABLE todos (
    tid INT(11) AUTO_INCREMENT NOT NULL,
    uid INT(11) NOT NULL,
    title VARCHAR(100) NOT NULL,
    due_date DATE,
    done_date DATE,
    create_at TIMESTAMP,
    delete_at TIMESTAMP,
    PRIMARY KEY (tid)
);