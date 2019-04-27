USE yeticave_235125;

INSERT INTO category(name, character_code)
VALUES
  ('Доски и лыжи', 'boards'),
  ('Крепления', 'attachment'),
  ('Ботинки', 'boots'),
  ('Одежда', 'clothing'),
  ('Инструменты', 'tools'),
  ('разное', 'other');

INSERT INTO user(date_registration, email, name, password, avatar, contacts)
VALUES
	('2019.10.01', 'igor@gmail.com', 'Игорь', 'hinoji', 'img/user1.jpg', 'мобильный +375291234567'),
	('2018.11.03', 'svet@gmail.com', 'Светлана', 'jnoiijp', 'img/user2.jpg', 'viber +79111222333'),
	('2019.03.04', 'ilya@yandex.ru', 'Илья', 'wfwefji', 'img/user3.jpg', 'телефон для связи +71234567890'),
	('2019.04.04', 'oleg@mail.ru', 'Олег', 'ryhjry', 'img/user4.jpg', 'telegram @oleg');

INSERT INTO lot(date_creation, name, description, image, start_price, date_completion, bet_step, author, category)
VALUES
	('2019.03.02', '2014 Rossignol District Snowboard', 'В отличном состояниии.', 'img/lot-1.jpg', '10999', '2019.06.02', '500', '1', '1'),
	('2019.02.02', 'DC Ply Mens 2016/2017 Snowboard', 'Новая.', 'img/lot-2.jpg', '159999', '2019.05.02', '3000', '2', '1'),
	('2019.03.18', 'Крепления Union Contact Pro 2015 года размер L/XL', 'Как новые.', 'img/lot-3.jpg', '8000', '2019.06.18', '350', '3', '2'),
	('2019.03.16', 'Ботинки для сноуборда DC Mutiny Charocal', 'Самые удобные ботинки.', 'img/lot-4.jpg', '10999', '2019.06.16', '400', '4', '3'),
	('2019.03.11', 'Куртка для сноуборда DC Mutiny Charocal', 'Стильно, модно, молодежно.', 'img/lot-5.jpg', '7500', '2019.06.11', '300', '1', '4'),
	('2019.03.08', 'Маска Oakley Canopy', 'Лучше не найдёшь.', 'img/lot-6.jpg', '5400', '2019.06.08', '250', '2', '6');

INSERT INTO bet(date_bet, price, user, lot)
VALUES
  ('2019.04.15', '9000', '1', '3'),
  ('2019.04.16', '200000', '2', '2'),
  ('2019.04.17', '10000', '3', '5');

/*Список категорий*/
SELECT name FROM category;

/*Обновление названия по идентификатору*/
UPDATE lot SET name = 'new_name' WHERE id = 2;

/*список самых свежих ставок для лота по его идентификатору*/
SELECT * FROM bet JOIN lot ON lot.id = lot
WHERE lot.id = 3
ORDER BY bet.date_bet DESC
LIMIT 3;

/*показать лот по его id и название категории*/
SELECT lot.*, category.name FROM lot
JOIN category ON category.id = category
WHERE lot.id = 3;

/*самые новые, открытые лоты*/
SELECT lot.name, lot.start_price, lot.image, IFNULL(MAX(bet.price), 'не определена') AS price, category.name
FROM lot
JOIN category ON lot.category = category.id
LEFT JOIN bet ON bet.lot = lot.id
WHERE lot.date_completion >= NOW()
GROUP BY lot.id
ORDER BY lot.date_creation DESC;
