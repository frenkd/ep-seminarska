<?php

require_once 'model/AbstractDB.php';

class UserDB extends AbstractDB {

    public static function getAllInfo() {
        return parent::query(
            "SELECT"
            . " User.id as id,"
            . " User.name as name,"
            . " User.surname as surname,"
            . " User.email as email,"
            . " User.active as active,"
            . " Address.street as street,"
            . " Post.name as post,"
            . " Role.role as role"
            . " FROM User"
            . " LEFT JOIN Address ON User.idAddress = Address.id"
            . " LEFT JOIN Post ON Address.idPost = Post.id"
            . " LEFT JOIN Role ON User.idRole = Role.id"
            . " ORDER BY id ASC");
    }

    public static function insert(array $params) {
        return parent::modify("INSERT INTO User (name, surname, email, password, active, idAddress, idRole) "
                        . " VALUES (:name, :surname, :email, :password, :active, :idAddress, :idRole)", $params);
    }

}