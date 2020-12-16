<?php

require_once 'model/AbstractDB.php';

class AddressDB extends AbstractDB {

    public static function getAll() {
        return parent::query("SELECT id, street, idPost"
                        . " FROM Address"
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

    public static function insert(array $params) {
        return parent::modify("INSERT INTO Address (street, idPost) "
                        . " VALUES (:street, :idPost)", $params);
    }

    public static function update(array $params) {
        return parent::modify("UPDATE Address SET"
        . " street = :street,"
        . " idPost = :idPost"
        . " WHERE id = :idAddress", $params);
    }

    public static function getAllPosts() {
        $posts = parent::query("SELECT id, name"
                            . " FROM Post"
                            . " ORDER BY id ASC");
        $posts_return = array();
        foreach ($posts as $c) {
            $id = $c['id'];
            $name = $c['id'] . " " .$c['name'];
            $posts_return[$id] = $name;
        }
        return $posts_return;
    }

}
