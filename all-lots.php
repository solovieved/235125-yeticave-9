<?php
require_once 'init.php';
if (isset($_GET['cat'])) {
    $category_id = $_GET['cat'];
}

$cur_page = $_GET['page'] ?? 1;
$page_items = 9;
$sql = "SELECT COUNT(*) as cnt FROM lot
    WHERE category = $category_id";
$result = mysqli_query($link, $sql);
$items_count = mysqli_fetch_assoc($result)['cnt'];
$pages_count = ceil($items_count / $page_items);
$offset = ($cur_page - 1) * $page_items;
$pages = range(1, $pages_count);
$sql ="SELECT lot.id, lot.name, lot.start_price, IFNULL(MAX(bet.price), lot.start_price) AS price, lot.image, lot.date_completion, category.name AS cat, COUNT(bet.price) AS count_bet
    FROM lot
    JOIN category ON lot.category = category.id
    LEFT JOIN bet ON bet.lot = lot.id
    WHERE category = $category_id && lot.date_completion >= NOW()
    GROUP BY lot.id
    ORDER BY lot.date_creation DESC LIMIT $page_items OFFSET $offset";
$result = mysqli_query($link, $sql);

if ($result) {
    $lot_info = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

foreach ($categories as $key => $value) {
    if ($category_id === $value['id']) {
        $title = $value['name'];
    }
}

$pagination = include_template('pagination.php', [
    'pages' => $pages,
    'category_id'=> $category_id,
    'cur_page' => $cur_page,
    'pages_count' => $pages_count
]);

$content = include_template('all-lots.php', [
    'categories' => $categories,
    'title' => $title,
    'lot_info' => $lot_info,
    'time_to_close' => $time_to_close,
    'pagination' => $pagination
]);

$layout_content = include_template('layout.php', [
    'title' => $title,
    'content' => $content,
    'categories' => $categories,
    'user' => $user,
    'link_index' => $link_index
]);

print($layout_content);
?>
