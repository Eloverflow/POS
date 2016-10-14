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
        //$this->type("email", "visiteur@mirageflow.com");
        //$this->type("password", "Visiteur!");
        $this->click("btn-login");
        $this->waitForPageToLoad(2);
    }

    protected function setUp()
    {
        $this->setBrowser('chrome');
        $this->setBrowserUrl('http://pos.mirageflow.com/');
    }


    public function testTitle()
    {
        $this->url('http://pos.mirageflow.com/');
        $this->login();
        //login($this);
        $this->assertEquals('POSIO | Login', $this->title());
    }


    public function testPagePOSMenu()
    {
        $this->url('http://pos.mirageflow.com/');
        $this->login();
        $this->waitForPageToLoad(10);

        $this->click('btn-menu-3');
        $this->click('btn-menu-enter');
        $this->click('btn-menu-1');
        $this->click('btn-menu-1');
        $this->click('btn-menu-enter');


        $this->waitForPageToLoad(3);

        $this->assertEquals('POSIO | Menu', $this->title());

        //$this->see('Commande - Client: #1');
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
