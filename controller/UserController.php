<?php


require_once("ViewHelper.php");
require_once("forms/UserForm.php");
require_once("forms/CheckoutForm.php");
require_once("model/UserDB.php");
require_once("model/OrdersDB.php");
require_once("model/CartDB.php");



class UserController {
    
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

    public static function orders($params) {
        echo ViewHelper::render("view/user-order-list.php", [
            "orders" => OrdersDB::getUserOrders(['idUser' => $params['idUser']])
        ]);
    }

    public static function orderDetails($params) {
        try {
            echo ViewHelper::render("view/user-order-details.php", [
                "orderItems" => OrdersDB::getOrderItems($params)
            ]);
        }
        catch (Exception $e) {
            ViewHelper::redirect(BASE_URL . "user/orders");
        }
        
    }

    public static function cartAddItem($params) {
        // TODO: Add item to cart (increment)
        CartDB::cartAddItem($params);
        ViewHelper::redirect($params['previousUrl']);
    }

    public static function cartUpdateItem($params) {
        // TODO: Update cart
        CartDB::cartUpdateQuantity($params);
        ViewHelper::redirect($params['previousUrl']);
    }

    public static function cartPurge($idUser, $previousUrl) {
        var_dump($idUser);
        CartDB::cartPurge(['idUser' => $idUser]);
        ViewHelper::redirect($previousUrl);
    }

    public static function checkoutView($idUser) {
        $checkoutForm = new CheckoutForm("confirm_checkout_form",);
        echo ViewHelper::render("view/checkout.php", [
            "orderItems" => OrdersDB::getCartItems(['id' => $idUser]),
            "checkoutForm" => $checkoutForm
        ]);
    }

    public static function checkout($idUser) {
        CartDB::checkout(['idUser' => $idUser]);
        ViewHelper::redirect(BASE_URL . "user/orders");
    }

    
}
