<?php

require_once 'HTML/QuickForm2.php';
require_once 'HTML/QuickForm2/Container/Fieldset.php';
require_once 'HTML/QuickForm2/Element/InputSubmit.php';
require_once 'HTML/QuickForm2/Element/InputText.php';
require_once 'HTML/QuickForm2/Element/Textarea.php';
require_once 'HTML/QuickForm2/Element/InputCheckbox.php';
require_once 'HTML/QuickForm2/Element/Select.php';

class CheckoutForm extends HTML_QuickForm2 {

    public $id;

    public function __construct($id) {
        parent::__construct($id, "post", ["action" => BASE_URL . "user/checkout/confirm"]);

        $this->id = new HTML_QuickForm2_Element_InputHidden("id");
        $this->addElement($this->id);

        $this->confirmation = new HTML_QuickForm2_Element_InputCheckbox("confirmation");
        $this->confirmation->setLabel("Confirm checkout?");
        $this->confirmation->addRule('required', "Tick if you want to convert this cart to an order");
        $this->addElement($this->confirmation);

        $this->button = new HTML_QuickForm2_Element_InputSubmit(null);
        $this->button->setAttribute('value', "Order these items");
        $this->addElement($this->button);
    }
    
}
