<?php


require_once("ViewHelper.php");
require_once("model/UserDB.php");

class AdminController {
    
    public static function salesmen() {
        echo ViewHelper::render("view/salesmen-list.php", [
            "salesmen" => UserDB::getAllSalesmen()
        ]);
    }

    public static function salesmenAdd() {
        echo("Not implemented yet");
    }

    public static function salesmenEdit() {
        echo("Not implemented yet");
    }

}
