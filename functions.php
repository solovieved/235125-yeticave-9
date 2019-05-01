<?php
/**
 * Форматирует число в соответствии с заданием
 *
 * @param $price число для форматирования
 * @return $price . '<b class="rub">р</b>' результат — отформатированное число со знаком рубля
 */
function get_formatted_amount($price) {
    $price = ceil($price);

    if ($price >= 1000) {
            $price = number_format($price, 0, '', ' ');
    }

    return $price . '<b class="rub">р</b>';
}

/**
 * Время до истечения лота
 *
 * @param $date_completion дата окончания
 * @return $time время в нужном виде
 */
function get_time_completion($date_completion) {
    $time = strtotime($date_completion) - strtotime('now');
    if ($time < 86400) {
        $time = gmdate('H:i', $time);
    } elseif ($time <= 432000) {
        $time = round($time / 86400) . ' дн.';
    } else {
        $time = gmdate("d.m.y", strtotime($date_completion) + 86400); //показывает дату на день меньше по этому прибавил 86400
    }

    return $time;
}
?>
