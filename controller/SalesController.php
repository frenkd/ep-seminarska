<?php


require_once("ViewHelper.php");
require_once("model/UserDB.php");
require_once("model/OrdersDB.php");

class SalesController {
    
    
    public static function users() {
        echo ViewHelper::render("view/user-list.php", [
            "users" => UserDB::getAllInfo()
        ]);
    }

    public static function orders() {
        echo ViewHelper::render("view/order-list.php", [
            "orders" => OrdersDB::getAllInfo()
        ]);
    }

}
