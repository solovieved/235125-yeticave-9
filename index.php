<?php
require_once 'init.php';

$sql_lot ="SELECT lot.id, lot.name, lot.start_price, IFNULL(MAX(bet.price), lot.start_price) AS price, lot.image, lot.date_completion, category.name AS cat, COUNT(bet.price) AS count_bet
    FROM lot
    JOIN category ON lot.category = category.id
    LEFT JOIN bet ON bet.lot = lot.id
    WHERE lot.date_completion >= NOW()
    GROUP BY lot.id
    ORDER BY lot.date_creation DESC LIMIT 6";
$result_lot = mysqli_query($link, $sql_lot);
if ($result_lot) {
    $lot_info = mysqli_fetch_all($result_lot, MYSQLI_ASSOC);
}
else {
    mysqli_error($link);
}

$sql = "SELECT bet.*, lot.id FROM bet
    JOIN lot ON bet.lot = lot.id
    WHERE lot = 3";

$content = include_template('index.php', [
    'categories' => $categories,
    'lot_info' => $lot_info,
    'time_to_close' => $time_to_close
]);

$title = 'Главная';
$link_index = '';
$layout_content = include_template('layout.php', [
    'title' => $title,
    'content' => $content,
    'categories' => $categories,
    'user' => $user,
    'link_index' => $link_index
]);

print($layout_content);
?>
