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
        $user = $bdd->select("user", $arrayField, $where);
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
        $user = $bdd->select("user", $arrayField, $where);
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
        $add = $bdd->insert("user", $arrayField);
        return $add;
    }

    public function userCredential($usernameEmail, $password) {
        $bdd = new Bdd();
        $arrayField = array("id", "password", "token");
        $where = "username = '" . $usernameEmail . "' OR email = '" . $usernameEmail . "'";
        $user = $bdd->select("user", $arrayField, $where);
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

}