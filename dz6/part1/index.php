<?php
require 'vendor/autoload.php';

$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.yandex.ru';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'missis.leurdo2017';                 // SMTP username
$mail->Password = 'leurdo';                           // SMTP password
$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465;                                    // TCP port to connect to
$mail->CharSet = 'utf-8';

$mail->setFrom('missis.leurdo2017@yandex.ru', 'Mailer');
$mail->addAddress('katya.leurdo@gmail.com', 'Katya User');     // Add a recipient
$mail->addReplyTo('missis.leurdo2017@yandex.ru', 'Information');

$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Письмо от мейлера';
$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}