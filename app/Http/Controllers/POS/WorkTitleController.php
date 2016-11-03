<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Models\POS\Employee;
use App\Models\POS\WorkTitle;
use App\Models\POS\Punch;
use App\Models\Project;
use App\Models\POS\TitleEmployee;
use Illuminate\Support\Facades\Input;
use App\Models\Auth\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Html\HtmlServiceProvider;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class WorkTitleController extends Controller
{
    public function index()
    {
        $workTitles = WorkTitle::getAll();
        $employeesList = Employee::GetAll();

        for($i = 0; $i < count($workTitles); $i++){
            $employees = WorkTitle::getEmployeesByTitleId($workTitles[$i]->emplTitleId);
            $workTitles[$i]->{"cntEmployees"} = $employees;
        }

        $view = \View::make('POS.WorkTitle.index')
            ->with('ViewBag', array (
                'workTitles' => $workTitles,
                'employees' => $employeesListca
            ));
        return $view;
    }


    public function raw()
    {
        $workTitles = WorkTitle::getAll();
        $employeesList = Employee::GetAll();

        for($i = 0; $i < count($workTitles); $i++){
            $employees = WorkTitle::getEmployeesByTitleId($workTitles[$i]->emplTitleId);
            $workTitles[$i]->{"cntEmployees"} = $employees;
        }

        return [ 'workTitles' => $workTitles];
    }

    public function delEmployee()
    {
        $inputs = Input::all();

        $rules = array(
            'titleEmployeeId' => 'required'
        );

        $message = array(
            'required' => 'The :attribute is required !'
        );

        $validation = \Validator::make($inputs, $rules, $message);
        if($validation -> fails())
        {
            $messages = $validation->errors();
            return \Response::json([
                'errors' => $messages
            ], 422);
        }
        else
        {

            $empl =  Employee::GetById(Input::get('emplId'));
            $emplTitle  = WorkTitle::getById(Input::get('emplTitleId'));

            TitleEmployee::where("id", "=", Input::get('titleEmployeeId'))
                ->delete();

            return \Response::json([
                'success' => "The employee has been successfully removed from the title !"
            ], 201);
        }
    }

    public function addEmployee()
    {
        $inputs = Input::all();

        $rules = array(
            'emplTitleId' => 'required',
            'emplId' => 'required'
        );

        $message = array(
            'required' => 'The :attribute is required !'
        );

        $validation = \Validator::make($inputs, $rules, $message);
        if($validation -> fails())
        {
            $messages = $validation->errors();
            return \Response::json([
                'errors' => $messages
            ], 422);
        }
        else
        {
            $checkTitleEmployee = TitleEmployee::getByEmployeeAndTitleId(Input::get('emplId'), Input::get('emplTitleId'));
            if($checkTitleEmployee == null){
                $empl =  Employee::GetById(Input::get('emplId'));
                $emplTitle  = WorkTitle::getById(Input::get('emplTitleId'));

                $titleEmployee = TitleEmployee::create([
                    'employee_id' => Input::get('emplId'),
                    'work_titles_id' => Input::get('emplTitleId')
                ]);

                $objTitleEmployee = array (
                    "id" => $titleEmployee->id,
                    "fullName" => ($empl->firstName . " " . $empl->lastName),
                    "hireDate" => $empl->hireDate
                );

                $messages = array(
                    'success' => ("The employee " . $empl->firstName . " has been successfully added to " . $emplTitle->name . " title !"),
                    'titleEmployee' => json_encode($objTitleEmployee)
                );

                return \Response::json([
                    'success' => $messages
                ], 201);

                /*return \Response::json([
                    'success' => "The employee " . $empl->firstName . " has been successfully added to " . $emplTitle->name . " title !"
                ], 201);*/
            } else {
                $messages = array(
                    "emplTitleId" => array(0 => "The selected employee is already a part of this title !")
                );

                return \Response::json([
                    'errors' => $messages
                ], 422);
            }

        }
    }

    public function postCreate()
    {
        $inputs = Input::all();

        $rules = array(
            'emplTitleName' => 'required',
            'emplTitleBaseSalary' => 'required'
        );

        $message = array(
            'required' => 'The :attribute is required !'
        );

        $validation = \Validator::make($inputs, $rules, $message);
        if($validation -> fails())
        {
            $messages = $validation->errors();
            return \Response::json([
                'errors' => $messages
            ], 422);
        }
        else
        {

            $result = WorkTitle::create([
                    'name' => Input::get('emplTitleName'),
                    'baseSalary' => Input::get('emplTitleBaseSalary')
                ]);

            $messages = array(
                'success' => ("The employee title " . Input::get('emplTitleName') . " has been successfully created !"),
                'workTitleId' => $result->id
            );

            return \Response::json([
                'success' => $messages
            ], 201);
        }
    }

    public function postEdit()
    {
        $inputs = Input::all();

        $rules = array(
            'emplTitleId' => 'required',
            'emplTitleName' => 'required',
            'emplTitleBaseSalary' => 'required'
        );

        $message = array(
            'required' => 'The :attribute is required !'
        );

        $validation = \Validator::make($inputs, $rules, $message);
        if($validation -> fails())
        {
            $messages = $validation->errors();
            return \Response::json([
                'errors' => $messages
            ], 422);
        }
        else
        {

            WorkTitle::where('id', Input::get('emplTitleId'))
            ->update([
                'name' => Input::get('emplTitleName'),
                'baseSalary' => Input::get('emplTitleBaseSalary')
            ]);

        }

        return \Response::json([
            'success' => "The employee title " . Input::get('emplTitleName') . " has been successfully edited !"
        ], 201);
    }

    public function delete($id)
    {
        $employee = Employee::GetById($id);
        $view = \View::make('POS.Employee.delete')->with('employee', $employee);
        return $view;
    }
}
