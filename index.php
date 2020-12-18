<?php

// enables sessions for the entire app
session_start();

require_once("controller/AnonController.php");
require_once("controller/UserController.php");
require_once("controller/SalesController.php");
require_once("controller/AdminController.php");

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
        AnonController::displayAllActive();
    },
    "/^sneakers\/(\d+)$/" => function ($method, $id) {
        AnonController::productDetail($id);
    },
    "/^login$/" => function ($method) {
        AnonController::login();
    },
    "/^admin\/login$/" => function ($method) {
        AnonController::loginAdmin();
    },
    "/^sales\/login$/" => function ($method) {
        AnonController::loginSales();
    },
    "/^user\/login$/" => function ($method) {
        AnonController::loginUser();
    },
    "/^register$/" => function ($method) {
        AnonController::register();
    },
    "/^register\/confirm$/" => function ($method) {
        $params = [
            'captcha' => $_POST['g-recaptcha-response']
        ];
        AnonController::registerConfirm($params);
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
    "/^user\/orders$/" => function ($method) {
        $params = [
            'idUser' => $_SESSION['idUser']
        ];
        UserController::orders($params);
    },
    "/^user\/order\/(\d+)$/" => function ($method, $id) {
        $params = [
            'idOrder' => $id,
            'idUser' => $_SESSION['idUser']
        ];
        UserController::orderDetails($params);
    },
    "/^user\/cartPurge$/" => function ($method) {
        $previousUrl = $_POST['previousUrl'];
        $idUser = $_SESSION['idUser'];
        UserController::cartPurge($idUser, $previousUrl);
    },
    "/^user\/cart\/add$/" => function ($method) {
        $params = [
            'idProduct' => $_POST['idProduct'],
            'previousUrl' => $_POST['previousUrl'],
            'idUser' => $_SESSION['idUser']
        ];
        UserController::cartAddItem($params);
    },
    "/^user\/cart\/update$/" => function ($method) {
        $params = [
            'idProduct' => $_POST['idProduct'],
            'quantity' => $_POST['quantity'],
            'previousUrl' => $_POST['previousUrl'],
            'idUser' => $_SESSION['idUser']
        ];
        UserController::cartUpdateItem($params);
    },
    "/^user\/checkout$/" => function ($method) {
        $idUser = $_SESSION['idUser'];
        UserController::checkoutView($idUser);
    },
    "/^user\/checkout\/confirm$/" => function ($method) {
        $idUser = $_SESSION['idUser'];
        UserController::checkout($idUser);
    }
];

$urlsSales = [
    "/^sales$/" => function ($method) {
        SalesController::dashboard();
    },
    "/^sales\/products$/" => function ($method) {
        SalesController::products();
    },
    "/^sales\/product\/(\d+)$/" => function ($method, $id) {
        SalesController::productDetail($id);
    },
    "/^sales\/product\/add$/" => function ($method) {
        SalesController::productAdd();
    },
    "/^sales\/product\/edit\/(\d+)$/" => function ($method, $id) {
        SalesController::productEdit(array('id' => $id));
    },
    "/^sales\/product\/delete$/" => function ($method) {
        SalesController::productDelete(['id' => $_POST['id']]);
    },
    "/^sales\/orders$/" => function ($method) {
        SalesController::orders();
    },
    "/^sales\/order\/(\d+)$/" => function ($method, $id) {
        $params = [
            'idOrder' => $id,
            'idUser' => $_POST['idUser']
        ];
        SalesController::orderDetails($params);
    },
    "/^sales\/order\/confirm$/" => function ($method) {
        SalesController::updateOrderStatus(['idOrder' => $_POST['idOrder'], 'idStatus' => '2']);
    },
    "/^sales\/order\/cancel$/" => function ($method) {
        SalesController::updateOrderStatus(['idOrder' => $_POST['idOrder'], 'idStatus' => '3']);
    },
    "/^sales\/order\/revoke$/" => function ($method) {
        SalesController::updateOrderStatus(['idOrder' => $_POST['idOrder'], 'idStatus' => '4']);
    },
    "/^sales\/users$/" => function ($method) {
        SalesController::users();
    },
    "/^sales\/user\/add$/" => function ($method) {
        SalesController::userAdd();
    },
    "/^sales\/user\/edit\/(\d+)$/" => function ($method, $id) {
        SalesController::userEdit($id);
    },
    "/^sales\/user\/delete$/" => function ($method) {
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
    "/^admin\/salesman\/add$/" => function ($method) {
        AdminController::salesmanAdd();
    },
    "/^admin\/salesman\/edit\/(\d+)$/" => function ($method, $id) {
        AdminController::salesmanEdit($id);
    },
    "/^admin\/salesman\/delete$/" => function ($method) {
        AdminController::salesmanDelete();
    },
];

$urls = array_merge($urlsAnon, $urlsUser, $urlsSales, $urlsAdmin);

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