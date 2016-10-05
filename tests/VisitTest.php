<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class VisitTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasic()
    {
        $this->visit('/')
             ->see('POSIO | Login');
    }

    public function testPageStats()
    {
        $this->visit('/')
            ->click('Statistics')
            ->seePageIs('/stats');
    }

    public function testPageEmployees()
    {
        $this->visit('/')
            ->click('Employees')
            ->seePageIs('/employee');
    }

    public function testPageWorkTitles()
    {
        $this->visit('/')
            ->click('Work Titles')
            ->seePageIs('/work/titles');
    }

    public function testPageCalendar()
    {
        $this->visit('/')
            ->click('Calendar')
            ->seePageIs('/calendar');
    }

    public function testPageSchedules()
    {
        $this->visit('/')
            ->click('Schedules')
            ->seePageIs('/schedule');
    }

    public function testPageAvailability()
    {
        $this->visit('/')
            ->click('Availability')
            ->seePageIs('/availability');
    }

    public function testPageInventory()
    {
        $this->visit('/')
            ->click('Inventory')
            ->seePageIs('/inventory');
    }

    public function testPageClients()
    {
        $this->visit('/')
            ->click('Clients')
            ->seePageIs('/clients');
    }

    public function testPageMenu()
    {
        $this->visit('/')
            ->click('Menu')
            ->seePageIs('/menu');
    }
}
