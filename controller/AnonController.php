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
            $_SESSION['formValues'] = $form->getValue();
            self::registerCaptcha();
        } else {
            echo ViewHelper::render("view/register.php", [
                "form" => $form
            ]);
        }
    }

    public static function registerCaptcha() {
        echo ViewHelper::render("view/register.php", [
            "captcha" => TRUE
        ]);
    }

    public static function registerConfirm($params) {
        require 'secret_keys.php';
        require 'model/Mail.php';

        if($params['captcha']){
            $captcha = $params['captcha'];
            $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretEPseminarska['secretCAPTCHA']."&response={$captcha}&remoteip=".$_SERVER['REMOTE_ADDR']);
            $g_response = json_decode($response);
            if ($g_response->success === true) {
                try {
                    UserDB::register($_SESSION['formValues']);
                    $confirmHash = hash('ripemd160', $_SESSION['formValues']['email'].$secretEPseminarska['confirmationSecret']);
                    $mailLink = 'localhost'.BASE_URL.'register/complete?mail='.$_SESSION['formValues']['email'].'&hash='.$confirmHash;
                    $mailParams = [
                        'mailAddress' => $_SESSION['formValues']['email'],
                        'mailName' => $_SESSION['formValues']['name'].' '.$_SESSION['formValues']['surname'],
                        'mailLink' => $mailLink
                    ];
                    ViewHelper::render("view/pager.php", [
                        "title" => "Registration instructions",
                        "content" => "Confirmation mail has been sent. Click the link in your email to continue."
                    ]);
                    sendConfirmationMail($mailParams);
                } catch (Exception $e) {
                    echo ViewHelper::render("view/pager.php", [
                        "title" => "Error",
                        "content" => $e->getMessage()
                    ]);
                }
            } else {
                ViewHelper::redirect(BASE_URL);
            }
        }
    }

    public static function registerComplete($params) {
        require 'secret_keys.php';

        //check if the inputed hash matches the one in the database
        $confirmTruth = hash('ripemd160', $params['mail'].$secretEPseminarska['confirmationSecret']);
        $confirmHashInput = $params['hash'];
        if ($confirmTruth == $confirmHashInput) {
            echo ViewHelper::render("view/pager.php", [
                "title" => "Registration completed",
                "content" => "You have been sucessfuly registred!"
            ]);
            UserDB::activateUser(['email' => $params['mail']]);
        }
        else {
            echo ViewHelper::render("view/pager.php", [
                "title" => "Registration error",
                "content" => "Could not confirm user."
            ]);
        }
    }


}
