<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once 'helpers.php';
require_once 'functions.php';

session_start();

$link = mysqli_connect('localhost', 'root', '', 'yeticave_235125');
mysqli_set_charset($link, 'utf8');

if (!$link) {
    exit('сайт временно не работает');
}

$user = [];
if (isset($_SESSION['user'])) {
    $sql = "SELECT name FROM user WHERE id = ?";
    $stmt = db_get_prepare_stmt($link, $sql, [$_SESSION['user']['id']]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result) {
        $user = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}
$time_to_close = 3600;
$lot_info = [];
$categories = [];
$sql_cat = "SELECT * FROM category
    ORDER BY id";
$result_cat = mysqli_query($link, $sql_cat);
if ($result_cat) {
    $categories = mysqli_fetch_all($result_cat, MYSQLI_ASSOC);
}else {
    mysqli_error($link);
}
?>
