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
            ->press('btnCreateNew')
            ->type('Towel Dryer', 'emplTitleName')
            ->type('0.1', 'emplTitleBaseSalary')
            ->press('btn-confirm-work-title')
            ->see('Towel Dryer');

    }

    public function testAddEmployeeToWorkTitle()
    {
        $user = factory(App\Models\Auth\User::class)->create();

        $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->visit('/work/titles')
            ->press('btn-add-employee')
            ->select(4, 'employeeSelect') //Previously created
            ->press('frmBtnAddEmpl')
            ->see('Test Testing');

    }

}
