<?php
namespace controller;
/**
 * UserController.php
 *
 *
 * PHP 7.0.8
 *
 * @category Model
 * @package  Model
 * @author   isma91 <ismaydogmus@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 */
use model\Bdd;
use model\Config;
use model\Message;
use model\User;
use model\View;
/**
 * Class UserController
 * @package controller
 */
class UserController
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

    /**
     *
     */
    public function add() {
    }

}
