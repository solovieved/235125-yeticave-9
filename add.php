<?php
require_once 'init.php';

if (!isset($_SESSION['user'])) {
    http_response_code(403);
    exit;
}

$lot_data = [];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lot_name_max_length = 64;
    $day = 86400;
    $required = [
        'lot-name' => 'Введите наименование лота',
        'category' => 'Выберите категорию',
        'message' => 'Напишите описание лота',
        'lot-rate' => 'Введите начальную цену',
        'lot-step' => 'Введите шаг ставки',
        'lot-date' => 'Введите дату в формате ГГГГ-ММ-ДД'
    ];

    foreach ($required as $key => $value) {
        if (isset($_POST[$key]) && !empty(trim($_POST[$key]))) {
            $lot_data[$key] = trim($_POST[$key]);
        } else {
            $errors[$key] = $required[$key];
        }
    }

    if (empty($errors['lot-name']) && strlen($lot_data['lot-name']) > $lot_name_max_length) {
        $errors['lot-name'] = 'Наименование лота не должно превышать 64 символа';
    }

    if (empty($errors['category'])) {
        $sql = "SELECT * FROM category WHERE id = ?";
        $stmt = db_get_prepare_stmt($link, $sql, [$_POST['category']]);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $category = '';

        if ($result) {
            $category = mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        if (!$category) {
            $errors['category'] = 'Такой категории не существует';
        }
    }

    if (empty($errors['lot-rate']) && intval($lot_data['lot-rate']) === 0) {
        $errors['lot-rate'] = 'Введите число больше 0';
    }

    if (empty($errors['lot-step']) && intval($lot_data['lot-step']) === 0) {
        $errors['lot-step'] = 'Введите число больше 0';
    }

    if (empty($errors['lot-date']) && !is_date_valid($lot_data['lot-date'])) {
        $errors['lot-date'] = 'Введите дату в верном формате';
    }

    if (empty($errors['lot-date']) && strtotime($lot_data['lot-date']) - strtotime('today') < $day) {
        $errors['lot-date'] = 'Дата завершения должна быть больше текущей хотя бы на один день';
    }

    if (isset($_FILES['lot-img']) && is_uploaded_file($_FILES['lot-img']['tmp_name'])) {
        $tmp_name = $_FILES['lot-img']['tmp_name'];
        $file_type = mime_content_type($tmp_name);
        $limit_size = 2 * 1024 * 1024;
        if (!($file_type === 'image/jpeg' || $file_type === 'image/png')) {
            $errors['lot-img'] = 'Неверный формат файла';
        } elseif ($_FILES['lot-img']['size'] > $limit_size) {
            $errors['lot-img'] = "Размер файла не должен превышать 2MB";
        }
    } else {
        $errors['lot-img'] = 'Добавьте изображение';
    }

    if (empty($errors)) {
        $rand_name = md5(time() . mt_rand(0, 9999));
        if ($file_type === 'image/jpeg') {
            $ext = '.jpg';
        }
        if ($file_type === 'image/png') {
            $ext = '.png';
        }
        $furl = '/uploads/' . $rand_name . $ext;
        move_uploaded_file($tmp_name, $_SERVER['DOCUMENT_ROOT'] . $furl);
        $sql = "INSERT INTO lot(name, description, image, start_price, date_completion, bet_step, author, category)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = db_get_prepare_stmt($link, $sql, [
            $lot_data['lot-name'],
            $lot_data['message'],
            $furl,
            intval($lot_data['lot-rate']),
            $lot_data['lot-date'],
            intval($lot_data['lot-step']),
            $_SESSION['user']['id'],
            $lot_data['category']
        ]);
        $res = mysqli_stmt_execute($stmt);

        if ($res) {
            $lot_id = mysqli_insert_id($link);
            header("Location: /lot.php?id=" . $lot_id);
        } else {
            exit('Технические неполадки на сайте.Мы уже работаем над устранением проблемы.');
        }
    }
}

$content = include_template('add.php', [
    'lot_data' => $lot_data,
    'errors' => $errors,
    'categories' => $categories
]);

$title = 'Добаление лота';
$layout_content = include_template('layout.php', [
    'title' => $title,
    'content' => $content,
    'categories' => $categories,
    'user' => $user,
    'link_index' => $link_index
]);

print($layout_content);
?>
