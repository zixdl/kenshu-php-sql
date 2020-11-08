<?php
    require_once('database/connection.php');

    //Get current URI
    $uri = $_SERVER['REQUEST_URI'];
    $uri_array = explode("/", $uri);

    /* 
        uriの構造: ?/{controller}/{action}
        uriの例: ?/pages/home 
    */

    //  check array's third element to get controller
    if (!empty($uri_array[2])) {
        $controller = rtrim($uri_array[2], ".php");

        //  check array's fouth element to get action
        if (!empty($uri_array[3])) {
            // check if element's value is number, if true then action is show, otherwise action is array's third element's value
            if (intval($uri_array[3])) {
                $action = "show";
            }
            else {
                $action = $uri_array[3];
            }
        }
        else {
            $action = "index";
        }
    }
    else {
        $controller = "pages";
        $action = "home";
    }
    
    require_once('routes.php');
