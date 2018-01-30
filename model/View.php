<?php
/**
 * View.php
 *
 * Link the controller and the view
 *
 * PHP 7.0.8
 *
 * @category Model
 * @author   isma91 <ismaydogmus@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace model;
/**
 * Class View
 * @package model
 */
class View
{
    /**
     * @var
     */
    protected $_file;
    /**
     * @var array
     */
    protected $_data = array();

    /**
     * View constructor.
     * @param $file
     */
    public function __construct($file)
    {
        $config = new Config();
        $message = new Message();
        $messages = $message->getMessages();
        if ($config->getMaintenance() === 'true') {
            $this->_data["maintenance"] = $messages["info"]["maintenance"];
        } else {
            $this->_data["maintenance"] = null;
        }
        $this->_file = $file;
    }

    /**
     * @param $key
     * @param $value
     */
    public function set($key, $value)
    {
        $this->_data[$key] = $value;
    }

    /**
     * @param $key
     * @return array|mixed
     */
    public function get($key)
    {
        return $this->_data[$key];
    }

    /**
     * @param $name
     * @return array|mixed
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->_data)) {
            return $this->_data[$name];
        }
    }

    /**
     * @return void
     */
    public function render()
    {
        $folderFile = explode('#', $this->_file);
        $arrayRequestUri = explode("/", ltrim($_SERVER["REQUEST_URI"], "/"));
        $pathCount = count($arrayRequestUri);
        if ($pathCount === 1 && count($folderFile) > 1) {
            $pathCount = 2;
        }
        $cssPath = "";
        if ($pathCount === 0) {
            $cssPath = "css" . "/";
        } elseif ($pathCount > 0) {
            for ($i = 0; $i < $pathCount; $i = $i + 1) {
                $cssPath = $cssPath . ".." . "/";
            }
            $cssPath = $cssPath . "media/css/";
        }
        $jsPath = "";
        if ($pathCount === 0) {
            $jsPath = "js" . "/";
        } elseif ($pathCount > 0) {
            for ($j = 0; $j < $pathCount; $j = $j + 1) {
                $jsPath = $jsPath . ".." . "/";
            }
            $jsPath = $jsPath . "media/js/";
        }
        $imgPath = "";
        if ($pathCount === 0) {
            $imgPath = "img" . "/";
        } elseif ($pathCount > 0) {
            for ($l = 0; $l < $pathCount; $l = $l + 1) {
                $imgPath = $imgPath . ".." . "/";
            }
            $imgPath = $imgPath . "media/img/";
        }
        $cssAssest = array(
            "materialize.min.css",
            "google_material_icons.css",
            "font.css",
            "style.css",
        );
        $jsAssest = array(
            "jquery-3.2.1.min.js",
            "materialize.min.js",
        );
        $file = rtrim(__DIR__, '/') . "/" . "../view/";
        for ($k = 0; $k < $pathCount; $k = $k + 1) {
            if ($k === $pathCount - 1) {
                if (!isset($folderFile[$k])) {
                    $file = substr($file, 0, -1) . ".php";
                } else {
                    $file = $file . $folderFile[$k] . ".php";
                }
            } else {
                if (!isset($folderFile[$k])) {
                    $file = $file . $folderFile[$k] . "";
                } else {
                    $file = $file . $folderFile[$k] . "/";
                }
            }
        }
        $jsFileName = "";
        foreach ($folderFile as $path) {
            $jsFileName = $jsFileName . "/" . $path;
        }
        $jsFileName = ltrim($jsFileName, "/") . ".js";
        $jsFileNamePath = rtrim(__DIR__, '/') . "/../media/js/" . $jsFileName;
        if (file_exists($jsFileNamePath)) {
            array_push($jsAssest, $jsFileName);
        }
        if (!file_exists($file)) {
            $view = new View("site#404");
            $view->render();
        }
        foreach ($cssAssest as $cssFile) {
            $this->_data["css"][] = '<link media="all" type="text/css" rel="stylesheet" href="' . $cssPath . $cssFile . '" />';
        }
        foreach ($jsAssest as $jsFile) {
            $this->_data["js"][] = '<script src="' . $jsPath . $jsFile . '"></script>';
        }
        extract($this->_data);
        ob_start();
        include($file);
        $output = ob_get_contents();
        ob_end_clean();
        echo $output;
    }
}
