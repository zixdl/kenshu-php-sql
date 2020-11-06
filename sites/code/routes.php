<?php
    $controllers = [
        "pages" => ["home", "error"],
        "users" => ["index"]
    ];

    if (!array_key_exists($controller, $controllers) || !in_array($action, $controllers[$controller])) {
        $controller = "pages";
        $action = "error";
    }

    include_once("controllers/". $controller . "_controller.php");
    $class = str_replace("_", "", ucwords($controller, "-")). "Controller";
    $controller = new $class;
    $controller->$action();