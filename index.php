<?php
require_once 'init.php';
require_once 'getwinner.php';

$sql = "SELECT lot.id, lot.name, lot.start_price, IFNULL(MAX(bet.price), lot.start_price) AS price, lot.image, lot.date_completion, category.name AS cat, COUNT(bet.price) AS count_bet
    FROM lot
    JOIN category ON lot.category = category.id
    LEFT JOIN bet ON bet.lot = lot.id
    WHERE lot.date_completion >= NOW()
    GROUP BY lot.id
    ORDER BY lot.date_creation DESC
    LIMIT 6"; /*исходя из макета на главной странице отображаю 6 самых свежих лотов.на остальных страницах по 9, если больше появляется пагинация*/
$lot_info = get_array($link, $sql);
$content = include_template('index.php', [
    'categories' => $categories,
    'lot_info' => $lot_info,
    'time_to_close' => $time_to_close,
]);

$title = 'Главная';
$link_index = '';
$layout_content = include_template('layout.php', [
    'title' => $title,
    'content' => $content,
    'categories' => $categories,
    'user' => $user,
    'link_index' => $link_index,
]);

print($layout_content);
?>
