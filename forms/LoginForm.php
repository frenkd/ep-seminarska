<?php

require_once 'HTML/QuickForm2.php';
require_once 'HTML/QuickForm2/Container/Fieldset.php';
require_once 'HTML/QuickForm2/Element/InputSubmit.php';
require_once 'HTML/QuickForm2/Element/InputText.php';
require_once 'HTML/QuickForm2/Element/InputPassword.php';

class LoginForm extends HTML_QuickForm2 {

    public $email;
    public $password;

    public function __construct($id) {
        parent::__construct($id);

        $this->email = new HTML_QuickForm2_Element_InputText('email');
        $this->email->setAttribute('size', 25);
        $this->email->setLabel('Email:');
        $this->email->addRule('required', 'Input email.');
        $this->email->addRule('callback', 'Input valid email.', array(
            'callback' => 'filter_var',
            'arguments' => [FILTER_VALIDATE_EMAIL])
        );
        $this->addElement($this->email);

        $this->password = new HTML_QuickForm2_Element_InputPassword('password');
        $this->password->setLabel('Password:');
        $this->password->setAttribute('size', 15);
        $this->password->addRule('required', 'Input password.');
        $this->addElement($this->password);

        $this->button = new HTML_QuickForm2_Element_InputSubmit(null);
        $this->button->setAttribute('value', 'Login');
        $this->addElement($this->button);

        $this->addRecursiveFilter('trim');
        $this->addRecursiveFilter('htmlspecialchars');
    }

}