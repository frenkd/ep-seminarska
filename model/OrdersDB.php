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
}