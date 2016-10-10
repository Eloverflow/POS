<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class POSMenuTest extends TestCase
{

    public function testPagePOSMenu()
    {
        $user = factory(App\Models\Auth\User::class)->create();

        $this->actingAs($user)
            ->visit('/')
            ->click('MenuPOS')
            ->seePageIs('/menu')
            ->timeouts()->implicitWait(4000)
            ->click('btn-menu-3')
            ->click('btn-menu-enter')
            ->click('btn-menu-1')
            ->click('btn-menu-1')
            ->click('btn-menu-enter')
            ->see('Commande - Client: #1');
    }

    public function testPagePOSMenuPunch()
    {
        $user = factory(App\Models\Auth\User::class)->create();

        $this->actingAs($user)
            ->visit('/')
            ->click('MenuPOS')
            ->seePageIs('/menu')
            ->timeouts()->implicitWait(4000)
            ->click('btn-menu-3')
            ->click('btn-menu-clk')
            ->click('btn-Barmaid')
            ->see('The employee has been successfully punched in !')
            ->click('btn-menu-clk')
            ->see('The employee has been successfully punched out !');
    }


}
