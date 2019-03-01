<?php

namespace Flux\Core\Helpers;

class Session
{
    /**
     * @var        string    $message
     */
    public $message = "";

    /**
     * @var        string    $status
     */
    public $status = "";

    /**
     * Get the value of message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set the value of message
     *
     * @param String $message
     * @return  self
     */
    public function setMessage(String $message)
    {

        $this->message = $message;
        return $this;

    }
    /**
     * Get the value of message
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @param String $status
     * @return  self
     */
    public function setStatus(String $status)
    {

        $this->status = $status;
        return $this;

    }

    /**
     *Display the session message.
     */
    public function show()
    {
        if (isset($_SESSION['message'])) {
            //echo $_SESSION['status'];
            echo $_SESSION['message'];
            //unset($_SESSION['message']);
            //unset($_SESSION['status']);
            session_destroy();
        }
    }

    /**
     * Set the message for the session
     * @param String $message
     */
    public function set(String $status, String $message)
    {
        $this->setStatus($status);
        $this->setMessage($message);
        if (!empty($this->getMessage())) {
            $_SESSION['status'] = $this->status;
            $_SESSION['message'] = $this->message;
        }
    }

    /**
     *Call the show function
     */
    public static function display()
    {
        (new Session)->show();
    }

    /**
     * Call the set function
     * @param String $message
     */
    public static function create(String $status, String $message)
    {
        (new Session)->set($status, $message);
    }
}
