<?php
require 'app.php';
require_login();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

$tarefa = htmlspecialchars($_POST['tarefa'] ?? '');
$or = htmlspecialchars($_POST['or'] ?? '');
$matricula = htmlspecialchars($_POST['matricula'] ?? '');
$colaborador = htmlspecialchars($_POST['colaborador'] ?? '');

$subject = $tarefa." concluída(os) - OSV ".$or." Viatura ".$matricula;
$body = "A Tarefa <b>".$tarefa."</b> da OSV <b>".$or."</b> da Viatura <b>".$matricula."</b> foi concluída por <b>".$colaborador."</b>.";

$response = array();

try {
    $mail->isSMTP();
    $mail->Host = $_ENV['MAIL_HOST'];
    $mail->SMTPAuth = true;
    $mail->Port = $_ENV['MAIL_PORT'];
    $mail->Username = $_ENV['MAIL_USERNAME'];
    $mail->Password = $_ENV['MAIL_PASSWORD'];

    $mail->CharSet = 'UTF-8';
    $mail->ContentType = 'text/plain';

    //Recipients
    $mail->setFrom($_ENV["MAIL_FROM_ADDRESS"], $_ENV["MAIL_FROM_NAME"]);
    $mail->addAddress($_ENV["MAIL_TO_ADDRESS"], $_ENV["MAIL_TO_NAME"]);
    $mail->addCC($_ENV["MAIL_TO_ADDRESS_CC"]);

    //Content
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $body;
    $mail->AltBody = $body;

    $mail->send();

    $response['code'] = 200;
    exit(json_encode($response));
} catch (Exception $e) {
    $response['code'] = 406;
    $response['message'] = $mail->ErrorInfo;
    exit(json_encode($response));
}
?>
