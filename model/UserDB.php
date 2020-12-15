<?php

require_once 'model/AbstractDB.php';

class UserDB extends AbstractDB {

    public static function getAll() {
        return parent::query("SELECT id, title, description, size, price, active, idCompany, idColor"
                        . " FROM Product"
                        . " ORDER BY id ASC");
    }

}
