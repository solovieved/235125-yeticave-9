<?php
require_once 'link.php';
require_once 'data.php';
require_once 'helpers.php';
require_once 'functions.php';

$sql_cat = "SELECT id, name FROM category
    ORDER BY id";
$result_cat = mysqli_query($link, $sql_cat);
if ($result_cat) {
    $categories = mysqli_fetch_all($result_cat, MYSQLI_ASSOC);
}else {
    mysqli_error($link);
}

$content = include_template('add.php', [
    'categories' => $categories
]);

$title = 'Добаление лота';
$layout_content = include_template('layout.php', [
    'title' => $title,
    'is_auth' => $is_auth,
    'content' => $content,
    'categories' => $categories,
    'user' => $user
]);

print($layout_content);
?>
