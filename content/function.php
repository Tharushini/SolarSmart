<?php
require('mail/PHPMailerAutoload.php');

function check_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function random_number($num = 8) {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array();
    $alphaLength = strlen($alphabet) - 1;
    for ($i = 0; $i < $num; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode("",$pass);
}

function sendMail($toEmail, $subject, $body)
{
    $adminEmail = "system email";
    $adminPassword = "password";

    try {
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';
        $mail->Username = $adminEmail;
        $mail->Password = $adminPassword;
        $mail->setFrom($adminEmail, 'ffas');
        $mail->addAddress($toEmail);
        $mail->addReplyTo($adminEmail);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = '<p>'.$body.'</p>';

        if (!$mail->send()) {
            $returnMeg = false;
        } else {
            $returnMeg = true;
        }
    } catch (phpmailerException $e) {
        $returnMeg = false;
    }
    return $returnMeg;
}
