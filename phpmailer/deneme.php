<?php

require_once 'class.phpmailer.php';

$mail = new PHPMailer;
$mail->setFrom('mail@yorumdeposu.com', 'Your Name');
$mail->Username = "mail@yorumdeposu.com";
$mail->Password = "Abmelden246158";
$mail->addAddress('orakmetin@gmail.com', 'My Friend');
$mail->Subject  = 'First PHPMailer Message';
$mail->Body     = 'Hi! This is my first e-mail sent through PHPMailer.';




if(!$mail->send()) {
  echo 'Message was not sent.';
  echo 'Mailer error: ' . $mail->ErrorInfo;
} else {
  echo 'Message has been sent.';
}



?>