<?php
require_once 'init.php';

$content = include_template('login.php', [
    'categories' => $categories,
]);

$title = 'Вход';
$layout_content = include_template('layout.php', [
    'title' => $title,
    'is_auth' => $is_auth,
    'content' => $content,
    'categories' => $categories,
    'user' => $user
]);

print($layout_content);
?>
