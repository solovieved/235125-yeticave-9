<?php
require_once 'init.php';

if (isset($_GET['search'])) {
    $cur_page = $_GET['page'] ?? 1;
    if (isset($_GET['page']) && intval($_GET['page']) <= 0) {
        $cur_page = 1;
    }
    $search = trim($_GET['search'] ?? '');
    $page_items = 9;
    $sql = "SELECT COUNT(*) as cnt
        FROM lot
        WHERE MATCH(name, description) AGAINST(?)";
    $stmt = db_get_prepare_stmt($link, $sql, [$search]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $items_count = mysqli_fetch_assoc($result)['cnt'];
    $pages_count = ceil($items_count / $page_items);
    $offset = ($cur_page - 1) * $page_items;
    $pages = range(1, $pages_count);
    $sql = "SELECT lot.id, lot.name, lot.start_price, IFNULL(MAX(bet.price), lot.start_price) AS price, lot.image, lot.date_completion, category.name AS cat, COUNT(bet.price) AS count_bet FROM lot
        JOIN category ON lot.category = category.id
        LEFT JOIN bet ON bet.lot = lot.id
        WHERE MATCH(lot.name, lot.description) AGAINST(?)
        GROUP BY lot.id
        ORDER BY lot.date_creation DESC LIMIT $page_items OFFSET $offset";
    $stmt = db_get_prepare_stmt($link, $sql, [$search]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result) {
        $lot_info = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

}

$link = "/search.php?search=$search";

$pagination = include_template('pagination.php', [
    'pages' => $pages,
    'cur_page' => $cur_page,
    'pages_count' => $pages_count,
    'link' => $link,
]);

$content = include_template('search.php', [
    'categories' => $categories,
    'search' => $search,
    'lot_info' => $lot_info,
    'pagination' => $pagination,
]);

$title = 'Результаты поиска';
$layout_content = include_template('layout.php', [
    'title' => $title,
    'content' => $content,
    'categories' => $categories,
    'user' => $user,
    'link_index' => $link_index,
]);

print($layout_content);
?>

