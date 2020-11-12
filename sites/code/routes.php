<?php
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
