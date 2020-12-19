<?php

require_once 'HTML/QuickForm2.php';
require_once 'HTML/QuickForm2/Container/Fieldset.php';
require_once 'HTML/QuickForm2/Element/InputSubmit.php';
require_once 'HTML/QuickForm2/Element/InputText.php';
require_once 'HTML/QuickForm2/Element/InputPassword.php';


class SearchForm extends HTML_QuickForm2 {

    public $query;

    public function __construct($id) {
        parent::__construct($id);

        $this->query = new HTML_QuickForm2_Element_InputText('query');
        $this->query->setAttribute('size', 25);
        $this->query->setLabel('Search query:');
        $this->query->addRule('regex', 'Letters and numbers only.', '/^[a-zA-ZščćžŠČĆŽ0-9 ]+$/');
        $this->query->addRule('maxlength', 'Should be shorter than 45 characters.', 45);
        $this->addElement($this->query);

        $this->button = new HTML_QuickForm2_Element_InputSubmit(null);
        $this->button->setAttribute('value', 'Search');
        $this->addElement($this->button);

        $this->addRecursiveFilter('trim');
        $this->addRecursiveFilter('htmlspecialchars');
    }

}