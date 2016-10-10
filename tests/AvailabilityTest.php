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
            ->visit('/availability/create')
            ->type('Test Availability', 'name')
            ->select(3, 'employeeSelect') //Previously created
            ->click('btnAdd')
            ->type('8:00 AM', 'startTime')
            ->type('5:00 PM', 'endTime')
            ->select(-1, 'dayNumber') //All week
            ->click('btnAddEvent')
            ->see('8:00 - 5:00')
            ->click('btnFinish')
            ->seePageIs('/availability')
            ->see('Test Availability');

    }

}
