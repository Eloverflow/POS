<?php

namespace App\Http\Controllers\ERP;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Auth\User;
use App\Models\Beer;
use App\Models\ERP\Extra;
use App\Models\POS\Table;
use App\Models\POS\Command;
use App\Models\ERP\ExtraItem;
use App\Models\ERP\ExtraItemType;
use App\Models\ERP\Item;
use App\Models\ERP\ItemType;
use App\Models\POS\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;
use Redirect;
use Session;
use Spatie\Activitylog\Models\Activity;
use URL;
use Validator;

class ActivityLogController extends Controller
{

    public  function index()
    {

        $activities = Activity::all();

        foreach ($activities as $activity)
        {
            $user = User::where('id', $activity->causer_id)->first();
            $employee = Employee::where('userId', $activity->causer_id)->first();

            $attributes = $activity->properties['attributes'];

            if(!empty($attributes)){
                if(!empty($attributes['command_id'])){
                    $activity['related_command'] = Command::where('id', $attributes['command_id'])->first();
                }

                if(!empty($attributes['table_id'])){
                    $activity['related_table'] = Table::where('id', $attributes['table_id'])->first();
                }
                elseif (!empty($activity['related_command'])){
                    $activity['related_table'] = Table::where('id', $activity['related_command']['table_id'])->first();
                }
            }

            $activity['user'] = $user;
            $activity['employee'] = $employee;
        }


        return view('erp.activity.index',compact('title', 'Activity'));
    }

    public function liste()
    {

        $activities = Activity::orderBy('id', 'desc')->limit(20)->get();

        foreach ($activities as $activity)
        {
            $user = User::where('id', $activity->causer_id)->first();
            $employee = Employee::where('userId', $activity->causer_id)->first();

            $attributes = $activity->properties['attributes'];

            if(!empty($attributes)){
                if(!empty($attributes['command_id'])){
                    $activity['related_command'] = Command::where('id', $attributes['command_id'])->first();
                }

                if(!empty($attributes['table_id'])){
                    $activity['related_table'] = Table::where('id', $attributes['table_id'])->first();
                }
                elseif (!empty($activity['related_command'])){
                    $activity['related_table'] = Table::where('id', $activity['related_command']['table_id'])->first();
                }
            }

            $activity['user'] = $user;
            $activity['employee'] = $employee;
        }

        return $activities;
    }

    public function olderThan($id)
    {

        $activities = Activity::where('id', '<', $id)->orderBy('id', 'desc')->limit(20)->get();

        foreach ($activities as $activity)
        {
            $user = User::where('id', $activity->causer_id)->first();
            $employee = Employee::where('userId', $activity->causer_id)->first();

            $attributes = $activity->properties['attributes'];

            if(!empty($attributes)){
                if(!empty($attributes['command_id'])){
                    $activity['related_command'] = Command::where('id', $attributes['command_id'])->first();
                }

                if(!empty($attributes['table_id'])){
                    $activity['related_table'] = Table::where('id', $attributes['table_id'])->first();
                }
                elseif (!empty($activity['related_command'])){
                    $activity['related_table'] = Table::where('id', $activity['related_command']['table_id'])->first();
                }
            }

            $activity['user'] = $user;
            $activity['employee'] = $employee;
        }

        return $activities;
    }

    public function overId($id)
    {

        $activities = Activity::where('id', '>', $id)->get();

        if($activities != "")
        {
            foreach ($activities as $activity)
            {
                $user = User::where('id', $activity->causer_id)->first();
                $employee = Employee::where('userId', $activity->causer_id)->first();

                $attributes = $activity->properties['attributes'];

                if(!empty($attributes)){
                    if(!empty($attributes['command_id'])){
                        $activity['related_command'] = Command::where('id', $attributes['command_id'])->first();
                    }

                    if(!empty($attributes['table_id'])){
                        $activity['related_table'] = Table::where('id', $attributes['table_id'])->first();
                    }
                    elseif (!empty($activity['related_command'])){
                        $activity['related_table'] = Table::where('id', $activity['related_command']['table_id'])->first();
                    }
                }

                $activity['user'] = $user;
                $activity['employee'] = $employee;
            }
        }

        return $activities;
    }


}