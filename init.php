<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once 'vendor/autoload.php';
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
    $user = $_SESSION['user']['name'];
}
$time_to_close = 3600;
$lot_info = [];
$categories = [];
$link_index = 'href = "/"';
$sql = "SELECT * FROM category
    ORDER BY id";
$categories = get_array($link, $sql);
?>
