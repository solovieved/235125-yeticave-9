<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$is_auth = rand(0, 1);
$user = [];
$time = 3600;
$categories = [];
$lots_info = [];

if ($is_auth == 1) {
    $user['name'] = 'Edgar';
};

$sql_cat = "SELECT * FROM category
    ORDER BY id";
$result_cat = mysqli_query($link, $sql_cat);
if ($result_cat) {
    $categories = mysqli_fetch_all($result_cat, MYSQLI_ASSOC);
}else {
    mysqli_error($link);
}
?>
