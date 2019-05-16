<?php
$sql = "SELECT lot.id, bet.user FROM bet
    JOIN lot ON bet.lot = lot.id
    WHERE bet.id IN (SELECT MAX(id) FROM bet
    GROUP BY lot) && lot.date_completion <= NOW() && lot.winner is NULL";

$win = result($link, $sql);

foreach ($win as $key => $value) {
    $sql = "UPDATE lot SET winner = {$value['user']}
        WHERE id = {$value['id']}";
    result($link, $sql);
}

?>
