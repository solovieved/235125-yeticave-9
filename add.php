<?php
require_once 'link.php';
require_once 'data.php';
require_once 'helpers.php';
require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lot_data = $_POST;
    $required = [
        'lot-name' => 'Введите наименование лота',
        'category' => 'Выберите категорию',
        'message' => 'Напишите описание лота'
    ];
    $errors = [];

    foreach ($required as $key => $value) {
        if(empty($_POST[$key])) {
            $errors[$key] = $required[$key];
        }
    }
    if (isset($_FILES['lot-img']['name'])) {
		$tmp_name = $_FILES['lot-img']['tmp_name'];
		$path = $_FILES['lot-img']['name'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $tmp_name);
        if ($file_type !== "image/jpg" && $file_type !== "image/jpeg" && $file_type !== "image/png") {
            $errors['lot-img'] = 'Загрузите файл в формате jpg, jpeg, png';
        }else {
			move_uploaded_file($tmp_name, 'uploads/' . $path);
			$lot_data['path'] = $path;
		}
    }else {
		$errors['lot-img'] = 'Загрузите файл';
    }

    if ((int)($_POST['lot-rate']) == null) {
        $errors['lot-rate'] = 'Введите начальную цену';
    }

    if (!(int)($_POST['lot-rate']) && ($_POST['lot-rate']) != null) {
        $errors['lot-rate'] = 'В поле не могут находится никакие символы, кроме чисел больше нуля';
    }

    if ((int)($_POST['lot-step']) == null) {
        $errors['lot-step'] = 'Введите шаг ставки';
    }

    if (!(int)($_POST['lot-step']) && ($_POST['lot-step']) != null) {
        $errors['lot-step'] = 'В поле не могут находится никакие символы, кроме чисел больше нуля';
    }

    if (is_date_valid($_POST['lot-date']) == null) {
        $errors['lot-date'] = 'Введите дату в формате ГГГГ-ММ-ДД';
    }

    if (count($errors)) {
            $content = include_template('add.php', [
            'lot_data' => $lot_data,
            'errors' => $errors,
            'categories' => $categories
        ]);
    }
}else {
    $content = include_template('add.php', [
        'categories' => $categories
    ]);
}

$title = 'Добаление лота';
$layout_content = include_template('layout.php', [
    'title' => $title,
    'is_auth' => $is_auth,
    'content' => $content,
    'categories' => $categories,
    'user' => $user
]);

print($layout_content);
?>
