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
?>
