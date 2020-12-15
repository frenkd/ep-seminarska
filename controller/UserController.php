<?php


require_once("ViewHelper.php");
require_once("model/UserDB.php");
require_once("model/PostDB.php");
require_once("forms/UserForm.php");


class UserController {
    
    public static function login() {
        $form = new LoginForm("login_form");

        if ($form->validate()) {
            $user = UserDB::login($form->getValue());
            $_SESSION['email'] = $user['email'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['idUser'] = $user['id'];
            $_SESSION['role'] = $user['role'];
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
            UserDB::register($form->getValue());
            ViewHelper::redirect(BASE_URL . "login");
        } else {
            echo ViewHelper::render("view/register.php", [
                "form" => $form
            ]);
        }
    }

    public static function settings() {
        $formUser = new UserEditForm("settings_form_superuser");
        $formSuperuser = new SalesmanEditForm("settings_form_user");
        if ($formUser->isSubmitted()) {
            if ($formUser->validate()) {
                $id = UserDB::updateSettingsUser($formUser->getValue());
                ViewHelper::redirect(BASE_URL . "sneakers");
            }
            else {
                echo ViewHelper::render("view/settings.php", [
                    "form" => $formUser,
                ]);
            }
        }
        elseif ($formSuperuser->isSubmitted()) {
            if ($formSuperuser->validate()) {
                $id = UserDB::updateSettingsSuperuser($formSuperuser->getValue());
                ViewHelper::redirect(BASE_URL . "sneakers");
            }
            else {
                echo ViewHelper::render("view/settings.php", [
                    "form" => $formSuperuser,
                ]);
            }
        }
        elseif (isset($_SESSION['idUser']) && $_SESSION['role'] == 'Registred customer') {
            $userInfo = UserDB::get(['id' => $_SESSION['idUser']]);
            $dataSource = new HTML_QuickForm2_DataSource_Array($userInfo);
            $formUser->addDataSource($dataSource);
            echo ViewHelper::render("view/settings.php", [
                "form" => $formUser
            ]);
        }
        elseif (isset($_SESSION['idUser']) && $_SESSION['role'] == 'Salesman') {
            $userInfo = UserDB::get(['id' => $_SESSION['idUser']]);
            $dataSource = new HTML_QuickForm2_DataSource_Array($userInfo);
            $formSuperuser->addDataSource($dataSource);
            echo ViewHelper::render("view/settings.php", [
                "form" => $formSuperuser
            ]);
        }
        elseif (isset($_SESSION['idUser']) && $_SESSION['role'] == 'Administrator') {
            $userInfo = UserDB::get(['id' => $_SESSION['idUser']]);
            $dataSource = new HTML_QuickForm2_DataSource_Array($userInfo);
            $formSuperuser->addDataSource($dataSource);
            echo ViewHelper::render("view/settings.php", [
                "form" => $formSuperuser
            ]);
        }
    }

}
