<?php

require_once 'model/AbstractDB.php';

class PostDB extends AbstractDB {

    public static function getAll() {
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
