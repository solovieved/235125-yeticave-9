<?php
$link = mysqli_connect('localhost', 'root', '', 'yeticave_235125');
mysqli_set_charset($link, 'utf8');

if (!$link) {
    exit('сайт временно не работает');
}
?>
