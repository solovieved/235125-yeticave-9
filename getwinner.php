<?php
$sql = "SELECT lot.id, lot.name, bet.user FROM bet
    JOIN lot ON bet.lot = lot.id
    WHERE bet.id IN (SELECT MAX(id) FROM bet
    GROUP BY lot) && lot.date_completion <= NOW() && lot.winner is NULL";
$lot = get_array($link, $sql);
if (!empty($lot)) {
    foreach ($lot as $key => $value) {
        $sql = "UPDATE lot SET winner = ?
            WHERE id = ?";
        $stmt = db_get_prepare_stmt($link, $sql, [$value['user'], $value['id']]);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            $res = mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        $transport = new Swift_SmtpTransport("phpdemo.ru", 25);
        $transport->setUsername("keks@phpdemo.ru");
        $transport->setPassword("htmlacademy");
        $mailer = new Swift_Mailer($transport);
        $logger = new Swift_Plugins_Loggers_ArrayLogger();
        $mailer->registerPlugin(new Swift_Plugins_LoggerPlugin($logger));
        $sql = "SELECT id, name, email FROM user WHERE id = {$value['user']}";
        $winner = get_array($link, $sql);

        $message = new Swift_Message();
        $message->setSubject('Ваша ставка победила!');
        $message->setFrom(['keks@phpdemo.ru' => 'Yeticave']);
        $message->setTo($winner[0]['email'], $winner[0]['name']);
        $msg_content = include_template('email.php', [
            'winner' => $winner,
            'value' => $value,
        ]);
        $message->setBody($msg_content, 'text/html');
        $mailer->send($message);
    }
}

?>
