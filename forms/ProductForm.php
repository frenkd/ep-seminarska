<?php

require_once 'HTML/QuickForm2.php';
require_once 'HTML/QuickForm2/Container/Fieldset.php';
require_once 'HTML/QuickForm2/Element/InputSubmit.php';
require_once 'HTML/QuickForm2/Element/InputText.php';
require_once 'HTML/QuickForm2/Element/Textarea.php';
require_once 'HTML/QuickForm2/Element/InputCheckbox.php';
require_once 'HTML/QuickForm2/Element/Select.php';

abstract class ProductAbstractForm extends HTML_QuickForm2 {

    public $title;
    public $description;
    public $active;
    public $price;
    public $idCompany;
    public $idColor;
    public $button;

    public function __construct($id) {
        parent::__construct($id);

        $this->title = new HTML_QuickForm2_Element_InputText('title');
        $this->title->setAttribute('size', 70);
        $this->title->setLabel('Sneaker title:');
        $this->title->addRule('required', 'Title is mandatory.');
        $this->title->addRule('regex', 'Letters and numbers only.', '/^[a-zA-ZščćžŠČĆŽ0-9 ]+$/');
        $this->title->addRule('maxlength', 'Should be shorter than 45 characters.', 45);
        $this->addElement($this->title);

        $this->description = new HTML_QuickForm2_Element_Textarea('description');
        $this->description->setAttribute('rows', 10);
        $this->description->setAttribute('cols', 70);
        $this->description->setLabel('Product description');
        $this->description->addRule('required', 'Provide some text.');
        $this->description->addRule('regex', 'Letters and numbers and only.', '/^[a-zA-ZščćžŠČĆŽ0-9 ]+$/');
        $this->addElement($this->description);

        $this->price = new HTML_QuickForm2_Element_InputText('price');
        $this->price->setAttribute('size', 10);
        $this->price->setLabel('Price:');
        $this->price->addRule('required', 'Price is mandatory.');
        $this->price->addRule('callback', 'Price should be a valid number.', array(
            'callback' => 'filter_var',
            'arguments' => [FILTER_VALIDATE_FLOAT]
        ));
        $this->addElement($this->price);

        $this->size = new HTML_QuickForm2_Element_InputText('size');
        $this->size->setAttribute('size', 10);
        $this->size->setLabel('Size:');
        $this->size->addRule('required', 'Size is mandatory.');
        $this->size->addRule('gte', 'Size must be above 10', [ 10 ]);
        $this->size->addRule('lte', 'Size must be below 80', [ 80 ]);
        $this->size->addRule('callback', 'Size should be a valid number.', array(
            'callback' => 'filter_var',
            'arguments' => [FILTER_VALIDATE_FLOAT]
        ));
        $this->addElement($this->size);

        $this->active = new HTML_QuickForm2_Element_Select('active');
        $this->active->loadOptions(array('1' => 'Yes', '0' => 'No'));
        $this->active->setLabel('Is active');
        $this->active->addRule('required', 'Provide some text.');
        $this->addElement($this->active);

        $this->idCompany = new HTML_QuickForm2_Element_Select('idCompany');
        $this->idCompany->loadOptions(ProductDB::get_companies());
        $this->idCompany->setLabel('Product company');
        $this->idCompany->addRule('required', 'Provide some text.');
        $this->addElement($this->idCompany);

        $this->idColor = new HTML_QuickForm2_Element_Select('idColor');
        $this->idColor->loadOptions(ProductDB::get_colors());
        $this->idColor->setLabel('Product color');
        $this->idColor->addRule('required', 'Provide some text.');
        $this->addElement($this->idColor);

        $this->button = new HTML_QuickForm2_Element_InputSubmit(null);
        $this->addElement($this->button);

        $this->addRecursiveFilter('trim');
        $this->addRecursiveFilter('htmlspecialchars');
    }

}

class ProductInsertForm extends ProductAbstractForm {

    public function __construct($id) {
        parent::__construct($id);

        $this->button->setAttribute('value', 'Add sneaker');
    }

}

class ProductEditForm extends ProductAbstractForm {

    public $id;

    public function __construct($id) {
        parent::__construct($id);

        $this->button->setAttribute('value', 'Edit sneaker');
        $this->id = new HTML_QuickForm2_Element_InputHidden("id");
        $this->addElement($this->id);
    }

}

class ProductDeleteForm extends HTML_QuickForm2 {

    public $id;

    public function __construct($id) {
        parent::__construct($id, "post", ["action" => BASE_URL . "sneakers/delete"]);

        $this->id = new HTML_QuickForm2_Element_InputHidden("id");
        $this->addElement($this->id);

        $this->confirmation = new HTML_QuickForm2_Element_InputCheckbox("confirmation");
        $this->confirmation->setLabel('Delete?');
        $this->confirmation->addRule('required', 'Tick if you want to delete sneaker.');
        $this->addElement($this->confirmation);

        $this->button = new HTML_QuickForm2_Element_InputSubmit(null);
        $this->button->setAttribute('value', 'Delete sneaker');
        $this->addElement($this->button);
    }

}
