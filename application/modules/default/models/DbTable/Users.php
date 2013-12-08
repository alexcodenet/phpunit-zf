<?php

class Default_Model_DbTable_Users extends Zend_Db_Table_Abstract 
{
    protected $_name = 'sample';
    
    public function insertUser($username, $password)
    {
        $salt = null;
        if (isset($password)) 
        {
            $salt = md5($password);
        }
        
        $this->insert(array
        (
            'username' => $username,
            'password' => $password,
            'salt'     => $salt 
        ));
    }
}