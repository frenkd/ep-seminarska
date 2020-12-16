<?php

require_once 'model/AbstractDB.php';
require_once 'model/OrdersDB.php';

class CartDB extends AbstractDB {

    public static function getUserCartItems(array $user) {
        return parent::query(
            "SELECT"
            . " CartItem.quantity as quantity,"
            . " Product.price as price,"
            . " Product.title as title,"
            . " Product.id as idProduct"
            . " FROM CartItem"
            . " LEFT JOIN Product ON Product.id = CartItem.idProduct"
            . " WHERE CartItem.idUser = :idUser"
            . " ORDER BY id ASC", $user);
    }

    public static function cartPurge(array $user) {
        return parent::modify("DELETE FROM CartItem WHERE idUser = :idUser", $user);
    }

    public static function cartAddItem(array $params) {
        $items = parent::query("SELECT quantity, idProduct, idUser"
        . " FROM CartItem"
        . " WHERE idProduct = :idProduct AND idUser = :idUser", $params);
        if (count($items) == 1) {
            return parent::modify("UPDATE CartItem SET"
                . " quantity = :quantity + 1"
                . " WHERE idUser = :idUser AND idProduct = :idProduct", $items[0]);
        } else {
            return parent::modify("INSERT CartItem SET"
            . " quantity = '1',"
            . " idUser = :idUser,"
            . " idProduct = :idProduct", $params);
        }
    }

    public static function cartUpdateQuantity(array $params) {
        if ($params['quantity'] < 1) {
            return parent::modify("DELETE FROM CartItem WHERE idUser = :idUser AND idProduct = :idProduct", $params);
        }
        else {
            return parent::modify("UPDATE CartItem SET"
                . " quantity = :quantity"
                . " WHERE idUser = :idUser AND idProduct = :idProduct", $params);
        }
    }

    public static function checkout(array $user) {
        // add order to Orders (and order items to OrderItem)
        OrdersDB::insertOrder($user);
        // empty cart
        self::cartPurge($user);
    }

}