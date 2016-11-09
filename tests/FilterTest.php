<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FilterTest extends TestCase
{

    public function testCreateFilter()
    {
        $user = factory(App\Models\Auth\User::class)->create();

        $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->visit('/filters/create')
            ->type('Super Menu Filter', 'name')
            ->type('This is really bad', 'description')
            ->select(100, 'importance')
            ->select([1,2,3], 'items[]')
            ->select([3,4,5], 'itemtypes[]')
            ->press('btn-create-filter')
            ->seePageIs('/filters')
            ->see('was successfully created!');

    }

    public function testEditFilter()
    {
        $user = factory(App\Models\Auth\User::class)->create();


        $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->visit('/filters/edit/Souper2892')
            ->type('Super Menu Filter 2', 'name')
            ->type('This is really bad again', 'description')
            ->select(2, 'importance')
            ->select([1,2,3,4,5], 'items[]')
            ->press('btn-edit-filter')
            ->seePageIs('/filters')
            ->see('was successfully updated!');

    }

}
