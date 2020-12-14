<?php

// enables sessions for the entire app
session_start();

require_once("controller/SneakersController.php");
require_once("controller/BooksRESTController.php");

define("BASE_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php"));
define("IMAGES_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/images/");
define("CSS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/css/");

$path = isset($_SERVER["PATH_INFO"]) ? trim($_SERVER["PATH_INFO"], "/") : "";

$urls = [
    "/^sneakers$/" => function ($method) {
        SneakersController::index();
    },
    "/^sneakers\/(\d+)$/" => function ($method, $id) {
        SneakersController::get($id);
    },
    "/^sneakers\/add$/" => function ($method) {
        SneakersController::add();
    },
    "/^sneakers\/edit\/(\d+)$/" => function ($method, $id) {
        SneakersController::edit(array('id' => $id));
    },
    "/^sneakers\/delete$/" => function () {
        SneakersController::delete();
    },
    "/^sneakers\/(\d+)\/(foo|bar|baz)\/(\d+)$/" => function ($method, $id, $val, $num) {
        // primer kako definirati funkcijo, ki vzame dodatne parametre
        // http://localhost/netbeans/mvc-rest/books/1/foo/10
        echo "$id, $val, $num";
    },
    "/^$/" => function () {
        // Redirects to default url: /sneakers
        ViewHelper::redirect(BASE_URL . "sneakers");
    },
    # REST API
    "/^api\/books\/(\d+)$/" => function ($method, $id) {
        // TODO: izbris knjige z uporabo HTTP metode DELETE
        switch ($method) {
            case "PUT":
                BooksRESTController::edit($id);
                break;
            default: # GET
                BooksRESTController::get($id);
                break;
        }
    },
    "/^api\/books$/" => function ($method) {
        switch ($method) {
            case "POST":
                BooksRESTController::add();
                break;
            default: # GET
                BooksRESTController::index();
                break;
        }
    },
];

foreach ($urls as $pattern => $controller) {
    if (preg_match($pattern, $path, $params)) {
        try {
            $params[0] = $_SERVER["REQUEST_METHOD"];
            $controller(...$params);
        } catch (InvalidArgumentException $e) {
            ViewHelper::error404();
        } catch (Exception $e) {
            ViewHelper::displayError($e, true);
        }

        exit();
    }
}

ViewHelper::displayError(new InvalidArgumentException("No controller matched."), true);
