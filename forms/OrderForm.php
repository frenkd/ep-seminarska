<?php

require_once 'HTML/QuickForm2.php';
require_once 'HTML/QuickForm2/Container/Fieldset.php';
require_once 'HTML/QuickForm2/Element/InputSubmit.php';
require_once 'HTML/QuickForm2/Element/InputText.php';
require_once 'HTML/QuickForm2/Element/Textarea.php';
require_once 'HTML/QuickForm2/Element/InputCheckbox.php';
require_once 'HTML/QuickForm2/Element/Select.php';

class OrderStatusForm extends HTML_QuickForm2 {

    public $id;

    public function __construct($id, $idOrder, $statusName) {
        parent::__construct($id, "post", ["action" => BASE_URL . "sales/order/{$statusName}"]);

        $this->id = new HTML_QuickForm2_Element_InputHidden("id");
        $this->addElement($this->id);

        $this->idOrder = new HTML_QuickForm2_Element_InputHidden("idOrder");
        $this->idOrder->setAttribute('value', "{$idOrder}");
        $this->addElement($this->idOrder);

        $this->confirmation = new HTML_QuickForm2_Element_InputCheckbox("confirmation");
        $this->confirmation->setLabel("{$statusName} order?");
        $this->confirmation->addRule('required', "Tick if you want to {$statusName} order");
        $this->addElement($this->confirmation);

        $this->button = new HTML_QuickForm2_Element_InputSubmit(null);
        $this->button->setAttribute('value', "{$statusName} order");
        $this->addElement($this->button);
    }
    
}
