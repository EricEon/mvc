<?php

namespace Flux\Core\Helpers;

use Flux\Helpers\FileLogger;
use PHPMailer\PHPMailer\PHPMailer;

class Mailer
{

    /**
     * send.
     *
     * @author    eonflux
     * @since    v0.0.1
     * @version    v1.0.0    Friday, March 1st, 2019.
     * @access    public static
     * @param    mixed    $to
     * @param    mixed    $subject
     * @param    mixed    $message
     * @param    mixed    $headers
     * @return    void
     */
    public static function send($to, $subject, $message, $headers = [])
    {

        try {
            //Server settings
            $mail = new PHPMailer(true); // Passing `true` enables exceptions
            $mail->isSMTP(); // Set mailer to use SMTP
            $mail->Host       = $_ENV['MAIL_SMTP']; // Specify main and backup SMTP servers
            $mail->SMTPAuth   = true; // Enable SMTP authentication
            $mail->Username   = $_ENV['MAIL_USERNAME']; // SMTP username
            $mail->Password   = $_ENV['MAIL_PASSWORD']; // SMTP password
            $mail->SMTPSecure = $_ENV['MAIL_SECURITY']; // Enable TLS encryption, `ssl` also accepted
            $mail->Port       = $_ENV['MAIL_PORT']; // TCP port to connect to
            //$mail->SMTPDebug = 2; // Enable verbose debug output

            //Recipients
            $mail->setFrom('admin@mvc.test', 'Mailer');
            // $mail->addAddress('joe@example.net', 'Joe User'); // Add a recipient
            $mail->addAddress($to); // Name is optional
            $mail->addReplyTo('admin@mvc.test', 'Information');

            //Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $message;

            $sending = $mail->send();
            if ($sending) {
                return true;
            }else{
                return false;
            }

            //Session::create('success', "ACTIVATION MAIL SENT, CHECK YOUR INBOX");

        } catch (\Throwable $e) {
            //Session::create('danger', "ERROR SENDING MAIL");
            //FileLogger::error("Message could not be sent. Mailer Error: " . $e->getMessage());
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }

    }
}
