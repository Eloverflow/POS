<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AvailabilityTest extends TestCase
{


    public function testCreateAvailability()
    {
        $user = factory(App\Models\Auth\User::class)->create();

        $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->visit('/schedule/create')
            ->type('Test Schedule', 'name')
            ->press('btnAdd')
            ->select(3, 'employeeSelect')
            ->check('chkOptAllWeek')
            ->type('10/08/2016 8:00 AM', 'startTime')
            ->type('10/08/2016 5:00 PM', 'endTime')
            ->press('btnAddEvent')
            ->see('The moment has been added succesfully !')
            ->see('8:00 - 17:00')
            ->press('btnFinish')
            ->seePageIs('/schedule')
            ->see('Test Schedule');

    }

}
