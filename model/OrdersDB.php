<?php

require_once 'model/AbstractDB.php';

class OrdersDB extends AbstractDB {

    public static function getAllInfo() {
        return parent::query(
            "SELECT"
            . " Orders.id as id,"
            . " Orders.status as status,"
            . " Orders.timestamp as timestamp,"
            . " Orders.idUser as idUser,"
            . " User.email as email,"
            . " (SELECT SUM(price) FROM OrderItem WHERE OrderItem.idOrder = Orders.id) as amount"
            . " FROM Orders"
            . " LEFT JOIN User ON Orders.idUser = User.id"
            . " ORDER BY id ASC");
    }

    public static function getUserOrders(array $user) {
        return parent::query(
            "SELECT"
            . " Orders.id as id,"
            . " Orders.status as status,"
            . " Orders.timestamp as timestamp,"
            . " (SELECT SUM(price) FROM OrderItem WHERE OrderItem.idOrder = Orders.id) as amount"
            . " FROM Orders"
            . " WHERE Orders.idUser = :idUser"
            . " ORDER BY id ASC", $user);
    }

    public static function getOrderItems(array $order) {
        $items = parent::query(
            "SELECT"
            . " oi.idProduct as idProduct,"
            . " Product.title as title,"
            . " Company.name as company,"
            . " Color.name as color,"
            . " oi.price as price,"
            . " oi.quantity as price,"
            . " (oi.price * oi.quantity) as amount"
            . " FROM OrderItem as oi"
            . " LEFT JOIN Product ON oi.idProduct = Product.id"
            . " LEFT JOIN Company ON Product.idCompany = Company.id"
            . " LEFT JOIN Color ON Product.idCompany = Color.id"
            . " WHERE id = :id", $order);

        if (count($products) == 1) {
            $product = $products[0];
            // Get company and color
            $idCompany = $product['idCompany'];
            $idColor = $product['idColor'];
            $product['company'] = self::get_company(['id' => $idCompany])['name'];
            $product['color'] = self::get_color(['id' => $idColor])['name'];
            return $product;
        } else {
            throw new InvalidArgumentException("No such sneakers");
        }
    }

}