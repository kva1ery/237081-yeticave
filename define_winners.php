<?php
require_once "vendor/autoload.php";
require_once "config/mail.php";
require_once "data.php";
require_once "functions.php";


$conn = get_connection();
$winners = get_winning_bets($conn);

if($winners) {
    $transport = new Swift_SmtpTransport($mail["host"], $mail["port"]);
    $transport->setUsername($mail["user"]);
    $transport->setPassword($mail["password"]);
    $mailer = new Swift_Mailer($transport);

    foreach ($winners as $winner) {
        $recipients = [$winner["winner_email"] => $winner["winner_name"]];

        $message = new Swift_Message();
        $message->setSubject("	Ваша ставка победила");
        $message->setFrom(["keks@phpdemo.ru" => "YetiCave"]);
        $message->setBcc($recipients);

        $msg_content = include_template("email_to_winner.php", ["winner" => $winners[0]]);
        $message->setBody($msg_content, "text/html");

        $result = $mailer->send($message);

        if($result){
            set_winning_bets($conn, $winner["bet_id"]);
        }
    }
}
