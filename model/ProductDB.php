<?php

require_once 'model/AbstractDB.php';

class ProductDB extends AbstractDB {

    public static function getAll() {
        return parent::query("SELECT id, title, description, size, price, active, idCompany, idColor"
                        . " FROM Product"
                        . " ORDER BY id ASC");
    }

    public static function get(array $id) {
        $products = parent::query("SELECT id, title, description, size, price, active, idCompany, idColor"
                        . " FROM Product"
                        . " WHERE id = :id", $id);

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

    public static function get_company(array $id) {
        $companies = parent::query("SELECT name"
                        . " FROM Company"
                        . " WHERE id = :id", $id);
        if (count($companies) == 1) {
            return $companies[0];
        } else {
            throw new InvalidArgumentException("No such company");
        }
    }

    public static function get_color(array $id) {
        $companies = parent::query("SELECT name"
                        . " FROM Color"
                        . " WHERE id = :id", $id);
        if (count($companies) == 1) {
            return $companies[0];
        } else {
            throw new InvalidArgumentException("No such company");
        }
    }

    public static function insert(array $params) {
        return parent::modify("INSERT INTO Product (title, description, size, price, active, idCompany, idColor) "
                        . " VALUES (:title, :description, :size, :price, :active, :idCompany, :idColor, :image)", $params);
    }

    public static function update(array $params) {
        return parent::modify("UPDATE Product SET"
        . "title = :title,"
        . "description = :description,"
        . "price = :price,"
        . "active = :active,"
        . "idCompany = :idCompany,"
        . "idColor = :idColor,"
        . "image = :image"
        . " WHERE id = :id", $params);
    }

    public static function delete(array $id) {
        return parent::modify("DELETE FROM Product WHERE id = :id", $id);
    }

    public static function getAllwithURI(array $prefix) {
        return parent::query("SELECT id, title, description, size, price, active, idCompany, idColor, "
                        . "CONCAT(:prefix, id) as uri "
                        . "FROM book "
                        . "ORDER BY id ASC", $prefix);
    }

}
