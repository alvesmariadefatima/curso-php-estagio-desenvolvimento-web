<?php
// Senha: mfnal1234
// Email: mnunesalves334@gmail.com
// host: smtp.gmail.com
// porta: 587

use PHPMailer\PHPMailer\PHPMailer;

require 'vendor/autoload.php';

$mail = new PHPMailer;
$mail->isSMTP();
$mail->SMTPDebug = 2;
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->SMTPAuth = true;
$mail->Username = 'mnunesalves334@gmail.com';
$mail->Password = 'mfnal1234';

$mail->SMTPSecure = false;
$mail->isHTML(true);
$mail->CharSet = 'UTF-8';

$mail->setFrom('mnunesalves334@gmail.com', "Teste PHP");
$mail->addAddress('sidova9331@bsomek.com');
$mail->Subject = 'E-mail de teste';

$mail->msgHTML("<h1>Email enviado com sucesso!</h1><p>Parabéns, deu tudo certo!</p>");

if ($mail->send()) {
    echo "E-mail enviado com sucesso!";
} else {
    echo "Falha ao enviar e-mail.";
}