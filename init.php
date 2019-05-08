<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
require_once 'helpers.php';
require_once 'functions.php';
$is_auth = rand(0, 1);
$user = [];
$hour = 3600;
$categories = [];
$link = mysqli_connect('localhost', 'root', '', 'yeticave_235125');
mysqli_set_charset($link, 'utf8');
if ($is_auth == 1) {
    $user['id'] = 1;
    $user['name'] = 'Edgar';
};

if (!$link) {
    exit('сайт временно не работает');
}

$sql_cat = "SELECT * FROM category
    ORDER BY id";
$result_cat = mysqli_query($link, $sql_cat);
if ($result_cat) {
    $categories = mysqli_fetch_all($result_cat, MYSQLI_ASSOC);
}else {
    mysqli_error($link);
}
?>
