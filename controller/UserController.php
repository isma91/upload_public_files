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
    public function register() {
        $errField = array();
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $password2 = $_POST["password2"];
        $allField = [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'password2' => $password2
        ];
        foreach($allField as $filed => $value) {
            if (empty(trim($value))) {
                array_push($errField, $value);
            }
        }
        $user = new User();
        $duplicateEmail = $user->checkDuplicateEmail($email);
        $duplicateUsername = $user->checkDuplicateUsername($username);
        $view = new View("site#register");
        $message = new Message();
        $messages = $message->getMessages();
        if (count($errField) > 0) {
            $fields = "";
            foreach($errField as $key => $value) {
                $fields = $fields . ", " . $value;
            }
            $fields = substr($fields, 2);
            $view->set("error", sprintf($messages["error"]["emptyField"], $fields));
            $view->render();
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $view->set("error", $messages["error"]["emailNotValid"]);
            $view->render();
        } elseif (strlen($password) <= 3 || strlen($password2) <= 3) {
            $view->set("error", $messages["error"]["passwordNotLong"]);
            $view->render();
        } elseif ($password !== $password2) {
            $view->set("error", $messages["error"]["passwordNotSame"]);
            $view->render();
        } elseif (strlen($username) <= 3) {
            $view->set("error", $messages["error"]["usernameNotLong"]);
            $view->render();
        } elseif ($duplicateEmail) {
            foreach ($allField as $field => $value) {
                $view->set($field, $value);
            }
            $view->set("error", $messages["error"]["duplicateEmail"]);
            $view->render();
        } elseif ($duplicateUsername) {
            foreach ($allField as $field => $value) {
                $view->set($field, $value);
            }
            $view->set("error", $messages["error"]["duplicateUsername"]);
            $view->render();
        } else {
            $add = $user->add($firstname, $lastname, $username, $email, $password);
            if ($add) {
                $view->set("success", $messages["success"]["register"]);
            } else {
                foreach ($allField as $field => $value) {
                    $view->set($field, $value);
                }
                $view->set("error", sprintf($messages["error"]["somethingGotWrong"], "register you"));
            }
            $view->render();
        }
    }

}
