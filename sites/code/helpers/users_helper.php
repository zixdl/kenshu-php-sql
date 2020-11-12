<?php
    class UserHelper {
        static function formValidate($form_data) {
            if ($form_data["name"] == "") {   
                $form_error["name"] = "＊ ニックネーム必須";
            }
            if ($form_data["email"] == "") {
                $form_error["email"] = "＊ メールアドレス必須";
            }
            if ($form_data["address"] == "") {
                $form_error["address"] = "＊ 住所必須";
            }
            if ($form_data["password"] == "") {
                $form_error["password"] = "＊ パスワード必須";
            }
            if (strlen($form_data["password"]) < 4) {
                $form_error["password"] = "＊ パスワードを４文字以上入力してください";
            }

            return $form_error;
        }
    }