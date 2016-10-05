<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class VisitTest extends TestCase
{
    /*Will redirect to login*/
    public function testBasic()
    {
        $this->visit('/')
             ->see('Login');
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

    public function testPagePlans()
    {
        $this->visit('/')
            ->click('Plans')
            ->seePageIs('/plan');
    }

    public function testPageItems()
    {
        $this->visit('/')
            ->click('Items')
            ->seePageIs('/items');
    }

    public function testPageItemTypes()
    {
        $this->visit('/')
            ->click('Item Types')
            ->seePageIs('/itemtypes');
    }

    public function testPageExtras()
    {
        $this->visit('/')
            ->click('Extras')
            ->seePageIs('/extras');
    }

    public function testPageMenuFiler()
    {
        $this->visit('/')
            ->click('Menu Filer')
            ->seePageIs('/filters');
    }

    public function testPageActivityLog()
    {
        $this->visit('/')
            ->click('Activity log')
            ->seePageIs('/activity-log');
    }

    public function testPageSettings()
    {
        $this->visit('/')
            ->click('Settings')
            ->seePageIs('/menu-settings');
    }
}
