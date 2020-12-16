<?php

require_once 'model/AbstractDB.php';

class OrdersDB extends AbstractDB {

    public static function getAllInfo() {
        return parent::query(
            "SELECT"
            . " Orders.id as id,"
            . " OrderStatus.status as status,"
            . " Orders.timestamp as timestamp,"
            . " Orders.idUser as idUser,"
            . " User.email as email,"
            . " (SELECT SUM(price) FROM OrderItem WHERE OrderItem.idOrder = Orders.id) as amount"
            . " FROM Orders"
            . " LEFT JOIN User ON Orders.idUser = User.id"
            . " LEFT JOIN OrderStatus ON OrderStatus.id = Orders.idStatus"
            . " ORDER BY id ASC");
    }

    public static function getUserOrders(array $user) {
        return parent::query(
            "SELECT"
            . " Orders.id as id,"
            . " OrderStatus.status as status,"
            . " Orders.timestamp as timestamp,"
            . " (SELECT SUM(price) FROM OrderItem WHERE OrderItem.idOrder = Orders.id) as amount"
            . " FROM Orders"
            . " LEFT JOIN OrderStatus ON OrderStatus.id = Orders.idStatus"
            . " WHERE Orders.idUser = :idUser"
            . " ORDER BY id ASC", $user);
    }

    public static function getOrderItems(array $order) {
        return parent::query(
            "SELECT"
            . " oi.idProduct as idProduct,"
            . " Product.title as title,"
            . " Company.name as company,"
            . " Color.name as color,"
            . " oi.price as price,"
            . " Product.size as size,"
            . " oi.quantity as quantity,"
            . " (oi.price * oi.quantity) as amount"
            . " FROM OrderItem as oi"
            . " LEFT JOIN Product ON oi.idProduct = Product.id"
            . " LEFT JOIN Company ON Product.idCompany = Company.id"
            . " LEFT JOIN Color ON Product.idCompany = Color.id"
            . " WHERE oi.idOrder = :id", $order);

    }

    public static function insertOrder(array $user) {
        // create order
        $order = ['idStatus' => '1', 'idUser' => $user['idUser']];
        $idOrder = parent::modify(
            "INSERT INTO Orders SET"
            . " idStatus = :idStatus,"
            . " idUser = :idUser,"
            . " timestamp = NOW()"
            , $order);
        
        $orderItems = [
            'idOrder' => $idOrder,
            'idUser' => $user['idUser']
        ];
        // populate order
        parent::modify(
            "INSERT INTO OrderItem"
            . " (idOrder, idProduct, quantity, price)"
            . " SELECT :idOrder as idOrder, idProduct, quantity, CartItem.quantity * Product.price as price FROM CartItem"
            . " LEFT JOIN Product ON CartItem.idProduct = Product.id"
            . " WHERE CartItem.idUser = :idUser"
            , $orderItems);
    }

}