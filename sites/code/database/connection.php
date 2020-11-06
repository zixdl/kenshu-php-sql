<?php
    require_once("config/environment.php");

    class DB {
        private static $instance = NULL;
        
        public static function getInstance() {
            if (!isset(self::$instance)) {
                try {
                    self::$instance = new PDO(DB_DSN, DB_USER_NAME, DB_USER_PASSWORD);
                }
                catch (PDOException $e) {
                    die($e->getMessage());
                }
            }
            return self::$instance;
        }
    }