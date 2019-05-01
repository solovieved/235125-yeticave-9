<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once 'helpers.php';
require_once 'functions.php';

$link = mysqli_connect('localhost', 'root', '', 'yeticave_235125');
mysqli_set_charset($link, 'utf8');
$is_auth = rand(0, 1);
$user = [];

if ($is_auth == 1) {
    $user['name'] = 'Edgar';
};

$categories = [];
$lots_info = [];

if (!$link) {
    exit('сайт временно не работает');
}
else {
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
}

$title = 'Главная';
$time_end = strtotime('tomorrow') - strtotime('now');
$time = 3600;

$content = include_template('index.php', [
    'categories' => $categories,
    'lots_info' => $lots_info,
    'time_end' => $time_end,
    'time' => $time
]);

$layout_content = include_template('layout.php', [
    'title' => $title,
    'is_auth' => $is_auth,
    'content' => $content,
    'categories' => $categories,
    'user' => $user
]);

print($layout_content);
?>
