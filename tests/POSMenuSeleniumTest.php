<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


/*function login($browser){
    //enter the user & password
    $browser->type("email", "visiteur@mirageflow.com");
    $browser->type("password", "Visiteur!");
    $browser->click("btn-login");
    $browser->waitForPageToLoad(2);
}*/


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
        $this->setBrowserUrl('http://pos.mirageflow.com/');
    }


    public function testLogin()
    {
        $this->url('http://pos.mirageflow.com/');
        $this->login();
        $this->assertEquals('POSIO', $this->title());
    }


    public function loginPOSMenu()
    {
        $this->url('http://pos.mirageflow.com/menu');
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

        $command_client = $this->byCssSelector('h2')->text();

        $this->assertEquals('Commande - Client: #1', $command_client);
    }

   /* public function testPagePOSMenuPunch()
    {
        $user = factory(App\Models\Auth\User::class)->create();

        $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->visit('/menu');

        sleep(10); // Give the time to Angular for loading

        $this->click('btn-menu-3')
            ->click('btn-menu-clk');

        sleep(3); // Give the time to Angular for loading

        $this->click('btn-Barmaid')
            ->see('The employee has been successfully punched in !')
            ->click('btn-menu-clk')
            ->see('The employee has been successfully punched out !');
    }*/


}
