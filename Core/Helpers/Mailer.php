<?php

namespace Flux\Core\Helpers;

class Mailer
{

    /**
     * send.
     *
     * @author	eonflux
     * @since	v0.0.1
     * @version	v1.0.0	Friday, March 1st, 2019.
     * @access	public static
     * @param	mixed	$to     	
     * @param	mixed	$subject	
     * @param	mixed	$message	
     * @param	mixed	$headers	
     * @return	void
     */
    public static function send($to, $subject, $message, $headers)
    {
        $mail = mail($to, $subject, $message, $headers);
        //dd($mail);
        try {
            if($mail){
                Session::create('success',"ACTIVATION MAIL SENT, CHECK YOUR INBOX");
            }
        } catch (\Exception $th) {
            throw $th;
            Session::create('danger',"ERROR SENDING ACTIVATION MAIL");
        }
        
        
    }
}