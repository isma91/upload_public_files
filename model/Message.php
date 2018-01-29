<?php
namespace model;
/**
 * Class Message
 * @package model
 */
/**
 * Class Message
 * @package model
 */
class Message
{
    /**
     * @var array
     */
    public $messages = array();

    /**
     * @return array
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * Message constructor.
     */
    public function __construct()
    {
        $config = new Config();
        $emailTo = $config->getEmailTo();
        $errorMessage = array(
            "emptyField" => "The following field are empty: %s !!",
            "emailNotValid" => "Your email is not valid !!",
            "passwordNotLong" => "The two password fields must be at least 4 characters long !!",
            "passwordNotSame" => "The two password field must be the same !!",
            "usernameNotLong" => "The username must be at least 4 characters long !!",
            "duplicateEmail" => "Email already taken !!",
            "duplicateUsername" => "Username already taken !!",
            "somethingGotWrong" => "Something got wrong when we try to %s please send email to '" . $emailTo . "' !!",
        );
        $successMessage = array(
            "register" => "You successfully registered yourself !! You can now log in !!",
        );
        $infoMessage = array(
            "maintenance" => "The site is in maintenance, come back later or send email to '" . $emailTo . "' !!",
        );
        $this->messages = array("error" => $errorMessage, "success" => $successMessage, "info" => $infoMessage);
    }
}