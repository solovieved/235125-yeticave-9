CREATE DATABASE yeticave;
USE yeticave;

CREATE TABLE category (
	id INT AUTO_INCREMENT PRIMARY KEY,
	name CHAR NOT NULL UNIQUE,
	character_code CHAR NOT NULL UNIQUE
);

CREATE TABLE user (
	id INT AUTO_INCREMENT PRIMARY KEY,
	date_registration TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	email CHAR UNIQUE NOT NULL,
	name CHAR UNIQUE NOT NULL,
	password CHAR NOT NULL,
	avatar CHAR,
	contacts CHAR NOT NULL
);

CREATE TABLE lot (
	id INT AUTO_INCREMENT PRIMARY KEY,
	date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	description TEXT NOT NULL,
	image CHAR,
	start_price INT NOT NULL,
	date_completion TIMESTAMP NOT NULL,
	bet_step INT NOT NULL,
	author INT,
	winner INT,
	category INT,
	FOREIGN KEY (author) REFERENCES user(id),
	FOREIGN KEY (winner) REFERENCES user(id),
	FOREIGN KEY (category) REFERENCES category(id)
);

CREATE TABLE bet (
	id INT AUTO_INCREMENT PRIMARY KEY,
	date_bet TIMESTAMP NOT NULL,
	price INT NOT NULL,
	user INT,
	lot INT,
	FOREIGN KEY (user) REFERENCES user(id),
	FOREIGN KEY (lot) REFERENCES lot(id)
);

