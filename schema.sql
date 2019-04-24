CREATE DATABASE yeticave_235125;
USE yeticave_235125;

CREATE TABLE category (
	id INT AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(64) NOT NULL UNIQUE,
	character_code VARCHAR(128) NOT NULL UNIQUE
);

CREATE TABLE user (
	id INT AUTO_INCREMENT PRIMARY KEY,
	date_registration TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	email VARCHAR(64) UNIQUE NOT NULL,
	name VARCHAR(64) NOT NULL,
	password VARCHAR(128) NOT NULL,
	avatar VARCHAR(128) NOT NULL,
	contacts VARCHAR(250) NOT NULL
);

CREATE TABLE lot (
	id INT AUTO_INCREMENT PRIMARY KEY,
	date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  name VARCHAR(64) UNIQUE NOT NULL,
	description TEXT NOT NULL,
	image VARCHAR(128),
	start_price INT NOT NULL,
	date_completion TIMESTAMP NOT NULL,
	bet_step INT NOT NULL,
	author INT NOT NULL,
	winner INT,
	category INT NOT NULL,
	FOREIGN KEY (author) REFERENCES user(id),
	FOREIGN KEY (winner) REFERENCES user(id),
	FOREIGN KEY (category) REFERENCES category(id)
);

CREATE INDEX lot_name ON lot(name);

CREATE TABLE bet (
	id INT AUTO_INCREMENT PRIMARY KEY,
	date_bet TIMESTAMP NOT NULL,
	price INT NOT NULL,
	user INT NOT NULL,
	lot INT NOT NULL,
	FOREIGN KEY (user) REFERENCES user(id),
	FOREIGN KEY (lot) REFERENCES lot(id)
);