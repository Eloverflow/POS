<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class WorkTitlesTest extends TestCase
{

    public function testCreateWorkTitle()
    {
        $user = factory(App\Models\Auth\User::class)->create();

        $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->visit('/work/titles')
            ->click('btnCreateNew')
            ->type('Towel Dryer', 'emplTitleName')
            ->type('0.1', 'emplTitleBaseSalary')
            ->click('btn-confirm-work-title')
            ->see('Towel Dryer');

    }

    public function testAddEmployeeToWorkTitle()
    {
        $user = factory(App\Models\Auth\User::class)->create();

        $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->visit('/work/titles')
            ->click('btn-add-employee')
            ->select(4, 'employeeSelect') //Previously created
            ->click('frmBtnAddEmpl')
            ->see('Test Testing');

    }

}
