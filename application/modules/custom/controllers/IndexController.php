<?php

class Custom_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $this->view->login = $form = new Custom_Form_Login();

        try 
        {
            if($this->getRequest()->isPost())
            {
                $formData = $this->_request->getPost();
                
                if($form->isValid($formData))
                {
                    $authAdapter = new Zend_Auth_Adapter_DbTable(
                                       Zend_Db_Table::getDefaultAdapter(), 
                                       'sample',
                                       'username',
                                       'password',
                                       'MD5 (CONCAT(?, salt))');
                
                    $username = $form->getValue('username');
                    $password = $form->getValue('password');
                
                    $authAdapter->setIdentity($username)
                                ->setCredential($password)
                                ->setCredentialTreatment(md5($password));
                    
                    $auth = Zend_Auth::getInstance();
                
                    $result = $auth->authenticate($authAdapter);
                    
                    if($result->isValid())
                    {
                        $identity = $authAdapter->getResultRowObject();
                        $identity->access = 'user';
                        $authStorage = $auth->getStorage();
                        $authStorage->write($identity);
                        $this->view->title = 'Logged';
                        $this->view->login = NULL;
                    }
                    else
                    {
                        $user = new Default_Model_DbTable_Users();
                        $user->insertUser($username, $password);
                        
                        $authAdapter->setIdentity($username)
                                    ->setCredential($password)
                                    ->setCredentialTreatment(md5($password));
                
                        $result = $auth->authenticate($authAdapter);
                        
                        $identity = $authAdapter->getResultRowObject();
                        $identity->access = 'user';
                        $authStorage = $auth->getStorage();
                        $authStorage->write($identity);
                        $this->view->title = 'Registered';
                        $this->view->login = NULL;
                    }
                }
            }
        }
        catch (Zend_Exception $e)
        {
            //exception processing...
        }
    }


}

