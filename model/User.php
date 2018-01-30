<?php
/**
* User.php
*
 * Model of the User
*
 * PHP 7.0.8
*
 * @category Model
* @author   isma91 <ismaydogmus@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace model;
class User
{
    public function checkDuplicateEmail($email) {
        $bdd = new Bdd();
        $arrayField = array("email");
        $where = "email = '" . $email ."'";
        $user = $bdd->select("users", $arrayField, $where);
        if (!empty($user)) {
            return true;
        } else {
            return false;
        }
    }
    
    public function checkDuplicateUsername($username) {
        $bdd = new Bdd();
        $arrayField = array("username");
        $where = "username = '" . $username ."'";
        $user = $bdd->select("users", $arrayField, $where);
        if (!empty($user)) {
            return true;
        } else {
            return false;
        }
    }

    public function add($firstname, $lastname, $username, $email, $password) {
        $bdd = new Bdd();
        $pass = password_hash($password, PASSWORD_DEFAULT);
        $arrayField = array("firstname" => $firstname, "lastname" => $lastname, "username" => $username, "email" => $email, "password" => $pass);
        $add = $bdd->insert("users", $arrayField);
        return $add;
    }

    public function userCredential($username, $password) {
        $bdd = new Bdd();
        $arrayField = array("id", "password", "token");
        $where = "username = '" . $username . "'";
        $user = $bdd->select("users", $arrayField, $where);
        if (!empty($user)) {
            if (password_verify($password, $user[0]["password"])) {
                $this->_updateToken($user[0]["id"]);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    private function _updateToken($id) {
        $bdd = new Bdd();
        $token = sha1(time() * rand(1, 555));
        $arrayField = array("token" => $token);
        $where = "id = $id";
        $updateToken = $bdd->update("users", $arrayField, $where);
        if ($updateToken) {
            $_SESSION['token'] = $token;
            $_SESSION['id'] = $id;
            return true;
        } else {
            return false;
        }
    }

    static public function isConnected () {
        $bdd = new Bdd();
        if (!isset($_SESSION['id']) && !isset($_SESSION['token'])) {
            return false;
        }
        $arrayField = array("id", "token", "username");
        $where = "id = " . $_SESSION["id"] . " AND token = '" . $_SESSION["token"] . "'";
        $user = $bdd->select("users", $arrayField, $where);
        if ($user) {
            return true;
        } else {
            return false;
        }
    }

    private function _checkToken ($token) {
        $bdd = new Bdd();
        $arrayField = array("token");
        $where = "id = " . $_SESSION["id"];
        $checkToken = $bdd->select("users", $arrayField, $where);
        if ($token === $checkToken[0]["token"]) {
            return true;
        } else {
            return false;
        }
    }

    public function getUser() {
        $bdd = new Bdd();
        $arrayField = array("lastname", "firstname", "username", "email");
        $where = "id = " . $_SESSION["id"];
        $user = $bdd->select("users", $arrayField, $where);
        return $user[0];
    }

    public function logout($token) {
        if ($this->_checkToken($token)) {
            session_destroy();
            return true;
        } else {
            return false;
        }
    }
}