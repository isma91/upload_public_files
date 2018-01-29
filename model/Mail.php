<?php
namespace model;


class Mail
{
    public function sendMail($email, $message)
    {
        $return = array("return" => "", "error" => "");
        $messageClass = new Message();
        $config = new Config();
        $emailTo = $config->getEmailTo();
        $messages = $messageClass->getMessages();
        $subject = "";
        if (!empty($email) && !empty($message)) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $return["return"] = false;
                $return["error"] = $messages["error"]["emailFormat"];
                return $return;
            }
            $date = new \DateTime();
            $datesend = $date->format("d-m-Y H:i:s");
            $headers = "From: @gmail.com\r\n";
            $headers = $headers . "MIME-Version: 1.0\r\n";
            $headers = $headers . "Content-Type: text/html; charset=ISO-8859-1\r\n";
            $messageEmail = "";
            $send = mail($emailTo, $subject, $messageEmail, $headers);
            if($send) {
                $return["return"] = true;
                $return["error"] = "";
                return $return;
            } else {
                $return["return"] = false;
                $return["error"] = $messages["error"]["emptyField"];
                return $return;
            }
        } else {
            $return["return"] = false;
            $return["error"] = $messages["error"]["emptyField"];
            return $return;
        }
    }
}
