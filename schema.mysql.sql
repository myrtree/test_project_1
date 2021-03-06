CREATE DATABASE IF NOT EXISTS task_book CHARACTER SET utf8 COLLATE utf8_general_ci;
USE task_book;

CREATE TABLE IF NOT EXISTS users (
    id INTEGER NOT NULL AUTO_INCREMENT,
    name VARCHAR(256) NOT NULL,
    email VARCHAR(256) NOT NULL,
    password_hash VARCHAR(256) NOT NULL,
    auth_uid VARCHAR(256) DEFAULT NULL,
    is_admin BOOLEAN NOT NULL DEFAULT FALSE,
    PRIMARY KEY (id)
) ENGINE=MYISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS tasks (
    id INTEGER NOT NULL AUTO_INCREMENT,
    user_id INTEGER DEFAULT NULL,
    author_name VARCHAR(256) DEFAULT NULL,
    title VARCHAR(256) NOT NULL,
    content LONGTEXT NOT NULL,
    pic VARCHAR(256) NOT NULL,
    completed BOOLEAN NOT NULL DEFAULT FALSE,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id)
) ENGINE=MYISAM DEFAULT CHARSET=utf8;
