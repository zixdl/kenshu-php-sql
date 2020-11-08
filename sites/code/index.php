<?php
    require_once('database/connection.php');

    //Get current URI
    $uri = $_SERVER['REQUEST_URI'];
    $arr = explode("/", $uri);

    // example uri: ?/pages/home
    // check array's third element
    if (!empty($arr[2])) {
        $controller = ($arr[2]=="index.php")?"pages":rtrim($arr[2], ".php");
        // echo "controller: ".$controller ."<br>";
        if (!empty($arr[3])) {
            $action = $arr[3];
            // echo "action: ".$action;
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
