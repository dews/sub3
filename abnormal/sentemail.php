<?php
date_default_timezone_set("Asia/Taipei");
require_once('./class.phpmailer.php');
//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
$mail->SetLanguage("zh", "./language/");
$mail->IsSMTP(); // telling the class to use SMTP
$resAddress=$_POST[email];
try {
  $mail->Host       = "mail.yourdomain.com"; // SMTP server
  $mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
  $mail->SMTPAuth   = true;                  // enable SMTP authentication
  $mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
  $mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
  $mail->Port       = 465;                   // set the SMTP port for the GMAIL server
  $mail->Username   = "nkutgod@gmail.com";  // GMAIL username
  $mail->Password   = "E428E428";            // GMAIL password
  //$mail->AddReplyTo('', 'First Last');
  $mail->AddAddress($resAddress, 'John Doe');//收件者地址
  $mail->SetFrom('nkutgod@gmail.com', 'GGGGGG');//寄信者來源及名稱
  //$mail->AddReplyTo('', 'First Last');
  $mail->Subject = "=?UTF-8?B?" . base64_encode("銀髮族智慧生活整合創新計劃") . "?=";//避免郵件標題亂碼
  //$mail->Subject = '銀髮族智慧生活整合創新計劃';
  $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional - MsgHTML will create an alternate automatically
  $mail->MsgHTML(file_get_contents('contents.htm'));
 // $mail->AddAttachment('images/phpmailer.gif');      // attachment
  //$mail->AddAttachment('images/phpmailer_mini.gif'); // attachment
  $mail->Send();
  echo "Message Sent OK</p>\n";
} catch (phpmailerException $e) {
  echo $e->errorMessage(); //Pretty error messages from PHPMailer
} catch (Exception $e) {
  echo $e->getMessage(); //Boring error messages from anything else!
}
?>