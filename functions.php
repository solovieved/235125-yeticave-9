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
?>
