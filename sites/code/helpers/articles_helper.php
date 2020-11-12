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
    }