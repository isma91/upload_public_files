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
        $config = new Config();
        return $this->messages;
    }

    /**
     * Message constructor.
     */
    public function __construct()
    {
        $errorMessage = array(
        );
        $successMessage = array(
            "adminCreated" => "Vous avez ajouté l'admin %s avec succès.",
            "updateColor" => "Couleur %s modifier avec succès.",
        );
        $infoMessage = array(
            "maintenance" => "Le site affiche qu'il est en maintenance."
        );
        $this->messages = array("error" => $errorMessage, "success" => $successMessage, "info" => $infoMessage);
    }
}