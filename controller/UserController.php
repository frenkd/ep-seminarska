<?php


require_once("ViewHelper.php");
require_once("forms/UserForm.php");
require_once("model/UserDB.php");
require_once("model/OrdersDB.php");
require_once("model/CartDB.php");



class UserController {
    
    public static function login() {
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
                echo ViewHelper::render("view/login.php", [
                    "form" => $form
                ]);
            }
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

    public static function orders() {
        echo ViewHelper::render("view/user-order-list.php", [
            "orders" => OrdersDB::getUserOrders(['idUser' => $_SESSION['idUser']])
        ]);
    }

    public static function orderDetails($id) {
        echo ViewHelper::render("view/user-order-details.php", [
            "orderItems" => OrdersDB::getOrderItems(['id' => $id])
        ]);
    }

    public static function cartAddItem($params) {
        CartDB::cartAddItem($params);
    }

    public static function cartPurge() {
        $user = ['idUser' => $_SESSION['idUser']];
        CartDB::cartPurge($user);
    }

    public static function checkout() {
        $user = ['idUser' => $_SESSION['idUser']];
        CartDB::checkout($user);
    }

}
