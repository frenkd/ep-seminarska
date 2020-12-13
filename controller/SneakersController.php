<?php


require_once("ViewHelper.php");
require_once("model/ProductDB.php");

class SneakersController {
    
    public static function index() {
        echo ViewHelper::render("view/sneaker-gallery.php", [
            "sneakers" => ProductDB::getAll()
        ]);
    }

    public static function get($id) {
        echo ViewHelper::render("view/sneaker-details.php", ProductDB::get(["id" => $id]));
    }

    public static function addForm($values = [
        "title" => "",
        "description" => "",
        "size" => "",
        "price" => "",
        "active" => "",
        "idCompany" => "",
        "idColor" => "",
        "image" => ""
    ]) {
        echo ViewHelper::render("view/sneaker-add.php", $values);
    }

    public static function add() {
        $data = filter_input_array(INPUT_POST, self::getRules());

        if (self::checkValues($data)) {
            $id = ProductDB::insert($data);
            echo ViewHelper::redirect(BASE_URL . "sneakers/" . $id);
        } else {
            self::addForm($data);
        }
    }

    public static function editForm($params) {
        if (is_array($params)) {
            $values = $params;
        } else if (is_numeric($params)) {
            $values = ProductDB::get(["id" => $params]);
        } else {
            throw new InvalidArgumentException("Cannot show form.");
        }

        echo ViewHelper::render("view/sneaker-edit.php", $values);
    }

    public static function edit($id) {
        $data = filter_input_array(INPUT_POST, self::getRules());

        if (self::checkValues($data)) {
            $data["id"] = $id;
            ProductDB::update($data);
            ViewHelper::redirect(BASE_URL . "sneakers/" . $data["id"]);
        } else {
            self::editForm($data);
        }
    }

    public static function delete($id) {
        $data = filter_input_array(INPUT_POST, [
            'delete_confirmation' => FILTER_REQUIRE_SCALAR
        ]);

        if (self::checkValues($data)) {
            ProductDB::delete(["id" => $id]);
            $url = BASE_URL . "sneakers";
        } else {
            $url = BASE_URL . "sneakers/edit/" . $id;
        }

        ViewHelper::redirect($url);
    }

    /**
     * Returns TRUE if given $input array contains no FALSE values
     * @param type $input
     * @return type
     */
    public static function checkValues($input) {
        if (empty($input)) {
            return FALSE;
        }

        $result = TRUE;
        foreach ($input as $value) {
            $result = $result && $value != false;
        }

        return $result;
    }

    /**
     * Returns an array of filtering rules for manipulation
     * @return type
     */
    public static function getRules() {
        return [
            'title' => FILTER_SANITIZE_SPECIAL_CHARS,
            'description' => FILTER_SANITIZE_SPECIAL_CHARS,
            'size' => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => [
                    'min_range' => 20,
                    'max_range' => 60
                ]
                ],
            'price' => FILTER_VALIDATE_FLOAT,
            'active' => FILTER_VALIDATE_INT,
            'idCompany' => FILTER_VALIDATE_INT,
            'idColor' => FILTER_VALIDATE_INT,
            'image' => FILTER_SANITIZE_SPECIAL_CHARS,
        ];
    }

}
