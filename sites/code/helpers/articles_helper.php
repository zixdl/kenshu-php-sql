<?php
    class ArticleHelper {
        static function formValidate($form_data, $file_data) {
            if ($form_data["title"] == "") {   
                $form_error["title"] = "＊ タイトル必須";
            }
            if ($form_data["content"] == "") {
                $form_error["content"] = "＊ 本文必須";
            }
            if (!empty($file_data["images"]["name"][0])) {
                foreach ($file_data["images"]["name"] as $file) {
                    $ext = substr($file, -3);
                    if ($ext != "jpg" && $ext != "png") {
                        $form_error["image"] = "＊ 写真などは「.gif」または「.jpg」の画像を指定してください";
                    }
                }
            }

            return $form_error;
        }

        /*  アドレス欄から投稿のidを取得する    */
        static function getIdFromURI() {
            $current_uri_array = explode("/", $_SERVER['REQUEST_URI']);

            return end($current_uri_array);
        }
        
        /*  アドレス欄から更新したい投稿のidを取得する    */
        static function getEditIdFromURI() {
            $current_uri_array = explode("/", $_SERVER['REQUEST_URI']);

            return $current_uri_array[count($current_uri_array) - 2];
        }
    }