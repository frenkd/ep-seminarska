<?php

// enables sessions for the entire app
session_start();

require_once("controller/ProductController.php");
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
        ProductController::displayAllActive();
    },
    "/^sneakers\/(\d+)$/" => function ($method, $id) {
        ProductController::productDetail($id);
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
    "/^sales\/products$/" => function ($method) {
        ProductController::displayAllSales();
    },
    "/^sales\/products\/(\d+)$/" => function ($method, $id) {
        ProductController::productDetail($id);
    },
    "/^sales\/products\/add$/" => function ($method) {
        ProductController::productAdd();
    },
    "/^sales\/products\/edit\/(\d+)$/" => function ($method, $id) {
        ProductController::productEdit(array('id' => $id));
    },
    "/^sales\/products\/delete$/" => function ($method) {
        ProductController::productDelete();
    },
    "/^sales\/orders$/" => function ($method) {
        SalesController::orders();
    },
    "/^sales\/users$/" => function ($method) {
        SalesController::users();
    },
    "/^admin\/salesmen\/add$/" => function ($method) {
        SalesController::userAdd();
    },
    "/^admin\/salesmen\/edit\/(\d+)$/" => function ($method) {
        SalesController::userEdit();
    },
    "/^sales\/salesmen\/delete$/" => function ($method) {
        SalesController::userDelete();
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
