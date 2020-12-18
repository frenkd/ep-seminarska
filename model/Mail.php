<?php

/**
 * This example shows settings to use when sending via Google's Gmail servers.
 * This uses traditional id & password authentication - look at the gmail_xoauth.phps
 * example to see how to use XOAUTH2.
 * The IMAP section shows how to save this message to the 'Sent Mail' folder using IMAP commands.
 */

//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
require 'vendor/autoload.php';

function sendConfirmationMail(array $params) {
    // $params = mailAddress, mailName


    //Create a new PHPMailer instance
    $mail = new PHPMailer();

    //Tell PHPMailer to use SMTP
    $mail->isSMTP();

    //Enable SMTP debugging
    // SMTP::DEBUG_OFF = off (for production use)
    // SMTP::DEBUG_CLIENT = client messages
    // SMTP::DEBUG_SERVER = client and server messages
    $mail->SMTPDebug = SMTP::DEBUG_OFF;

    //Set the hostname of the mail server
    $mail->Host = 'smtp.gmail.com';
    // use
    // $mail->Host = gethostbyname('smtp.gmail.com');
    // if your network does not support SMTP over IPv6

    //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
    $mail->Port = 587;

    //Set the encryption mechanism to use - STARTTLS or SMTPS
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

    //Whether to use SMTP authentication
    $mail->SMTPAuth = true;

    require 'secret_keys.php';

    //Username to use for SMTP authentication - use full email address for gmail
    $mail->Username = $secretEPseminarska['mailUsername'];

    //Password to use for SMTP authentication
    $mail->Password = $secretEPseminarska['mailPassword'];

    //Set who the message is to be sent from
    $mail->setFrom($secretEPseminarska['mailEmail'], 'Elektronski poslovalec');

    //Set an alternative reply-to address
    $mail->addReplyTo($secretEPseminarska['mailEmail'], 'Elektronski poslovalec');

    //Set who the message is to be sent to
    $mail->addAddress($params['mailAddress'], $params['mailName']);

    //Set the subject line
    $mail->Subject = 'PHPMailer GMail SMTP test';

    $mail->isHTML(true);
    $mail->Subject = 'Sneakers website confirmation mail';
    $mail->Body    = 'Click this link to complete registration: <a href="'.$params['mailLink'].'">Confirmation link</a> ';
    $mail->AltBody = 'Copy this address into your browser address bar: '.$params['mailLink'];

    //send the message, check for errors
    if (!$mail->send()) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'Message sent!';
    }
}


