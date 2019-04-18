<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once 'helpers.php';
require_once 'functions.php';

$is_auth = rand(0, 1);
$user = [];

if ($is_auth == 1) {
    $user['name'] = 'Edgar';
};

$categories = [
    [
        'name' => 'Доски и лыжи',
        'class' => 'boards'
    ],
    [
        'name' => 'Крепления',
        'class' => 'attachment'
    ],
    [
        'name' => 'Ботинки',
        'class' => 'boots'
    ],
    [
        'name' => 'Одежда',
        'class' => 'clothing'
    ],
    [
        'name' => 'Инструменты',
        'class' => 'tools'
    ],
    [
        'name' => 'Разное',
        'class' => 'other'
    ]
];
$lots_info = [
    [
        'title' => '2014 Rossignol District Snowboard',
        'category' => 'Доски и лыжи',
        'price' => '10999',
        'url_img' => 'img/lot-1.jpg'
    ],
    [
        'title' => 'DC Ply Mens 2016/2017 Snowboard',
        'category' => 'Доски и лыжи',
        'price' => '159999',
        'url_img' => 'img/lot-2.jpg'
    ],
    [
        'title' => 'Крепления Union Contact Pro 2015 года размер L/XL',
        'category' => 'Крепления',
        'price' => '8000',
        'url_img' => 'img/lot-3.jpg'
    ],
    [
        'title' => 'Ботинки для сноуборда DC Mutiny Charocal',
        'category' => 'Ботинки',
        'price' => '10999',
        'url_img' => 'img/lot-4.jpg'
    ],
    [
        'title' => 'Куртка для сноуборда DC Mutiny Charocal',
        'category' => 'Одежда',
        'price' => '7500',
        'url_img' => 'img/lot-5.jpg'
    ],
    [
        'title' => 'Маска Oakley Canopy',
        'category' => 'Разное',
        'price' => '5400',
        'url_img' => 'img/lot-6.jpg'
    ]
];
$title = 'Главная';

$content = include_template('index.php', [
    'categories' => $categories,
    'lots_info' => $lots_info
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
