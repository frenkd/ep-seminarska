<?php


require_once("ViewHelper.php");
require_once("model/UserDB.php");
require_once("model/OrdersDB.php");
require_once("forms/UserForm.php");
require_once("forms/OrderForm.php");

class SalesController {

    public static function checkPermission() {
        $role = $_SESSION['role'];
        if ($role != 'Salesman') {
            ViewHelper::redirect(BASE_URL);
            exit();
        }
    }
    
    public static function users() {
        self::checkPermission();

        echo ViewHelper::render("view/user-list.php", [
            "users" => UserDB::getAllInfo()
        ]);
    }
   
    public static function userAdd() {
        self::checkPermission();
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
        self::checkPermission();

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
        self::checkPermission();

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

    public static function orders() {
        self::checkPermission();

        echo ViewHelper::render("view/sales-order-list.php", [
            "orders" => OrdersDB::getAllInfo()
        ]);
    }

    public static function orderDetails(array $id) {
        self::checkPermission();

        $confirmForm = new OrderStatusForm("confirm_order_form", $id['idOrder'], "confirm");
        $cancelForm = new OrderStatusForm("cancel_order_form", $id['idOrder'], "cancel");
        $revokeForm = new OrderStatusForm("revoke_order_form", $id['idOrder'], "revoke");

        $params = [
            "order" => OrdersDB::get($id),
            "orderItems" => OrdersDB::getOrderItems($id),
        ];

        if ($params['order']['status'] == 'Pending') {
            $params["confirmForm"] = $confirmForm;
            $params["cancelForm"] = $cancelForm;
        }
        else if ($params['order']['status'] == 'Confirmed') {
            $params["revokeForm"] = $revokeForm;
        }
        echo ViewHelper::render("view/sales-order-details.php", $params);
    }

    public static function updateOrderStatus($order) {
        self::checkPermission();
        var_dump($order);
        OrdersDB::updateOrderStatus($order);
        $url = BASE_URL . "sales/orders";
        ViewHelper::redirect($url);
    }

    public static function products() {
        self::checkPermission();

        echo ViewHelper::render("view/product-list.php", [
            "products" => ProductDB::getAll()
        ]);
    }

    public static function productAdd() {
        self::checkPermission();

        $form = new ProductInsertForm("add_form");
        if ($form->validate()) {
            $id = ProductDB::insert($form->getValue());
            ViewHelper::redirect(BASE_URL . "sneakers/" . $id);
        } else {
            echo ViewHelper::render("view/product-form.php", [
                "title" => "Add sneaker",
                "form" => $form
            ]);
        }
    }

    public static function productEdit($params) {
        self::checkPermission();

        $editForm = new ProductEditForm("edit_form");
        $deleteForm = new ProductDeleteForm("delete_form");

        if ($editForm->isSubmitted()) {
            if ($editForm->validate()) {
                $data = $editForm->getValue();
                ProductDB::update($data);
                ViewHelper::redirect(BASE_URL . "sales/products" . $id);
            } else {
                echo ViewHelper::render("view/product-form.php", [
                    "title" => "Edit sneaker",
                    "form" => $editForm,
                    "deleteForm" => $deleteForm
                ]);
            }
        } else {
            if (is_numeric($params["id"])) {
                $product = ProductDB::get($params);
                $dataSource = new HTML_QuickForm2_DataSource_Array($product);
                $editForm->addDataSource($dataSource);
                $deleteForm->addDataSource($dataSource);

                echo ViewHelper::render("view/product-form.php", [
                    "title" => "Edit sneaker",
                    "form" => $editForm,
                    "deleteForm" => $deleteForm
                ]);
            } else {
                throw new InvalidArgumentException("editing nonexistent entry");
            }
        }
    }

    public static function productDelete() {
        self::checkPermission();

        $form = new ProductDeleteForm("delete_form");
        $data = $form->getValue();

        if ($form->isSubmitted() && $form->validate()) {
            try {
                ProductDB::delete($data);
                ViewHelper::redirect(BASE_URL . "sneakers");
            } catch (Exception $e) {
                echo ("Cannot delete this product (it has probably been ordered)");
            }
        } else {
            if (isset($data["id"])) {
                $url = BASE_URL . "sales/product/edit/" . $data["id"];
            } else {
                $url = BASE_URL . "sneakers";
            }

            ViewHelper::redirect($url);
        }
    }

}
