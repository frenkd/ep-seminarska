<?php


require_once("ViewHelper.php");
require_once("model/ProductDB.php");
require_once("forms/ProductForm.php");

class AnonController {
    
    public static function displayAllActive() {
        echo ViewHelper::render("view/product-gallery.php", [
            "sneakers" => ProductDB::getAllActive()
        ]);
    }

    public static function productDetail($id) {
        echo ViewHelper::render("view/product-details.php", ProductDB::get(["id" => $id]));
    }

    public static function loginForm($title) {
        $form = new LoginForm("login_form");

        if ($form->validate()) {

            try {
                $user = UserDB::login($form->getValue());
                $_SESSION['email'] = $user['email'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['idUser'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                // echo '<script>alert("' . $user['name'] . '")</script>';
                ViewHelper::redirect(BASE_URL . "sneakers/" . $id);
            } catch (Exception $e) {
                echo '<script>alert("' . $e->getMessage() . '")</script>';
                echo ViewHelper::render("view/login-form.php", [
                    "form" => $form,
                    "title" => $title
                ]);
            }
        } else {
            echo ViewHelper::render("view/login-form.php", [
                "form" => $form,
                "title" => $title
            ]);
        }
    }

    public static function login() {
        echo ViewHelper::render("view/login.php");
    }

    public static function loginAdmin() {
        session_regenerate_id();

        $form = new LoginForm("login_form");
        if ($form->validate()) {
            try {
                $user = UserDB::login($form->getValue());
                if ($_SERVER["SSL_CLIENT_S_DN_Email"] == $user['email'] && $user['role'] == 'Administrator') {
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['name'] = $user['name'];
                    $_SESSION['idUser'] = $user['id'];
                    $_SESSION['role'] = $user['role'];
                    ViewHelper::redirect(BASE_URL . "sneakers/" . $id);
                }
                else {
                    throw new Exception('Certificate and login info do not match.');
                }
            } catch (Exception $e) {
                echo '<script>alert("' . $e->getMessage() . '")</script>';
                echo ViewHelper::render("view/login-form.php", [
                    "form" => $form,
                    "title" => "Admin login"
                ]);
            }
        } else {
            echo ViewHelper::render("view/login-form.php", [
                "form" => $form,
                "title" => "Admin login"
            ]);
        }
    }

    public static function loginSales() {
        session_regenerate_id();

        $form = new LoginForm("login_form");
        if ($form->validate()) {
            try {
                $user = UserDB::login($form->getValue());
                if ($_SERVER["SSL_CLIENT_S_DN_Email"] == $user['email'] && $user['role'] == 'Salesman') {
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['name'] = $user['name'];
                    $_SESSION['idUser'] = $user['id'];
                    $_SESSION['role'] = $user['role'];
                    ViewHelper::redirect(BASE_URL . "sneakers/" . $id);
                }
                else {
                    throw new Exception('Certificate and login info do not match.');
                }
            } catch (Exception $e) {
                echo '<script>alert("' . $e->getMessage() . '")</script>';
                echo ViewHelper::render("view/login-form.php", [
                    "form" => $form,
                    "title" => "Salesman login"
                ]);
            }
        } else {
            echo ViewHelper::render("view/login-form.php", [
                "form" => $form,
                "title" => "Salesman login"
            ]);
        }
    }

    public static function loginUser() {
        session_regenerate_id();
        self::loginForm("User login");
    }

    public static function register() {
        $form = new RegisterForm("register_form");

        if ($form->validate()) {
            UserDB::register($form->getValue());
            ViewHelper::redirect(BASE_URL . "login");
        } else {
            echo ViewHelper::render("view/register.php", [
                "form" => $form
            ]);
        }
    }

}
