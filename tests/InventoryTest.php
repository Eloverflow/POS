<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class InventoryTest extends TestCase
{

    public function testCreateEmployees()
    {
        $user = factory(App\Models\Auth\User::class)->create();

        $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->visit('/inventory/create')
            ->press('1')
            ->select(0, 'item_size')
            ->type(10, 'quantity')
            ->press('btn-create-employee')
            ->seePageIs('/inventory/create')
            ->see('was successfully created!');

    }

}
