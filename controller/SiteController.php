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
        $this->checkMaintenance("site#index");
    }
    
    public function register() {
        $this->checkMaintenance("site#register");
    }
    
    public function forgotPass() {
        $this->checkMaintenance("site#forgotPass");
    }
}