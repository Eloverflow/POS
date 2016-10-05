<?php

namespace App\Http\Controllers;

use App\Models\Auth\User;
use App\Models\ERP\Extra;
use App\Models\ERP\Item;
use App\Models\POS\Command;
use App\Models\POS\Employee;
use App\Models\POS\Filter;
use App\Models\POS\Sale;
use App\Models\POS\TitleEmployee;
use App\Models\POS\WorkTitle;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends Controller
{
    /**
     * Search the products table.
     *
     * @param  Request $request
     * @return mixed
     */
    public function search(Request $request)
    {
        // First we define the error message we are going to show if no keywords
        // existed or if no results found.
        $error = ['error' => 'No query found.'];

        $articles = array();

        // Making sure the user entered a keyword.
        if($request->has('q')) {
            $error = ['error' => 'No results found, please try with different keywords.', 'q' => $request->get('q')];

            $employees = Employee::search($request->get('q'))->get();
            $articles["employee"] = $employees;

            $users = User::search($request->get('q'))->get();
            $articles["user"] = $users;

            $workTitleEmployees = WorkTitle::search($request->get('q'))->get();
            $articles["work_title"] = $workTitleEmployees;

            $commands = Command::search($request->get('q'))->get();
            $articles["command"] = $commands;

            $sales = Sale::search($request->get('q'))->get();
            $articles["sale"] = $sales;

            $items = Item::search($request->get('q'))->get();
            $articles["item"] = $items;
            
            $extras = Extra::search($request->get('q'))->get();
            $articles["extra"] = $extras;
            
            $filters = Filter::search($request->get('q'))->get();
            $articles["filter"] = $filters;


            // If there are results return them, if none, return the error message.
            return count($articles) ? view('search.index',compact('articles')) : $error;

        }

        // Return the error message if no keywords existed
        return $error;

    }
}