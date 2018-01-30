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
use model\File;
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
                $oldUmask = umask(0);
                mkdir(__DIR__ . "/../upload/" . $username, 0777);
                umask($oldUmask);
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

    public function login () {
        $errField = array();
        $username = $_POST['username'];
        $password = $_POST["password"];
        $allField = [
            'username' => $username,
            'password' => $password
        ];
        foreach($allField as $filed => $value) {
            if (empty(trim($value))) {
                array_push($errField, $value);
            }
        }
        $user = new User();
        $view = new View("site#index");
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
        } elseif (strlen($password) <= 3) {
            $view->set("error", $messages["error"]["passwordNotLong"]);
            $view->render();
        } elseif (strlen($username) <= 3) {
            $view->set("error", $messages["error"]["usernameNotLong"]);
            $view->render();
        } else {
            $checkUserCredential = $user->userCredential($username, $password);
            if ($checkUserCredential) {
                $this->home();
            } else {
                foreach ($allField as $field => $value) {
                    $view->set($field, $value);
                }
                $view->set("error", $messages["error"]["userCredential"]);
                $view->render();
            }
        }
    }

    public function home() {
        $file = new File();
        $usernameFolders = $file->getFolderFromUser();
        $this->redirectIfNotLoged("user#home");
    }

    /**
     * @param $viewName
     * @param array $arraySet
     */
    public function redirectIfNotLoged($viewName, $arraySet = array(), $getUser = true) {
        $this->checkMaintenance($viewName);
        $userClass = new User();
        $connected = User::isConnected();
        $message = new Message();
        $messages = $message->getMessages();
        if ($connected === true) {
            $view = new View($viewName);
            if (!empty($arraySet)) {
                foreach ($arraySet as $name => $value) {
                    $view->set($name, $value);
                }
            }
            if ($getUser === true) {
                $user = $userClass->getUser();
                if ($user !== false) {
                    foreach ($user as $name => $value) {
                        $view->set($name, $value);
                    }
                }
            }
            $view->render();
        } else {
            $view = new View("site#index");
            $view->set("error", $messages["error"]["mustBeConnected"]);
            $view->render();
        }
    }

    public function logout() {
        $token = $_POST["token"];
        $user = new User();
        $message = new Message();
        $messages = $message->getMessages();
        $logout = $user->logout($token);
        if ($logout) {
            $view = new View("site#index");
            $view->set("success", $messages["success"]["logout"]);
            $view->render();
        } else {
            $view = new View("user#home");
            $view->set("error", sprintf($messages["error"]["somethingGotWrong"], "logout"));
            $view->render();
        }
    }

}
