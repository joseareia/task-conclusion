<?php
require 'app.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

$subject = $_POST['tarefa']." concluída(os) - OSV ".$_POST['or']." Viatura ".$_POST['matricula'];
$body = "A Tarefa <b>".$_POST['tarefa']."</b> da OSV <b>".$_POST['or']."</b> da Viatura <b>".$_POST['matricula']."</b> foi concluída por <b>".$_POST['colaborador']."</b>.";

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
