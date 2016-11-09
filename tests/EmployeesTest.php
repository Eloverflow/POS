<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EmployeesTest extends TestCase
{

    public function testCreateEmployees()
    {
        $user = factory(App\Models\Auth\User::class)->create();

        $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->visit('/employee/create')
            ->type('testing@mirageflow.com', 'email')
            ->type('111111', 'password')
            ->type('111111', 'password_confirmation')
            ->type('Test', 'firstName')
            ->type('Testing', 'lastName')
            ->type('111222333', 'nas')
            ->type('Rue papineau', 'streetAddress')
            ->type('111222333', 'phone')
            ->type('Bout d\'apic', 'city')
            ->type('QC', 'state')
            ->type('A0A0A0', 'pc')
            ->select([2,3], 'employeeTitles[]')
            ->type('1.50', 'bonusSalary')
            ->type('2016-01-01', 'birthDate')
            ->type('2016-01-01', 'hireDate')
            ->press('btn-create-employee')
            ->seePageIs('/employee')
            ->see('The employee has been successfully created !');

    }

    public function testEditEmployees()
    {
        $user = factory(App\Models\Auth\User::class)->create();

        $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->visit('/employee/edit/3')
            ->see('John')
            ->see('Mccormick')
            ->type('Test', 'firstName')
            ->type('Testing', 'lastName')
            ->type('111222333', 'nas')
            ->type('Rue papineau', 'streetAddress')
            ->type('111222333', 'phone')
            ->type('Bout d\'apic', 'city')
            ->type('QC', 'state')
            ->type('A0A0A0', 'pc')
            ->select([2,3], 'employeeTitles[]')
            ->type('1.80', 'bonusSalary')
            ->type('2016-01-01', 'birthDate')
            ->type('2016-01-01', 'hireDate')
            ->press('btn-edit-employee')
            ->seePageIs('/employee')
            ->see('The employee has been successfully edited !');

    }

}
