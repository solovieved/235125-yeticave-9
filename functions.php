<?php
/**
 * Форматирует число в соответствии с заданием
 *
 * @param $price число для форматирования
 * @return string $price результат — отформатированное число
 */
function get_formatted_amount($price): string
{
    $price = ceil($price);

    if ($price >= 1000) {
        $price = number_format($price, 0, '', ' ');
    }

    return $price;
}

/**
 * Время до истечения лота
 *
 * @param $date_completion дата окончания
 * @return string $time время в нужном виде
 */
function get_time_completion($date_completion): string
{
    $time = strtotime($date_completion) - strtotime('now');
    if ($time < 86400) {
        $time = gmdate('H:i', $time);
    } elseif ($time <= 432000) {
        $time = intval($time / 86400).' дн.';
    } else {
        $time = gmdate("d.m.y",
            strtotime($date_completion) + 86400);
    }

    return $time;
}

/**
 * Показывает сколько времени назад была сделана ставка
 * @param $time время в формате unix
 * @return string результат
 */
function show_time($time)
{
    $time_ago = time() - $time;
    if ($time_ago < 3600) {
        return intval($time_ago / 60).' '.get_noun_plural_form($time_ago / 60, 'минута', 'минуты',
                'минут').' назад';
    } elseif ($time_ago < 86400) {
        return intval($time_ago / 3600).' '.get_noun_plural_form($time_ago / 3600, 'час', 'часа',
                'часов').' назад';
    }
    return date('d.m.y', $time).' в '.date('H:i', $time);
}

/**
 * Получает массив из sql-запроса
 * @param $link ресурс соединения
 * @param $sql sql запрос
 * @return array массив из sql
 */
function get_array($link, $sql)
{
    $result = mysqli_query($link, $sql);
    if ($result) {
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        mysqli_error($link);
    }

    return $result;
}

?>
