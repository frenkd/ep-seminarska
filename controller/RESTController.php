<?php

require_once("model/ProductDB.php");
require_once("ViewHelper.php");

class RESTController {

    public static function get($id) {
        try {
            echo ViewHelper::renderJSON(ProductDB::get(["id" => $id]));
        } catch (InvalidArgumentException $e) {
            echo ViewHelper::renderJSON($e->getMessage(), 404);
        }
    }

    public static function index() {
        $prefix = $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"]
                . $_SERVER["REQUEST_URI"] . "/";
        echo ViewHelper::renderJSON(ProductDB::getAllwithURI(["prefix" => $prefix]));
    }

    public static function login(array $params) {
        session_regenerate_id();
        try {
            $user = UserDB::login($params);
            $_SESSION['email'] = $user['email'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['idUser'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $responseData = [
                'id' => $user['id'],
                'email' => $user['email'],
                'name' => $user['name'],
                'surname' => $user['surname'],
                'sessionToken' => session_id()
            ];
            echo ViewHelper::renderJSON($responseData);
        } catch (InvalidArgumentException $e) {
            echo ViewHelper::renderJSON("Wrong password", '401');
        } catch (DomainException $e) {
            echo ViewHelper::renderJSON("No such user", '404');
        } catch (\Throwable $e) {
            echo ViewHelper::renderJSON("Unknown error", '500');
        }
        
    }

    public static function getUser($idUser) {
        try {
            echo ViewHelper::renderJSON(UserDB::get(["id" => $idUser]));
        } catch (InvalidArgumentException $e) {
            echo ViewHelper::renderJSON($e->getMessage(), 404);
        }
    }

    public static function editUser() {
        try {
            $formValues = [
                'id' => $_SESSION['idUser'],
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'name' => $_POST['name'],
                'surname' => $_POST['surname'],
                'street' => $_POST['street'],
                'idPost' => $_POST['idPost'],
                'idAddress' => $_POST['idAddress'],
                'active' => '1',
            ];
            UserDB::update($formValues);
            echo ViewHelper::renderJSON("Success!", '201');
        } catch (\Throwable $e) {
            echo ViewHelper::renderJSON($e->getMessage(), 400);
        }
    }

    public static function addToCart() {
        try {
            $formValues = [
                'idUser' => $_SESSION['idUser'],
                'idProduct' => $_POST['idProduct'],
            ];
            CartDB::cartAddItem($formValues);
            echo ViewHelper::renderJSON("Success!", '201');
        } catch (\Throwable $e) {
            echo ViewHelper::renderJSON($e->getMessage(), 400);
        }
    }

    public static function getCart() {
        try {
            $formValues = [
                'idUser' => $_POST['idUser'],
            ];
            echo ViewHelper::renderJSON(CartDB::getUserCartItems($formValues));
        } catch (\Throwable $e) {
            echo ViewHelper::renderJSON($e->getMessage(), 400);
        }
        
    }

    public static function purgeCart() {
        try {
            $formValues = [
                'idUser' => $_POST['idUser'],
            ];
            echo ViewHelper::renderJSON(CartDB::cartPurge($formValues));
        } catch (\Throwable $e) {
            echo ViewHelper::renderJSON($e->getMessage(), 400);
        }
        
    }

    public static function completePurchase() {
        try {
            $formValues = [
                'idUser' => $_POST['idUser'],
            ];
            CartDB::checkout($formValues);
            echo ViewHelper::renderJSON("Success!", '201');
        } catch (\Throwable $e) {
            var_dump($_SESSION);
            echo ViewHelper::renderJSON($e->getMessage(), 400);
        }
        
    }

    public static function updatePlus() {
        try {
            $formValues = [
                'idUser' => $_POST['idUser'],
                'idProduct' => $_POST['idProduct'],
            ];
            CartDB::cartAddItem($formValues);
            echo ViewHelper::renderJSON("Success!", '201');
        } catch (\Throwable $e) {
            echo ViewHelper::renderJSON($e->getMessage(), 400);
        }
    }

    public static function updateMinus() {
        try {
            $formValues = [
                'idUser' => $_POST['idUser'],
                'idProduct' => $_POST['idProduct'],
            ];
            CartDB::cartSubtractItem($formValues);
            echo ViewHelper::renderJSON("Success!", '201');
        } catch (\Throwable $e) {
            echo ViewHelper::renderJSON($e->getMessage(), 400);
        }
    }

    public static function assertValues($input) {
        if (checkValues == FALSE) {
            throw Exception("Incorrect characters in input");
        }
    }

    public static function checkValues($input) {
        if (empty($input)) {
            return FALSE;
        }

        $result = TRUE;
        foreach ($input as $value) {
            $result = $result && $value != false;
        }

        return $result;
    }

    public static function getRules() {
        return [
            'name' => FILTER_SANITIZE_SPECIAL_CHARS,
            'surname' => FILTER_SANITIZE_SPECIAL_CHARS,
            'password' => FILTER_SANITIZE_SPECIAL_CHARS,
            'email' => FILTER_SANITIZE_EMAIL,
            'id' => FILTER_SANITIZE_NUMBER_INT,
            'idPost' => FILTER_SANITIZE_NUMBER_INT,
            'idAddress' => FILTER_SANITIZE_NUMBER_INT,
            'idUser' => FILTER_SANITIZE_NUMBER_INT,
            'idProduct' => FILTER_SANITIZE_NUMBER_INT,
            'size' => FILTER_SANITIZE_NUMBER_INT,
            'price' => FILTER_VALIDATE_FLOAT,
        ];
    }

}