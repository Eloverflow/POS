<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExtraTest extends TestCase
{

    public function testCreateExtra()
    {
        $user = factory(App\Models\Auth\User::class)->create();

        $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->visit('/extras/create')
            ->type('Super Bad Extra', 'name')
            ->type('This is really bad', 'description')
            ->select('+', 'effect')
            ->type(1000, 'value')
            ->select(1, 'avail_for_command')
            ->select([1,2,3], 'items[]')
            ->select([3,4,5], 'itemtypes[]')
            ->press('btn-create-extra')
            ->seePageIs('/extras')
            ->see('was successfully created!');

    }

    public function testEditExtra()
    {
        $user = factory(App\Models\Auth\User::class)->create();


        $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->visit('/extras/edit/Lime1047')
            ->type('Was that a lime', 'name')
            ->type('Not anymore', 'description')
            ->select('', 'effect')
            ->type(0, 'value')
            ->select(1, 'avail_for_command')
            ->select([1], 'items[]')
            ->select([3,4], 'itemtypes[]')
            ->press('btn-edit-extra')
            ->seePageIs('/extras')
            ->see('was successfully updated!');

    }

}
