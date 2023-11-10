<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mailer extends PHPMailer
{
    function mailServerSetup()
    {
        $emailPasswdEnv = $_ENV['PASSWORD'];
        //Server settings
        //$this->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $this->isSMTP();                                            //Send using SMTP
        $this->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $this->SMTPAuth = true;                                   //Enable SMTP authentication
        $this->Username = 'ernest.vila@cirvianum.cat';                     //SMTP username
        $this->Password = $emailPasswdEnv;                               //SMTP password
        $this->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $this->Port = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    }

    function addRec($to, $cc = array(), $bcc = array())
    {
        $this->setFrom('confirm.email@dr0ive.cat', 'Dr0ive');
        foreach ($to as $address) {
            $this->addAddress($address);
        }
        foreach ($cc as $address) {
            $this->addCC($address);
        }
        foreach ($bcc as $address) {
            $this->addBCC($address);
        }
    }

    function addRecCustom($to, $from, $cc = array(), $bcc = array())
    {
        $this->setFrom('confirm.email@dr0ive.cat', $from);
        foreach ($to as $address) {
            $this->addAddress($address);
        }
        foreach ($cc as $address) {
            $this->addCC($address);
        }
        foreach ($bcc as $address) {
            $this->addBCC($address);
        }
    }

    function addAttachments($att)
    {
        foreach ($att as $attachment) {
            $this->addAttachment($attachment);
        }
    }

    function addVerifyContent($user = null)
    {
        $this->isHTML(true);
        $this->Subject = 'Verifica el teu correu electrònic';

        $greeting = "<p>Hola " . $user['firstname'] . " " . $user['lastname'] . ",</p>";
        $verificationText = "<p>Clica al botó següent per verificar la teva adreça de correu electrònic:</p>";
        $verificationButton = "<a style='display: inline-block; padding: 10px 20px; background-color: #3498db; color: #fff; text-decoration: none; border-radius: 5px;' href='http://localhost/user/verify/?username=" . $user['username'] . "&token=" . $user['token'] . "'>Verifica</a>";

        $content = $greeting . $verificationText . $verificationButton;

        $this->Body = $content;
    }

    function addVerifyContentCustom($subject, $body)
    {
        $this->isHTML(false);
        $this->Subject = $subject;
        $content = $body;
        $this->Body   = $content;
    }
}
