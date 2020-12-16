<?php


require_once("ViewHelper.php");
require_once("model/UserDB.php");
require_once("model/OrdersDB.php");
require_once("forms/UserForm.php");

class SalesController {
    
    public static function users() {
        echo ViewHelper::render("view/user-list.php", [
            "users" => UserDB::getAllInfo()
        ]);
    }

    public static function orders() {
        echo ViewHelper::render("view/sales-order-list.php", [
            "orders" => OrdersDB::getAllInfo()
        ]);
    }
    
    public static function userAdd() {
        $form = new RegisterForm("register_form");

        if ($form->validate()) {
            UserDB::register($form->getValue());
            ViewHelper::redirect(BASE_URL . "sales/users");
        } else {
            echo ViewHelper::render("view/register.php", [
                "form" => $form
            ]);
        }
    }

    public static function userEdit($id) {
        //var_dump($id);
        $editForm = new UserEditFormSales("edit_user_form");
        $deleteForm = new UserDeleteForm("delete_user_form");

        if ($editForm->isSubmitted()) {
            if ($editForm->validate()) {
                $data = $editForm->getValue();
                UserDB::update($data);
                ViewHelper::redirect(BASE_URL . "sales/users");
            } else {
                echo ViewHelper::render("view/user-edit.php", [
                    "form" => $editForm,
                    "deleteForm" => $deleteForm
                ]);
            }
        } else {
            if ($id) {
                $product = UserDB::get(['id' => $id]);
                $dataSource = new HTML_QuickForm2_DataSource_Array($product);
                $editForm->addDataSource($dataSource);
                $deleteForm->addDataSource($dataSource);

                echo ViewHelper::render("view/user-edit.php", [
                    "form" => $editForm,
                    "deleteForm" => $deleteForm
                ]);
            } else {
                throw new InvalidArgumentException("editing nonexistent entry");
            }
        }
    }

    public static function userDelete() {
        $form = new UserDeleteForm("delete_user_form");
        $data = $form->getValue();

        if ($form->isSubmitted() && $form->validate()) {
            try {
                UserDB::deleteUser($data);
                ViewHelper::redirect(BASE_URL . "sales/users");
            } catch (Exception $e) {
                echo ("Cannot delete this product (it has probably been ordered)");
            }
        } else {
            if (isset($data["id"])) {
                $url = BASE_URL . "sales/user/edit/" . $data["id"];
            } else {
                $url = BASE_URL . "sales/users";
            }
            ViewHelper::redirect($url);
        }
    }

}
