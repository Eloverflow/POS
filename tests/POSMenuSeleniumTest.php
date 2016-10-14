<?php

class POSMenuSeleniumTest extends PHPUnit_Extensions_Selenium2TestCase
{

    protected function waitForPageToLoad($time)
    {
        sleep($time);
    }
    protected function login()
    {
        $this->byName('email')->value('visiteur@mirageflow.com');
        $this->byName('password')->value('Visiteur!');
        $this->byId('btn-login')->click();

        $this->waitForPageToLoad(2);
    }

    protected function setUp()
    {
        $this->setBrowser('chrome');
        $this->setBrowserUrl('http://localhost');
    }


    public function testLogin()
    {
        $this->url('http://localhost');
        $this->login();
        $this->assertEquals('POSIO', $this->title());
    }


    public function loginPOSMenu()
    {
        $this->url('http://localhost/menu');
        $this->login();
        $this->waitForPageToLoad(10);
        $this->byId('btn-menu-3')->click();
        $this->byId('btn-menu-enter')->click();
        $this->byId('btn-menu-1')->click();
        $this->byId('btn-menu-1')->click();
        $this->byId('btn-menu-enter')->click();
        $this->waitForPageToLoad(3);


        //$this->see('Commande - Client: #1');
    }


    public function testLoginPOSMenu()
    {
        $this->loginPOSMenu();
        $this->assertEquals('POSIO | Menu', $this->title());
    }


    public function testBasicPOSMenu()
    {
        $this->loginPOSMenu();

        $command_client = $this->byId('command-client-number')->text();

        $this->assertEquals('Commande - Client: #1', $command_client);
    }

    public function testPagePOSMenuPunch()
    {

        $this->url('http://localhost/menu');
        $this->login();
        $this->waitForPageToLoad(10);

        $this->byId('btn-menu-3')->click();
        $this->byId('btn-menu-clk')->click();


        $this->waitForPageToLoad(3);

        $this->byId('btn-Barmaid')->click();

        $alert =  $this->byClassName('alert')->text();

        $this->assertRegExp('/The employee has been successfully punched in !/i', $alert);

        $this->byId('btn-menu-clk')->click();

        $this->assertRegExp('/The employee has been successfully punched out !/i', $alert);
    }


}
