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
        $uploadUsernamePath = realpath($this->_uploadPath . $username);
        if(!file_exists($uploadUsernamePath)) {
            return false;
        }
        $usersFolder = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($uploadUsernamePath));
        $folders = array();
        foreach($usersFolder as $folder) {
            if($folder->isDir() && $folder->getFilename() !== "..") {
                array_push($folders, $folder->getRealPath());
            }
        }
        foreach($folders as &$folder) {
            $folder = substr($folder, strlen($uploadUsernamePath) + 1);
            if (!$folder) {
                $folder = "/";
            }
        }
        return array("uploadUsernamePath" => $uploadUsernamePath, "folders" => $folders);
    }
}