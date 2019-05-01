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
$sql_cat = "SELECT name FROM category
    ORDER BY id";
$result_cat = mysqli_query($link, $sql_cat);
$time = 3600;

if (!isset($_GET['id'])) {
    $title = 'Страница не найдена';
    if ($result_cat) {
        $categories = mysqli_fetch_all($result_cat, MYSQLI_ASSOC);
    }else {
        mysqli_error($link);
    }
    $content = include_template('404.php', ['categories' => $categories]);
}else {
    if ($result_cat) {
        $categories = mysqli_fetch_all($result_cat, MYSQLI_ASSOC);
    }else {
        mysqli_error($link);
    }

    $id = $_GET['id'];
    $sql_lot ="SELECT lot.id, lot.name, lot.description, IFNULL(MAX(bet.price), lot.start_price) AS price, IFNULL(MAX(bet.price), lot.start_price) + bet_step AS min, lot.image, lot.date_completion, category.name AS cat FROM lot
    JOIN category ON category.id = lot.category
    LEFT JOIN bet ON bet.lot = lot.id
    WHERE lot.id = $id
    GROUP BY lot.id
    ORDER BY lot.date_creation DESC";
    $result_lot = mysqli_query($link, $sql_lot);

    if ($result_lot) {
        $lots_info = mysqli_fetch_all($result_lot, MYSQLI_ASSOC);
        if ($lots_info) {
            $content = include_template('lot.php', [
                'categories' => $categories,
                'lots_info' => $lots_info,
                'time' => $time
            ]);
        }else {
            $title = 'Страница не найдена';
            $content = include_template('404.php', ['categories' => $categories]);
        }
    }else {
        mysqli_error($link);
    }

    foreach ($lots_info as $key => $item) {
        $title = $item['name'];
    }
}

$layout_content = include_template('layout.php', [
    'title' => $title,
    'is_auth' => $is_auth,
    'content' => $content,
    'categories' => $categories,
    'user' => $user
]);

print($layout_content);
?>
