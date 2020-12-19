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
        // session_regenerate_id();
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

}