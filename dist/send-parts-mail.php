<?php
require 'app.php';
require_login();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

$request = json_decode(file_get_contents('php://input'));

$user = htmlspecialchars($request[0]->user ?? '');

$subject = "Registo e/ou Pedido de Peças - " . $user;

$body = "<html>";
$body .= "<head>";
$body .= "<style>";
$body .= "body{font-family:Verdana, Arial, Helvetica, sans-serif;}";
$body .= "td,th{border:1px solid #dddddd;padding:8px;text-align:left;}";
$body .= "</style>";
$body .= "</head>";
$body .= "<body>";
$body .= "Abaixo encontra-se a tabela das peças registadas e/ou pedidas pelo(a) colaborador(a) <b>" . $user . "</b>.";
$body .= "</br></br>";
$body .= "<table style='border-collapse: collapse;'>";
$body .= "<thead>";
$body .= "<tr>";
$body .= "<th>Referência / Descrição</th>";
$body .= "<th>Quantidade</th>";
$body .= "<th>Tipo de Pedido</th>";
$body .= "<th>Observações</th>";
$body .= "</tr>";
$body .= "</thead>";
$body .= "<tbody>";
foreach ($request as $p) {
    $reference = htmlspecialchars($p->reference ?? '');
    $quantity = htmlspecialchars($p->quantity ?? '');
    $part_type = htmlspecialchars($p->part_type ?? '');
    $or = htmlspecialchars($p->or ?? '');
    $license_plate = htmlspecialchars($p->license_plate ?? '');
    $obs = htmlspecialchars($p->obs ?? '');

    $body .= "<tr>";
    $body .= "<td>" . $reference . "</td>";
    $body .= "<td>" . $quantity . "</td>";

    switch ($part_type) {
        case 'OSV':
            $body .= "<td>" . $part_type . ": #" . $or . "</td>";
        break;
        case 'Matrícula':
            $body .= "<td>" . $part_type . ": " . $license_plate . "</td>";
        break;
        default:
            $body .= "<td>" . $part_type . "</td>";
    }

    if ($obs !== '') {
        $body .= "<td>" . $obs . "</td>";
    } else {
        $body .= "<td> - </td>";
    }
    $body .= "</tr>";
}
$body .= "</tbody>";
$body .= "</table>";
$body .= "</body>";
$body .= "</html>";

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
