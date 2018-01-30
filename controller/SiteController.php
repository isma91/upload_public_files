<?php

namespace controller;

use model\Bdd;
use model\Config;
use model\Mail;
use model\Message;
use model\View;

class SiteController
{
    public function checkMaintenance($page, array $array = array()) {
        $config = new Config();
        if ($config->getMaintenance() === "true") {
            $view = new View("site#maintenance");
            $view->render();
        } else {
            $view = new View($page);
            if (!empty($array)) {
                foreach ($array as $item => $value) {
                    $view->set($item, $value);
                }
            }
            $view->render();
        }
    }

    public function index() {
        $this->redirectIfLoged("site#index");
    }
    
    public function register() {
        $this->redirectIfLoged("site#register");
    }
    
    public function forgotPass() {
        $this->redirectIfLoged("site#forgotPass");
    }

    /**
     * @param $viewName
     * @param array $arraySet
     */
    public function redirectIfLoged($viewName, $arraySet = array()) {
        $this->checkMaintenance($viewName);
        $userClass = new User();
        $connected = User::isConnected();
        $message = new Message();
        $messages = $message->getMessages();
        if ($connected === true) {
            $view = new View("user#home");
            $user = $userClass->getUser();
            if ($user !== false) {
                foreach ($user as $name => $value) {
                    $view->set($name, $value);
                }
            }
            $view->set("error", $messages["error"]["mustNotBeConnected"]);
            $view->render();
        } else {
            $view = new View($viewName);
            if (!empty($arraySet)) {
                foreach ($arraySet as $name => $value) {
                    $view->set($name, $value);
                }
            }
            $view->render();
        }
    }
}