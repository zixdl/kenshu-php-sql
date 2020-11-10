<?php
    require_once('database/connection.php');

    //  アドレス欄からURIを取得する
    $uri = $_SERVER['REQUEST_URI'];
    $uri_array = explode("/", $uri);

    /* 
        完璧なURIの構造: 「/index.php?/{controller}/{action}/{id}」あるいは「/?/{controller}/{action}/」

        URIの例: /index.php?/articles/show/1
        このURIを「／］に基づいて分割すると次のような配列になります。
        [0 => "", 1 => "index.php?", 2 => "articles", 3 => "show", 4 => "1"]
    */

    /*  コントローラを取得するために、配列の３番目の要素をチェックする  */
    if (!empty($uri_array[2])) {
        $controller = $uri_array[2];
        
        /*  アクションを取得するために、配列の４番目の要素をチェックする    */
        if (!empty($uri_array[3])) {
            $action = $uri_array[3];
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
