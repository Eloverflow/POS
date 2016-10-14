<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


function login($browser){
    //navigate to the login page
    $browser->click("link=Login");
    $browser->waitForPageToLoad(CONST_WAIT_PERIOD);
    //enter the user & password
    $browser->type("edit-name", "myuser");
    $browser->type("edit-pass", "mypassword");
    $browser->click("edit-submit");
    $browser->waitForPageToLoad(CONST_WAIT_PERIOD);
}

function logout($browser){
    $browser->click("link=Log out");
}


class POSMenuSeleniumTest extends PHPUnit_Extensions_Selenium2TestCase
{



    protected function setUp()
    {
        $this->setHost('localhost');
        $this->setBrowser('firefox');
        $this->setBrowserUrl('http://localhost');
    }


    public function testTitle()
    {
        $this->open("/");
        login($this);
        $this->url('http://www.test.com/');
        $this->assertEquals('POSIO | LoginShouidFailNow?', $this->title());
    }
/*

    public function testPagePOSMenu()
    {
        $user = factory(App\Models\Auth\User::class)->create();

        $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->visit('/menu');

        sleep(10); // Give the time to Angular for loading

        $this->click('btn-menu-3')
            ->click('btn-menu-enter')
            ->click('btn-menu-1')
            ->click('btn-menu-1')
            ->click('btn-menu-enter');


        sleep(3); // Give the time to Angular for loading

        $this->see('Commande - Client: #1');
    }

    public function testPagePOSMenuPunch()
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
    }
*/

}
