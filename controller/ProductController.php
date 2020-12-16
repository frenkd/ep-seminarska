<?php


require_once("ViewHelper.php");
require_once("model/ProductDB.php");
require_once("forms/ProductForm.php");

class ProductController {
    
    public static function displayAllActive() {
        echo ViewHelper::render("view/product-gallery.php", [
            "sneakers" => ProductDB::getAllActive()
        ]);
    }

    public static function displayAllSales() {
        echo ViewHelper::render("view/product-list.php", [
            "products" => ProductDB::getAll()
        ]);
    }

    public static function productDetail($id) {
        echo ViewHelper::render("view/product-details.php", ProductDB::get(["id" => $id]));
    }

    public static function productAdd() {
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

    public static function productEdit($params) {
        $editForm = new ProductEditForm("edit_form");
        $deleteForm = new ProductDeleteForm("delete_form");

        if ($editForm->isSubmitted()) {
            if ($editForm->validate()) {
                $data = $editForm->getValue();
                ProductDB::update($data);
                ViewHelper::redirect(BASE_URL . "sales/products" . $id);
            } else {
                echo ViewHelper::render("view/product-form.php", [
                    "title" => "Edit sneaker",
                    "form" => $editForm,
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

    public static function productDelete() {
        $form = new ProductDeleteForm("delete_form");
        $data = $form->getValue();

        if ($form->isSubmitted() && $form->validate()) {
            try {
                ProductDB::delete($data);
                ViewHelper::redirect(BASE_URL . "sneakers");
            } catch (Exception $e) {
                echo ("Cannot delete this product (it has probably been ordered)");
            }
        } else {
            if (isset($data["id"])) {
                $url = BASE_URL . "sales/product/edit/" . $data["id"];
            } else {
                $url = BASE_URL . "sneakers";
            }

            ViewHelper::redirect($url);
        }
    }

}
