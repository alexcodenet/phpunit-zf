<?php

class Custom_Form_Login extends Zend_Form
{

    public function init()
    {
        $this->setName('login');

        $username = new Zend_Form_Element_Text('username');
        $password = new Zend_Form_Element_Password('password');
        
        $submit = new Zend_Form_Element_Submit('submit');
        
        $username->setLabel("Enter a login");
        $password->setLabel("Enter a password");
        $submit->setLabel('Enter');
        
        $this->addElements(array($username, $password, $submit));
    }


}

