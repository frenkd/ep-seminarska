<?php

require_once 'HTML/QuickForm2.php';
require_once 'HTML/QuickForm2/Container/Fieldset.php';
require_once 'HTML/QuickForm2/Element/InputSubmit.php';
require_once 'HTML/QuickForm2/Element/InputText.php';
require_once 'HTML/QuickForm2/Element/InputPassword.php';

class RegisterForm extends HTML_QuickForm2 {

    public $name;
    public $surname;
    public $street;
    public $idPost;
    public $email;
    public $password;
    public $password2;
    public $button;
    public $fs;
    public $account;
    public $personal;
    public $address;

    public function __construct($id) {
        parent::__construct($id);

        $this->name = new HTML_QuickForm2_Element_InputText('name');
        $this->name->setAttribute('size', 15);
        $this->name->setLabel('Name:');
        $this->name->addRule('required', 'Input your name.');
        $this->name->addRule('regex', 'Pri imenu uporabite le črke.', '/^[a-zA-ZščćžŠČĆŽ ]+$/');
        $this->name->addRule('maxlength', 'name naj bo krajše od 45 znakov.', 45);

        $this->surname = new HTML_QuickForm2_Element_InputText('surname');
        $this->surname->setAttribute('size', 15);
        $this->surname->setLabel('Surname:');
        $this->surname->addRule('required', 'Vnesite surname.');
        $this->surname->addRule('regex', 'Pri priimku uporabite le črke.', '/^[a-zA-ZščćžŠČĆŽ\- ]+$/');
        $this->surname->addRule('maxlength', 'surname naj bo krajši od 45 znakov.', 45);

        $this->street = new HTML_QuickForm2_Element_InputText('street');
        $this->street->setAttribute('size', 25);
        $this->street->setLabel('Street name and number:');
        $this->street->addRule('required', 'Vnesite ulico in hišno številko.');
        $this->street->addRule('regex', 'Uporabiti smete le črke, številke in presledek.', '/^[a-zA-ZščćžŠČĆŽ 0-9]+$/');
        $this->street->addRule('maxlength', 'Vnos naj bo krajši od 45 znakov.', 45);

        $this->idPost = new HTML_QuickForm2_Element_Select('idPost');
        $this->idPost->setLabel("Post");
        $this->idPost->loadOptions(PostDB::getAll());
        $this->idPost->addRule('required', 'Izberi pošto.');

        $this->email = new HTML_QuickForm2_Element_InputText('email');
        $this->email->setAttribute('size', 25);
        $this->email->setLabel('Elektronski naslov:');
        $this->email->addRule('required', 'Vnesite elektronski naslov.');
        $this->email->addRule('callback', 'Vnesite veljaven elektronski naslov.', array(
            'callback' => 'filter_var',
            'arguments' => [FILTER_VALIDATE_EMAIL])
        );

        $this->password = new HTML_QuickForm2_Element_InputPassword('password');
        $this->password->setLabel('Choose password:');
        $this->password->setAttribute('size', 15);
        $this->password->addRule('required', 'Vnesite password.');
        $this->password->addRule('minlength', 'password naj vsebuje vsaj 6 znakov.', 6);
        $this->password->addRule('regex', 'V geslu uporabite vsaj 1 številko.', '/[0-9]+/');
        $this->password->addRule('regex', 'V geslu uporabite vsaj 1 veliko črko.', '/[A-Z]+/');
        $this->password->addRule('regex', 'V geslu uporabite vsaj 1 malo črko.', '/[a-z]+/');

        $this->password2 = new HTML_QuickForm2_Element_InputPassword('password2');
        $this->password2->setLabel('Repeat password:');
        $this->password2->setAttribute('size', 15);
        $this->password2->addRule('required', 'Ponovno vpišite izbrano password.');
        $this->password2->addRule('eq', 'Gesli nista enaki.', $this->password);

        $this->button = new HTML_QuickForm2_Element_InputSubmit(null);
        $this->button->setAttribute('value', 'Register');

        $this->fs = new HTML_QuickForm2_Container_Fieldset();
        $this->fs->setLabel('New user - registration');
        $this->addElement($this->fs);

        $this->account = new HTML_QuickForm2_Container_Fieldset();
        $this->account->setLabel('Account data');
        $this->fs->addElement($this->account);
        
        $this->personal = new HTML_QuickForm2_Container_Fieldset();
        $this->personal->setLabel('Personal data');
        $this->fs->addElement($this->personal);
        
        $this->address = new HTML_QuickForm2_Container_Fieldset();
        $this->address->setLabel('Address data');
        $this->fs->addElement($this->address);

        $this->personal->addElement($this->name);
        $this->personal->addElement($this->surname);
        $this->account->addElement($this->email);
        $this->account->addElement($this->password);
        $this->account->addElement($this->password2);
        $this->address->addElement($this->street);
        $this->address->addElement($this->idPost);
        $this->fs->addElement($this->button);

        $this->addRecursiveFilter('trim');
        $this->addRecursiveFilter('htmlspecialchars');
    }

}