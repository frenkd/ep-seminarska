<?php

// enables sessions for the entire app
session_start();

require_once("controller/SneakersController.php");
require_once("controller/UserController.php");
require_once("controller/SalesController.php");
require_once("controller/AdminController.php");
require_once("controller/BooksRESTController.php");

define("BASE_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php"));
define("IMAGES_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/images/");
define("CSS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/css/");

$path = isset($_SERVER["PATH_INFO"]) ? trim($_SERVER["PATH_INFO"], "/") : "";

$urlsAnon = [
    "/^$/" => function () {
        // Redirects to default url: /sneakers
        ViewHelper::redirect(BASE_URL . "sneakers");
    },
    "/^sneakers$/" => function ($method) {
        SneakersController::index();
    },
    "/^login$/" => function ($method) {
        UserController::login();
    },
    "/^register$/" => function ($method) {
        UserController::register();
    },
];

$urlsUser = [
    "/^settings$/" => function ($method) {
        UserController::settings();
    },
    "/^logout$/" => function ($method) {
        session_destroy();
        ViewHelper::redirect(BASE_URL . "sneakers");
    },
];

$urlsSales = [
    "/^sales$/" => function ($method) {
        SalesController::dashboard();
    },
    "/^sales\/users$/" => function ($method) {
        SalesController::users();
    },
    "/^sales\/orders$/" => function ($method) {
        SalesController::orders();
    },
    "/^sales\/sneakers\/(\d+)$/" => function ($method, $id) {
        SneakersController::get($id);
    },
    "/^sales\/sneakers\/add$/" => function ($method) {
        SneakersController::add();
    },
    "/^sales\/sneakers\/edit\/(\d+)$/" => function ($method, $id) {
        SneakersController::edit(array('id' => $id));
    },
    "/^sales\/sneakers\/delete$/" => function ($method) {
        SneakersController::delete();
    },
];

$urlsAdmin = [
    "/^admin$/" => function ($method) {
        AdminController::dashboard();
    },
    "/^admin\/salesmen$/" => function ($method) {
        AdminController::salesmen();
    },
    "/^admin\/salesmen\/add$/" => function ($method) {
        AdminController::salesmenAdd();
    },
    "/^admin\/salesmen\/edit\/(\d+)$/" => function ($method) {
        AdminController::salesmenEdit();
    },
    "/^sales\/salesmen\/delete$/" => function ($method) {
        AdminController::salesmenDelete();
    },
];

$urlsREST = [
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
    }
];

$urls = array_merge($urlsAnon, $urlsUser, $urlsSales, $urlsAdmin, $urlsREST);

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
