<?php

namespace Flux\Core\Helpers;

class Mailer
{
    public static $message = "";

    public static $to = "";

    public static $subject = "";

    public static $headers = "[]";

    public static function send($to, $subject, $message, $headers=[])
    {
        $mail = mail($to, $subject, $message, $headers);
        if($mail){
            Session::create('success',"ACTIVATION MAIL SENT, CHECK YOUR INBOX");
        }
    }
}