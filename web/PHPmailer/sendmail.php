<?php
function Send_Mail($to,$subject,$body)
{
    require '/PHPMailer/class.phpmailer.php';
    $from = "nguyen.tien@mulodo.com";
    $mail = new PHPMailer();
    $mail->IsSMTP(true); // SMTP
    $mail->SMTPAuth   = true;  // SMTP authentication
    $mail->Mailer = "smtp";
    $mail->Host= "tls://email-smtp.us-east.amazonaws.com"; // Amazon SES
    $mail->Port = 465;  // SMTP Port
    $mail->Username = "AKIAIM3HS7UUXEQ4GTPA";  // SMTP  Username
    $mail->Password = "AqF6E+ZsiPdZd+mvMhkRgiQvQH7tGH9Ky5POVQCG63qX";  // SMTP Password
    $mail->SetFrom($from, 'Tien nguyen');
    $mail->AddReplyTo($from,'Technical Support');
    $mail->Subject = $subject;
    $mail->MsgHTML($body);
    $address = $to;
    $mail->AddAddress($address, $to);
    if(!$mail->Send())
        return false;
    else
        return true;
}

$to = 'vytien@gmail.com';
$subject = 'Test mail from AWS';
$body = 'test body';
$rst = Send_Mail($to,$subject,$body);
if ($rst) echo "Success";
else echo "Fail";
?>