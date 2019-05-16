<?php
require_once 'init.php';

if (!isset($_GET['id'])) {
    http_response_code(404);
    $title = 'Страница не найдена';
    $content = include_template('404.php', ['categories' => $categories]);
}else {
    $id = intval($_GET['id']);
    $sql ="SELECT lot.id, lot.name, lot.description, IFNULL(MAX(bet.price), lot.start_price) AS price, IFNULL(MAX(bet.price), lot.start_price) + bet_step AS min, lot.image, lot.date_completion, category.name AS cat FROM lot
    JOIN category ON category.id = lot.category
    LEFT JOIN bet ON bet.lot = lot.id
    WHERE lot.id = $id
    GROUP BY lot.id
    ORDER BY lot.date_creation DESC";

    $lot_info = result($link, $sql);
    foreach ($lot_info as $key => $item) {
        $title = $item['name'];
    }
}

$errors = [];
$bet_data = [];
$lot_id = $lot_info[0]['id'];
$show_form = false;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

$lot_id = $_GET['id'];
$sql = "SELECT lot.author FROM lot
WHERE lot.id = $lot_id";
$lot_author = result($link, $sql);

if (isset($_SESSION['user']['id'])) {
    $user_id = $_SESSION['user']['id'];
    $show_form = true;
    $sql = "SELECT bet.user, bet.lot, user.id FROM bet
    JOIN user
    WHERE lot = $id
    ORDER BY date_bet DESC LIMIT 1";
    $user_bet = result($link, $sql);

    if (isset($user_bet[0]['user']) && (int)$user_bet[0]['user'] === $user_id) {
        $show_form = false;
    }

    if (strtotime($lot_info[0]['date_completion']) < strtotime('now')) {
        $show_form = false;
    }

    if ((int)$lot_author[0]['author'] === $user_id) {
        $show_form = false;
    }
};

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $required = ['cost'];
    if (isset($_POST['cost']) && !empty(trim($_POST['cost']))) {
        $bet_data['cost'] = trim($_POST['cost']);
    } else {
        $errors['cost'] = 'Сделайте ставку';
    }

    if (empty($errors['cost']) && (int)$lot_author[0]['author'] === $user_id) {
        $errors['cost'] = 'Пользователь не может делать стаки на свой лот';
    }

    if (empty($errors['cost']) && strtotime($lot_info[0]['date_completion']) < time()) {
        $errors['cost'] = 'Торги окончены';
    }

    if (empty($errors['cost']) && isset($user_bet[0]['user']) && (int)$user_bet[0]['user'] === $user_id) {
        $errors['cost'] = 'Пользователь не может делать несколько ставок подряд';
    }

    if((empty($errors['cost']) && intval($bet_data['cost']) === 0) || (empty($errors['cost']) && $_POST['cost'] < $lot_info[0]['min'])) {
        $errors['cost'] = 'Введите число не меньше минимальной стаки';
    };

    if (empty($errors) && isset($bet_data['cost'])) {
        $price = $bet_data['cost'];
        $sql = "INSERT INTO bet(date_bet, price, user, lot)
        VALUES (NOW(), $price, $user_id, $lot_id)";
        $result = mysqli_query($link, $sql);
        if ($result) {
            header("Location: ".$_SERVER['REQUEST_URI']);
        }
    }
}

$sql = "SELECT bet.date_bet, bet.price, user.name FROM bet
    JOIN user ON user.id = bet.user
    WHERE lot = $lot_id
    ORDER BY bet.date_bet DESC";
    $result = mysqli_query($link, $sql);

$bet = result($link, $sql);

$content = include_template('lot.php', [
    'categories' => $categories,
    'lot_info' => $lot_info,
    'time_to_close' => $time_to_close,
    'errors' => $errors,
    'bet' => $bet,
    'show_form' => $show_form,
    'bet_data' => $bet_data
]);

if (!$lot_info) {
    http_response_code(404);
    $title = 'Страница не найдена';
    $content = include_template('404.php', ['categories' => $categories]);
}

$layout_content = include_template('layout.php', [
    'title' => $title,
    'content' => $content,
    'categories' => $categories,
    'user' => $user,
    'link_index' => $link_index
]);

print($layout_content);
