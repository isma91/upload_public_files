<?php
namespace model;
/**
 * Class File
 * @package model
 */
class File
{
    private $_uploadPath;

    public function __construct() {
        $this->_uploadPath = __DIR__ . "/../upload/";
    }

    public function getFolderFromUser() {
        $userClass = new User();
        $connected = User::isConnected();
        if (!$connected) {
            return false;
        }
        $user = $userClass->getUser();
        $username = $user["username"];
        if(!file_exists($this->_uploadPath . $username)) {
            return false;
        }
        /*ini_set('xdebug.var_display_max_depth', -1);
        ini_set('xdebug.var_display_max_children', -1);
        ini_set('xdebug.var_display_max_data', -1);*/
        $usersFolder = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($this->_uploadPath . $username));
        $folders = array();
        foreach($usersFolder as $folder) {
            if($folder->isDir() && $folder->getFilename() !== "..") {
                array_push($folders, $folder->getRealPath());
            }
        }
        var_dump($folders);
        echo 'end'; die();
    }
}