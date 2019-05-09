<?php
require_once 'init.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $account_data = [];
    $errors = [];
    $email_max_length = 64;
    $password_max_length = 128;
    $name_max_length = 64;
    $message_max_length = 250;
    $required = [
        'email' => 'Введите e-mail',
        'password' => 'Введите пароль',
        'name' => 'Введите имя<',
        'message' => 'Напишите как с вами связаться'
    ];

    foreach ($required as $key => $value) {
        if (isset($_POST[$key]) && !empty(trim($_POST[$key]))) {
            $account_data[$key] = trim($_POST[$key]);
        } else {
            $errors[$key] = $required[$key];
        }
    }

    if(empty($errors['email'])) {
        $sql = "SELECT id FROM user WHERE email = ?";
        $stmt = db_get_prepare_stmt($link, $sql, [$_POST['email']]);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $email = '';
        if ($result) {
            $email = mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        if ($email) {
            $errors['email'] = 'Такой email уже существует';
        } elseif (strlen($account_data['email']) > $email_max_length) {
            $errors['email'] = 'e-mail не должен превышать 64 символа';
        } elseif (!filter_var($account_data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Вы ввели некорректный email';
        }
    }

    if (empty($errors['email'])) {
        $sql = "SELECT id FROM user WHERE email = ?";
        $stmt = db_get_prepare_stmt($link, $sql, [$_POST['email']]);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $email = '';

        if ($result) {
            $email = mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        if ($email) {
            $errors['email'] = 'Такой email уже существует';
        }
    }

    if (empty($errors['password']) && strlen($account_data['password']) > $password_max_length) {
        $errors['password'] = 'Пароль не может превышать 128 символов';
    }

    if (empty($errors['name']) && strlen($account_data['name']) > $name_max_length) {
        $errors['name'] = 'Имя не может превышать 64 символа';
    }

    if (empty($errors['message']) && strlen($account_data['message']) > $message_max_length) {
        $errors['message'] = 'Контактные данные не могут превышать 250 символов';
    }

    if (count($errors)) {
        $content = include_template('sign-up.php', [
            'account_data' => $account_data,
            'errors' => $errors,
            'categories' => $categories
        ]);
    } else {
        $password = password_hash($account_data['password'], PASSWORD_DEFAULT);
        $sql = "INSERT INTO user(date_registration, email, name, password, contacts)
        VALUES (NOW(), ?, ?, ?, ?)";
        $stmt = db_get_prepare_stmt($link, $sql, [$account_data['email'], $account_data['name'], $password, $account_data['message']]);
        $res = mysqli_stmt_execute($stmt);

        if ($res) {
            header("Location: login.php");
        } else {
            exit('Технические неполадки на сайте.Мы уже работаем над устранением проблемы.');
        }
    }
} else {
    $content = include_template('sign-up.php', [
        'categories' => $categories,
    ]);
}

$title = 'Регистрация';
$layout_content = include_template('layout.php', [
    'title' => $title,
    'is_auth' => $is_auth,
    'content' => $content,
    'categories' => $categories,
    'user' => $user
]);

print($layout_content);
?>
