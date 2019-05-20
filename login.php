<?php
require_once 'init.php';

if (isset($_SESSION['user'])) {
    header("Location: /");
    exit;
}

$login_data = [];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $required = [
        'email' => 'Введите e-mail',
        'password' => 'Введите пароль'
    ];

    foreach ($required as $key => $value) {
        if (isset($_POST[$key]) && !empty(trim($_POST[$key]))) {
            $login_data[$key] = trim($_POST[$key]);
        } else {
            $errors[$key] = $required[$key];
        }
    }

    if (empty($errors['email'])) {
        $sql = "SELECT * FROM user WHERE email = ?";
        $stmt = db_get_prepare_stmt($link, $sql, [trim($login_data['email'])]);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($result) {
            $user = mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        if (!$user) {
            $errors['email'] = 'Пользователя с таким email не существует';
        }
    }

    if (empty($errors['password'])) {
        if (isset($user[0]['password']) && password_verify($_POST['password'], $user[0]['password'])) {
            $_SESSION['user'] = $user[0];
            header("Location: /");
            exit;
        } else {
            $errors['password'] = 'Неверный пароль';
        }
    }
}

$content = include_template('login.php', [
    'login_data' => $login_data,
    'errors' => $errors,
    'categories' => $categories
]);

$title = 'Вход';
$layout_content = include_template('layout.php', [
    'title' => $title,
    'content' => $content,
    'categories' => $categories,
    'user' => $user,
    'link_index' => $link_index
]);

print($layout_content);
?>
