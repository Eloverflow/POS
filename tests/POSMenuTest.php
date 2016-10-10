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
            ->withSession(['foo' => 'bar'])
            ->visit('/menu');

        sleep(10); // Give the time to Angular for loading

        $this->press('btn-menu-3')
            ->press('btn-menu-enter')
            ->press('btn-menu-1')
            ->press('btn-menu-1')
            ->press('btn-menu-enter')
            ->see('Commande - Client: #1');
    }

    public function testPagePOSMenuPunch()
    {
        $user = factory(App\Models\Auth\User::class)->create();

        $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->visit('/menu');

        sleep(10); // Give the time to Angular for loading

        $this->press('btn-menu-3')
            ->press('btn-menu-clk')
            ->press('btn-Barmaid')
            ->see('The employee has been successfully punched in !')
            ->press('btn-menu-clk')
            ->see('The employee has been successfully punched out !');
    }


}
