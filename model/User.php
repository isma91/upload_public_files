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
    
}