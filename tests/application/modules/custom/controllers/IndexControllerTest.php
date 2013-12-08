<?php

class Custom_IndexControllerTest extends Zend_Test_PHPUnit_ControllerTestCase
{

    public function setUp()
    {
        $this->bootstrap = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
        parent::setUp();
    }

    public function testIndexAction()
    {
        $params = array('action' => 'index', 'controller' => 'Index', 'module' => 'custom');
        $urlParams = $this->urlizeOptions($params);
        $url = $this->url($urlParams);
        $this->dispatch($url);
        
        // assertions
        $this->assertModule($urlParams['module']);
        $this->assertController($urlParams['controller']);
        $this->assertAction($urlParams['action']);
        $this->assertQueryCount('form#login', 1);
    }
    
    public function testUserRegisteredIndexAction()
    {
        $this->getRequest()
             ->setMethod('POST')
             ->setPost(array("username" => "client3",
                             "password" => "00000"));
         
        $this->dispatch('/custom/index/index');
        
        $this->assertQueryContentContains('h1', 'Registered');
        $this->assertQueryCount('form#login', 0);
    }

    public function testUserLoggedIndexAction()
    {
        $this->getRequest()
             ->setMethod('POST')
             ->setPost(array("username" => "client3",
                             "password" => "00000"));
        
        $this->dispatch('/custom/index/index');
        
        $this->assertQueryContentContains('h1', 'Logged'); 
        $this->assertQueryCount('form#login', 0);
    }
}



