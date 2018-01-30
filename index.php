<?php
/**
 * Index.php
 *
 * Display view with the Router model
 *
 * PHP 7.0.8
 *
 * @category Controller
 * @author   isma91 <ismaydogmus@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 */
session_start();
require 'autoload.php';
$router = new \routing\Router($_GET["url"]);
/*
 * Here are all the using routes
 */
$router->get("", "Site#index");
$router->get("/", "Site#index");
$router->get("/login", "Site#index");

$router->get("/register", "Site#register");

$router->get("/forgotPass", "Site#forgotPass");

$router->post("/register", "User#register");

$router->post("/login", "User#login");

$router->get("/home", "User#home");

$router->post("/logout", "User#logout");
/*$router->get("/admin/update/:type/:id", "User#displayThing");
$router->post("/admin/update/:type/:id", "User#updateThing");*/
/*
 * Run the routing System
 */
$router->run();