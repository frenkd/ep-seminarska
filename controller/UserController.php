<?php


require_once("ViewHelper.php");
require_once("model/UserDB.php");
require_once("model/PostDB.php");
require_once("forms/LoginForm.php");
require_once("forms/RegisterForm.php");


class UserController {
    
    public static function login() {
        $form = new LoginForm("login_form");

        if ($form->validate()) {
            $id = UserDB::insert($form->getValue());
            ViewHelper::redirect(BASE_URL . "sneakers/" . $id);
        } else {
            echo ViewHelper::render("view/login.php", [
                "form" => $form
            ]);
        }
    }

    public static function register() {
        $form = new RegisterForm("register_form");

        if ($form->validate()) {
            $id = UserDB::insert($form->getValue());
            ViewHelper::redirect(BASE_URL . "sneakers/" . $id);
        } else {
            echo ViewHelper::render("view/register.php", [
                "form" => $form
            ]);
        }
    }

}
