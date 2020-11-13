<?php
    class Csrf {
        public $token;

        static function createCsrfToken() {
            if (empty($_SESSION["token"])) {
                $_SESSION["token"]  = bin2hex(random_bytes(32));
            }
            return $_SESSION["token"];
        }

        static function validateCsrfToken() {
            if (!empty($_POST["token"])) {
                if (hash_equals($_SESSION['token'], $_POST['token'])) {
                    return true;
                }
            }
            return false;
        }
    }