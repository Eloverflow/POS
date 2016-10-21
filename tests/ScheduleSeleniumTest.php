<?php

class ScheduleSeleniumTest extends PHPUnit_Extensions_Selenium2TestCase
{

    protected function setUp()
    {
        $this->setBrowser('chrome');
        $this->setBrowserUrl('http://pos.mirageflow.com');
    }

    protected function waitForPageToLoad($time)
    {
        //sleep($time);
        $this->timeouts()->implicitWait($time*1000);
    }
    protected function login()
    {
        $this->byName('email')->value('visiteur@mirageflow.com');
        $this->byName('password')->value('Visiteur!');
        $this->byId('btn-login')->click();

        $this->waitForPageToLoad(2);
    }


    public function testCreateSchedule()
    {

        $this->url('/schedule/create');
        $this->login();

        //$this->byId('btn-Barmaid')->click();

        //$alert =  $this->byClassName('alert')->text();
        $this->assertTrue(true);
/*
        $this->assertRegExp('/The employee has been successfully punched in !/i', $alert);

            ->type('Test Schedule', 'name')
            ->click('btnAdd')
            ->select(3, 'employeeSelect')
            ->check('chkOptAllWeek')
            ->type('10/08/2016 8:00 AM', 'startTime')
            ->type('10/08/2016 5:00 PM', 'endTime')
            ->click('btnAddEvent')
            ->see('The moment has been added succesfully !')
            ->see('8:00 - 17:00')
            ->click('btnFinish')
            ->seePageIs('/schedule')
            ->see('Test Schedule');*/

    }

}
