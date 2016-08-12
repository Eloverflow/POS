<?php
/*
    |--------------------------------------------------------------------------
    | Detect Active Route
    |--------------------------------------------------------------------------
    |
    | Compare given route with current route and return output if they match.
    | Very useful for navigation, marking if the link is active.
    |
    */
function isActiveRoute($uri='')
{
    $active = '';

    if (Request::is(Request::segment(1) . '/' . $uri . '/*') || Request::is(Request::segment(1) . '/' . $uri) || Request::is($uri))
    {
        $active = 'active';
    }

    return $active;
}

/*
|--------------------------------------------------------------------------
| Detect Active Routes
|--------------------------------------------------------------------------
|
| Compare given routes with current route and return output if they match.
| Very useful for navigation, marking if the link is active.
|
*/
function areActiveRoutes(Array $routes = [''])
{
    foreach ($routes as $route) {

        if (Request::is(Request::segment(1) . '/' . $route . '/*') || Request::is(Request::segment(1) . '/' . $route) || Request::is($route))
        {
            return 'active';
        }

    }
}

/*
|--------------------------------------------------------------------------
| Detect Active Collapse In for menu
|--------------------------------------------------------------------------
|
| Compare given routes with current route and return output if they match.
| Very useful for navigation, marking if the link is active.
|
*/
function isCollapseIn(Array $routes = [''])
{
    foreach ($routes as $route) {

        if (Request::is(Request::segment(1) . '/' . $route . '/*') || Request::is(Request::segment(1) . '/' . $route) || Request::is($route))
        {
            return 'in';
        }

    }
}
