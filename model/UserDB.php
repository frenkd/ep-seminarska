<?php

require_once 'model/AbstractDB.php';
require_once 'model/AddressDB.php';

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
            . " Post.id as idPost,"
            . " Role.role as role"
            . " FROM User"
            . " LEFT JOIN Address ON User.idAddress = Address.id"
            . " LEFT JOIN Post ON Address.idPost = Post.id"
            . " LEFT JOIN Role ON User.idRole = Role.id"
            . " ORDER BY id ASC");
    }

    public static function get($params) {
        $users = parent::query(
            "SELECT"
            . " User.id as id,"
            . " User.name as name,"
            . " User.surname as surname,"
            . " User.email as email,"
            . " User.active as active,"
            . " Address.street as street,"
            . " Address.id as idAddress,"
            . " Post.name as post,"
            . " Post.id as idPost,"
            . " Role.role as role"
            . " FROM User"
            . " LEFT JOIN Address ON User.idAddress = Address.id"
            . " LEFT JOIN Post ON Address.idPost = Post.id"
            . " LEFT JOIN Role ON User.idRole = Role.id"
            . " WHERE User.id = :id"
            . " ORDER BY id ASC", $params);

            if (count($users) == 1) {
                $user = $users[0];
                return $user;
            } else {
                throw new InvalidArgumentException("No user with such user info");
            }
    }

    public static function getAllSalesmen() {
        return parent::query(
            "SELECT"
            . " User.id as id,"
            . " User.name as name,"
            . " User.surname as surname,"
            . " User.email as email,"
            . " User.active as active,"
            . " Role.role as role"
            . " FROM User"
            . " LEFT JOIN Role ON User.idRole = Role.id"
            . " WHERE Role.role = 'Salesman'"
            . " ORDER BY id ASC");
    }

    public static function register(array $params) {
        $params["idAddress"] = AddressDB::insert($params);
        $params["idRole"] = 1; // Default when registering: Registred user
        $params["active"] = 1; // Default when registering: Active
        $params["password"] = password_hash($params["password"], PASSWORD_BCRYPT);
        return parent::modify(
            "INSERT INTO User (name, surname, email, password, active, idAddress, idRole) "
            . " VALUES (:name, :surname, :email, :password, :active, :idAddress, :idRole)", $params);
    }

    public static function updateSettingsSuperuser(array $params) {
        $params["password"] = password_hash($params["password"], PASSWORD_BCRYPT);
        return parent::modify("UPDATE User SET"
        . " name = :name,"
        . " surname = :surname,"
        . " email = :email,"
        . " password = :password,"
        . " active = :active"
        . " WHERE id = :id", $params);
    }

    public static function updateSettingsUser(array $params) {
        $params["password"] = password_hash($params["password"], PASSWORD_BCRYPT);
        AddressDB::update($params);
        return parent::modify("UPDATE User SET"
        . " name = :name,"
        . " surname = :surname,"
        . " email = :email,"
        . " password = :password"
        . " WHERE id = :id", $params);
    }

    public static function login(array $params) {
        $users =  parent::query(
            "SELECT"
            . " User.id as id,"
            . " User.name as name,"
            . " User.email as email,"
            . " User.password as password,"
            . " Role.role as role"
            . " FROM User"
            . " LEFT JOIN Role ON User.idRole = Role.id"
            . " WHERE User.email = :email"
            . " ORDER BY id ASC", $params);
        if (count($users) == 1) {
            $user = $users[0];
            // check if the password on the database matches the given password
            if (password_verify ($params["password"] , $user["password"])) {
                return $user;
            }
            else {
                throw new InvalidArgumentException("Incorrect password");
            }
        } else {
            throw new InvalidArgumentException("No user with such user info");
        }
    }

}