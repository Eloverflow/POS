<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginTest extends TestCase
{

    public function testManualLogin()
    {
        $this->visit('/')
            ->type('visiteur@mirageflow.com', 'email')
            ->type('Visiteur!', 'password')
            ->press('btn-login')
            ->seePageIs('/');

    }

}
