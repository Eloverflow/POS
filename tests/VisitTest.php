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

    public function testLogin()
    {
        $this->visit('/')
            ->type('visiteur@mirageflow.com', 'email')
            ->type('Visiteur!', 'password')
            ->press('btn-login')
            ->seePageIs('/');

    }

    public function testPageStats()
    {
        $user = factory(App\Models\Auth\User::class)->create();

        $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->visit('/')
            ->click('Statistics')
            ->seePageIs('/stats');
    }

    public function testPageEmployees()
    {
        $user = factory(App\Models\Auth\User::class)->create();

        $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->visit('/')
            ->click('Employees')
            ->seePageIs('/employee');

    }

    public function testPageWorkTitles()
    {
        $user = factory(App\Models\Auth\User::class)->create();

        $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->visit('/')
            ->click('Work Titles')
            ->seePageIs('/work/titles');
    }

    public function testPageCalendar()
    {
        $user = factory(App\Models\Auth\User::class)->create();

        $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->visit('/')
            ->click('Calendar')
            ->seePageIs('/calendar');
    }

    public function testPageSchedules()
    {
        $user = factory(App\Models\Auth\User::class)->create();

        $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->visit('/')
            ->click('Schedules')
            ->seePageIs('/schedule');
    }

    public function testPageAvailability()
    {
        $user = factory(App\Models\Auth\User::class)->create();

        $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->visit('/')
            ->click('Availability')
            ->seePageIs('/availability');
    }

    public function testPageInventory()
    {
        $user = factory(App\Models\Auth\User::class)->create();

        $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->visit('/')
            ->click('Inventory')
            ->seePageIs('/inventory');
    }

    public function testPageClients()
    {
        $user = factory(App\Models\Auth\User::class)->create();

        $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->visit('/')
            ->click('Clients')
            ->seePageIs('/clients');
    }

    public function testPageMenu()
    {
        $user = factory(App\Models\Auth\User::class)->create();

        $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->visit('/')
            ->click('MenuPOS')
            ->seePageIs('http://pos.mirageflow.com:8000');
    }

    public function testPagePlans()
    {
        $user = factory(App\Models\Auth\User::class)->create();

        $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->visit('/')
            ->click('Plans')
            ->seePageIs('/plan');
    }

    public function testPageItems()
    {
        $user = factory(App\Models\Auth\User::class)->create();

        $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->visit('/')
            ->click('Items')
            ->seePageIs('/items');
    }

    public function testPageItemTypes()
    {
        $user = factory(App\Models\Auth\User::class)->create();

        $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->visit('/')
            ->click('Item Types')
            ->seePageIs('/itemtypes');
    }

    public function testPageExtras()
    {
        $user = factory(App\Models\Auth\User::class)->create();

        $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->visit('/')
            ->click('Extras')
            ->seePageIs('/extras');
    }

    public function testPageMenuFiler()
    {
        $user = factory(App\Models\Auth\User::class)->create();

        $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->visit('/')
            ->click('Menu Filer')
            ->seePageIs('/filters');
    }

    public function testPageActivityLog()
    {
        $user = factory(App\Models\Auth\User::class)->create();

        $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->visit('/')
            ->click('Activity log')
            ->seePageIs('/activity-log');
    }

    public function testPageSettings()
    {
        $user = factory(App\Models\Auth\User::class)->create();

        $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->visit('/')
            ->click('Settings')
            ->seePageIs('/menu-settings');
    }
}
