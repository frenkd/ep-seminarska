<?php

require_once 'model/AbstractDB.php';

class ProductDB extends AbstractDB {

    public static function getAll() {
        return parent::query(
            "SELECT"
            ." p.id, p.title, p.description, p.size,"
            ." p.price, p.active, p.idCompany, p.idColor,"
            ." Color.name as color, Company.name as company"
            . " FROM Product p"
            . " LEFT JOIN Company ON Company.id = p.idCompany"
            . " LEFT JOIN Color ON Color.id = p.idColor"
            . " ORDER BY id ASC");
    }

    public static function getAllActive() {
        return parent::query("SELECT id, title, description, size, price, active, idCompany, idColor"
                        . " FROM Product"
                        . " WHERE active = '1'"
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

    public static function get_colors() {
        $colors = parent::query("SELECT id, name"
                        . " FROM Color");
        $color_return = array();
        foreach ($colors as $c) {
            $id = $c['id'];
            $name = $c['name'];
            $color_return[$id] = $name;
        }
        return $color_return;
    }

    public static function get_companies() {
        $colors = parent::query("SELECT id, name"
                        . " FROM Company");
        $color_return = array();
        foreach ($colors as $c) {
            $id = $c['id'];
            $name = $c['name'];
            $color_return[$id] = $name;
        }
        return $color_return;
    }

    public static function insert(array $params) {
        return parent::modify("INSERT INTO Product (title, description, size, price, active, idCompany, idColor) "
                        . " VALUES (:title, :description, :size, :price, :active, :idCompany, :idColor)", $params);
    }

    public static function update(array $params) {
        return parent::modify("UPDATE Product SET"
        . " title = :title,"
        . " description = :description,"
        . " price = :price,"
        . " size = :size,"
        . " active = :active,"
        . " idCompany = :idCompany,"
        . " idColor = :idColor"
        . " WHERE id = :id", $params);
    }

    public static function delete(array $id) {
        return parent::modify("DELETE FROM Product WHERE id = :id", $id);
    }

    public static function getAllwithURI(array $prefix) {
        return parent::query("SELECT id, title, description, size, price, active, idCompany, idColor"
                        . "CONCAT(:prefix, id) as uri "
                        . "FROM book "
                        . "ORDER BY id ASC", $prefix);
    }

}
