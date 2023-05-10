<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor\autoload.php';
require 'design.php';

$email = new PHPMailer(TRUE);


$mail = new \PHPMailer\PHPMailer\PHPMailer();
//$mail->SMTPDebug = 3;
//$to = 'p146057@nu.edu.pk';
$to = 'wajahat.jadoon@abacuscamdridge.com';

//$CC = 'acct.lalagroup@gmail.com';

$subject = 'Computer Generated Email Sent. Using SMTP';

$mail->isSMTP();
$mail->Host = 'mail.umrahfuras.com';
$mail->SMTPAuth = true;
$mail->Username = 'accounts@umrahfuras.com';
$mail->Password = 'Accounts@LALA';
$mail->SMTPSecure = 'ssl';
$mail->Port = 465;

$mail->From = "accounts@umrahfuras.com";
$mail->FromName = "Umrah Furas";
$mail->addAddress($to);
$mail->isHTML(true);
$mail->Subject = $subject;

$mail->AddCC('p146057@nu.edu.pk');
$mail->AddCC('acct.lalagroup@gmail.com');
$mail->AddCC('info@orixestech.com');

$EMAILHTML = 'Below Details For SMTP Server are: <br> Incoming Server : mail.umrahfuras.com <br> IMAP Port: (993) <br> POP3 Port: (995)  <br> Outgoing Server : mail.umrahfuras.com <br> SMTP Port: 465 <br> UserName : accounts@umrahfuras.com <br> Password : Accounts@LALA';
$mail->Body = $EMAILHTML;
$mail->AltBody = strip_tags($EMAILHTML);

if ($mail->send())
    return ['status' => true, 'message' => "Email successfully Send...!"];
else
    return ['status' => false, 'message' => "Mailer Error: " . $mail->ErrorInfo];

?>