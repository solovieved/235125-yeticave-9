<?php
require_once 'init.php';
if (!isset($_SESSION['user'])) {
    http_response_code(403);
    exit;
}
if (isset($_SESSION['user'])) {
    $user_id = $_SESSION['user']['id'];
    $sql = "SELECT bet.date_bet, bet.price, bet.lot, lot.name, lot.category, category.name AS category, lot.date_completion, lot.image FROM bet
        JOIN lot ON bet.lot = lot.id
        JOIN category ON category = category.id
        WHERE user = $user_id";
        $result = mysqli_query($link, $sql);
    if ($result) {
        $user_bet = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}
$title = 'Мои ставки';
$content = include_template('my-bets.php', [
    'categories' => $categories,
    'title' => $title,
    'user_bet' => $user_bet,
    'time_to_close' => $time_to_close
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
