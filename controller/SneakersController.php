<?php


require_once("ViewHelper.php");
require_once("model/ProductDB.php");
require_once("forms/ProductForm.php");

class SneakersController {
    
    public static function index() {
        echo ViewHelper::render("view/product-gallery.php", [
            "sneakers" => ProductDB::getAll()
        ]);
    }

    public static function get($id) {
        echo ViewHelper::render("view/product-details.php", ProductDB::get(["id" => $id]));
    }

    public static function add() {
        $values['companies'] = ProductDB::get_companies();
        $values['colors'] = ProductDB::get_colors();
        $form = new ProductInsertForm("add_form");

        if ($form->validate()) {
            $id = ProductDB::insert($form->getValue());
            ViewHelper::redirect(BASE_URL . "sneakers/" . $id);
        } else {
            echo ViewHelper::render("view/product-form.php", [
                "title" => "Add sneaker",
                "form" => $form
            ]);
        }
    }

    public static function edit($params) {
        $editForm = new ProductEditForm("edit_form");
        $deleteForm = new ProductDeleteForm("delete_form");

        if ($editForm->isSubmitted()) {
            if ($editForm->validate()) {
                $data = $editForm->getValue();
                ProductDB::update($data);
                ViewHelper::redirect(BASE_URL . "sneakers/" . $id);
            } else {
                echo ViewHelper::render("view/product-form.php", [
                    "title" => "Edit sneaker",
                    "form" => $form,
                    "deleteForm" => $deleteForm
                ]);
            }
        } else {
            if (is_numeric($params["id"])) {
                $product = ProductDB::get($params);
                $dataSource = new HTML_QuickForm2_DataSource_Array($product);
                $editForm->addDataSource($dataSource);
                $deleteForm->addDataSource($dataSource);

                echo ViewHelper::render("view/product-form.php", [
                    "title" => "Edit sneaker",
                    "form" => $editForm,
                    "deleteForm" => $deleteForm
                ]);
            } else {
                throw new InvalidArgumentException("editing nonexistent entry");
            }
        }
    }

    public static function delete() {
        $form = new ProductDeleteForm("delete_form");
        $data = $form->getValue();
        var_dump($data);

        if ($form->isSubmitted() && $form->validate()) {
            ProductDB::delete($data);
            ViewHelper::redirect(BASE_URL . "sneakers");
        } else {
            if (isset($data["id"])) {
                $url = BASE_URL . "sneakers/edit/" . $data["id"];
            } else {
                $url = BASE_URL . "sneakers";
            }

            ViewHelper::redirect($url);
        }
    }

}
