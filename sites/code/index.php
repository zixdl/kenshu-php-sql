<?php
    require_once('database/connection.php');

    //  アドレス欄からURIを取得する
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
    
    
    require_once('routes.php');
