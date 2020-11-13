<?php
    /*  アドレス欄からURIを取得する */
    $uri = $_SERVER['REQUEST_URI'];
    $uri_array = explode("/", $uri);
    if (!empty($uri_array[1])) {
        $controller = $uri_array[1];        
        if (!empty($uri_array[2])) {
            if (intval($uri_array[2])) {
                if ($_POST["method"] == "PUT") {
                    $action = "update";
                }
                elseif ($_POST["method"] == "DELETE") {
                    $action = "destroy";
                }
                else {
                    $action = $uri_array[3]=="edit"?"edit":"show";
                }
            }
            else {
                $action = $uri_array[2];
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
    
    $controllers = [
        "pages" => ["home", "error"],
        "users" => ["index","login", "register", "check", "thank", "logout"],
        "author" => ["login", "register", "check", "thank", "logout"],
        "articles" => ["index", "create", "store", "show", "edit", "update", "my_articles", "destroy"]
    ];

    if (!array_key_exists($controller, $controllers) || !in_array($action, $controllers[$controller])) {
        $controller = "pages";
        $action = "error";
    }

    /*  コントローラファイルの構造：「コントローラ名_controller.php」   */
    session_start();
    include_once("controllers/". $controller . "_controller.php");
    $class = str_replace("_", "", ucwords($controller, "-")). "Controller";
    $controller = new $class;
    $controller->$action();
