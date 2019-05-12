<?php
require_once 'init.php';

if (!isset($_GET['id'])) {
    http_response_code(404);
    $title = 'Страница не найдена';
    $content = include_template('404.php', ['categories' => $categories]);
}else {
    $id = intval($_GET['id']);
    $sql_lot ="SELECT lot.id, lot.name, lot.description, IFNULL(MAX(bet.price), lot.start_price) AS price, IFNULL(MAX(bet.price), lot.start_price) + bet_step AS min, lot.image, lot.date_completion, category.name AS cat FROM lot
    JOIN category ON category.id = lot.category
    LEFT JOIN bet ON bet.lot = lot.id
    WHERE lot.id = $id
    GROUP BY lot.id
    ORDER BY lot.date_creation DESC";
    $result_lot = mysqli_query($link, $sql_lot);

    if ($result_lot) {
        $lot_info = mysqli_fetch_all($result_lot, MYSQLI_ASSOC);
    }else {
        mysqli_error($link);
    }

    $content = include_template('lot.php', [
        'categories' => $categories,
        'lot_info' => $lot_info,
        '$time_to_close' => $time_to_close
    ]);

    if (!$lot_info) {
        http_response_code(404);
        $title = 'Страница не найдена';
        $content = include_template('404.php', ['categories' => $categories]);
    }

    foreach ($lot_info as $key => $item) {
        $title = $item['name'];
    }
}

$layout_content = include_template('layout.php', [
    'title' => $title,
    'content' => $content,
    'categories' => $categories,
    'user' => $user
]);

print($layout_content);
?>
