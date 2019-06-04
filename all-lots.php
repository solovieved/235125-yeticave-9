<?php
require_once 'init.php';

if (isset($_GET['cat'])) {
    $category_id = intval($_GET['cat']);
    $cur_page = $_GET['page'] ?? 1;
    $page_items = 9;
    $offset = ($cur_page - 1) * $page_items;
    $sql = "SELECT lot.id, lot.name, lot.start_price, IFNULL(MAX(bet.price), lot.start_price) AS price, lot.image, lot.date_completion, category.name AS cat, COUNT(bet.price) AS count_bet
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
}

if (isset($_GET['cat'])) {
    $cate = trim($_GET['cat']);
    $sql = "SELECT category.name FROM category
        WHERE category.id = ?";
    $stmt = db_get_prepare_stmt($link, $sql, [$cate]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result) {
        $cat = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}

if (!isset($_GET['cat']) || !$cat) {
  http_response_code(404);
  $title = 'Страница не найдена';
  $content = include_template('404.php', ['categories' => $categories]);
  $layout_content = include_template('layout.php', [
      'title' => $title,
      'content' => $content,
      'categories' => $categories,
      'user' => $user,
      'link_index' => $link_index,
  ]);
  print($layout_content);
  exit;
}

$sql = "SELECT COUNT(*) as cnt FROM lot
    WHERE category = ?";
$stmt = db_get_prepare_stmt($link, $sql, [$category_id]);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$items_count = mysqli_fetch_assoc($result)['cnt'];
$pages_count = ceil($items_count / $page_items);
$pages = range(1, $pages_count);

foreach ($categories as $key => $value) {
    if ($category_id === intval($value['id'])) {
        $title = $value['name'];
    }
}

$link = "/all-lots.php?cat=$category_id";

$pagination = include_template('pagination.php', [
    'pages' => $pages,
    'category_id' => $category_id,
    'cur_page' => $cur_page,
    'pages_count' => $pages_count,
    'link' => $link,
]);

$content = include_template('all-lots.php', [
    'categories' => $categories,
    'title' => $title,
    'lot_info' => $lot_info,
    'time_to_close' => $time_to_close,
    'pagination' => $pagination,
]);

$layout_content = include_template('layout.php', [
    'title' => $title,
    'content' => $content,
    'categories' => $categories,
    'user' => $user,
    'link_index' => $link_index,
]);

print($layout_content);
?>
