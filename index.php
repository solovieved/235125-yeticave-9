<?php
require_once 'link.php';
require_once 'data.php';
require_once 'helpers.php';
require_once 'functions.php';

$sql_cat = "SELECT name, character_code FROM category";
$result_cat = mysqli_query($link, $sql_cat);

if ($result_cat) {
    $categories = mysqli_fetch_all($result_cat, MYSQLI_ASSOC);
}
else {
    mysqli_error($link);
}

$sql_lot ="SELECT lot.id, lot.name, lot.start_price, lot.image, lot.date_completion, category.name AS cat
    FROM lot
    JOIN category ON lot.category = category.id
    WHERE lot.date_completion >= NOW()
    GROUP BY lot.id
    ORDER BY lot.date_creation DESC";
$result_lot = mysqli_query($link, $sql_lot);

if ($result_lot) {
    $lots_info = mysqli_fetch_all($result_lot, MYSQLI_ASSOC);
}
else {
    mysqli_error($link);
}

$content = include_template('index.php', [
    'categories' => $categories,
    'lots_info' => $lots_info,
    'time' => $time
]);

$title = 'Главная';
$layout_content = include_template('layout.php', [
    'title' => $title,
    'is_auth' => $is_auth,
    'content' => $content,
    'categories' => $categories,
    'user' => $user
]);

print($layout_content);
?>
