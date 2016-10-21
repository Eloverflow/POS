<?php

class POSMenuSeleniumTest extends PHPUnit_Extensions_Selenium2TestCase
{
    protected function setUp()
    {
        $this->setBrowser('chrome');
        $this->setBrowserUrl('http://pos.mirageflow.com');
    }


    protected function waitForPageToLoad($time)
    {
        //sleep($time);
        //$this->waitUntil()
        $this->timeouts()->implicitWait($time*1000);
    }
    protected function login()
    {
        $this->byName('email')->value('visiteur@mirageflow.com');
        $this->byName('password')->value('Visiteur!');
        $this->byId('btn-login')->click();

        $this->waitForPageToLoad(2);
    }


    public function testLogin()
    {
        $this->url('/');
        $this->login();
        $this->assertEquals('POSIO', $this->title());
    }


    public function loginPOSMenu()
    {
        $this->url('/menu');
        $this->login();
        $this->waitForPageToLoad(10);
        $this->byId('btn-menu-3')->click();
        $this->byId('btn-menu-enter')->click();
        $this->byId('btn-menu-1')->click();
        $this->byId('btn-menu-1')->click();
        $this->byId('btn-menu-enter')->click();
        $this->waitForPageToLoad(3);

    }


    public function testLoginPOSMenu()
    {
        $webdriver = $this;
        $this->waitUntil(function() use($webdriver){
            try{
                $webdriver->loginPOSMenu();
                $webdriver->assertEquals('POSIO | Menu', $this->title());

                return true;
            }catch (Exception $ex){
                return null;
            }

        }, 5000);

        //$this->loginPOSMenu();
        //$this->assertEquals('POSIO | Menu', $this->title());
    }


    public function testBasicPOSMenu()
    {
        $webdriver = $this;
        $this->waitUntil(function() use($webdriver){
            try{


                $webdriver->loginPOSMenu();
                $webdriver->waitForPageToLoad(6);

                $command_client = $webdriver->byId('command-client-number')->text();

                $webdriver->assertEquals('Commande - Client: #1', $command_client);
                return true;
            }catch (Exception $ex){
                return null;
            }

        }, 5000);
     /*   $this->loginPOSMenu();
        $this->waitForPageToLoad(6);

        $command_client = $this->byId('command-client-number')->text();

        $this->assertEquals('Commande - Client: #1', $command_client);*/
    }

    public function testPagePOSMenuPunch()
    {
        $webdriver = $this;
        $this->waitUntil(function() use($webdriver){
            try{

                $webdriver->url('/menu');
                $webdriver->login();
                $webdriver->waitForPageToLoad(10);

                $webdriver->byId('btn-menu-3')->click();
                $webdriver->byId('btn-menu-clk')->click();


                $webdriver->waitForPageToLoad(10);

                $webdriver->byId('btn-Barmaid')->click();

                $webdriver->waitForPageToLoad(10);

                $alert =  $webdriver->byClassName('alert')->text();

                $webdriver->assertRegExp('/The employee has been successfully punched in !/i', $alert);

                $webdriver->byId('btn-menu-clk')->click();

                $webdriver->assertRegExp('/The employee has been successfully punched out !/i', $alert);
                return true;
            }catch (Exception $ex){
                return null;
            }

        }, 5000);

        /*
        $this->url('/menu');
        $this->login();
        $this->waitForPageToLoad(10);

        $this->byId('btn-menu-3')->click();
        $this->byId('btn-menu-clk')->click();


        $this->waitForPageToLoad(10);

        $this->byId('btn-Barmaid')->click();

        $this->waitForPageToLoad(10);

        $alert =  $this->byClassName('alert')->text();

        $this->assertRegExp('/The employee has been successfully punched in !/i', $alert);

        $this->byId('btn-menu-clk')->click();

        $this->assertRegExp('/The employee has been successfully punched out !/i', $alert);*/
    }


}
