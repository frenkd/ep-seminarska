<?php


require_once("ViewHelper.php");
require_once("model/UserDB.php");

class AdminController {

    public static function checkPermission() {
        $role = $_SESSION['role'];
        if ($role != 'Administrator') {
            ViewHelper::redirect(BASE_URL);
            exit();
        }
    }
    
    public static function salesmen() {
        self::checkPermission();
        echo ViewHelper::render("view/salesmen-list.php", [
            "salesmen" => UserDB::getAllSalesmen()
        ]);
    }
    
    public static function salesmanAdd() {
        self::checkPermission();
        $form = new RegisterFormSuperuser("register_form");

        if ($form->validate()) {
            UserDB::registerSalesman($form->getValue());
            ViewHelper::redirect(BASE_URL . "admin/salesmen");
        } else {
            echo ViewHelper::render("view/register.php", [
                "form" => $form
            ]);
        }
    }

    public static function salesmanEdit($id) {
        self::checkPermission();
        $editForm = new UserEditFormAdmin("edit_user_form");
        $deleteForm = new UserDeleteForm("delete_user_form");

        if ($editForm->isSubmitted()) {
            if ($editForm->validate()) {
                $data = $editForm->getValue();
                UserDB::update($data);
                ViewHelper::redirect(BASE_URL . "admin/salesmen");
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

    public static function salesmenDelete() {
        self::checkPermission();
        $form = new UserDeleteForm("delete_user_form");
        $data = $form->getValue();

        if ($form->isSubmitted() && $form->validate()) {
            try {
                UserDB::deleteUser($data);
                ViewHelper::redirect(BASE_URL . "admin/salesmen");
            } catch (Exception $e) {
                echo ("Cannot delete this product (it has probably been ordered)");
            }
        } else {
            if (isset($data["id"])) {
                $url = BASE_URL . "admin/salesman/edit/" . $data["id"];
            } else {
                $url = BASE_URL . "admin/salesmen";
            }
            ViewHelper::redirect($url);
        }
    }

}
