<?php
    class User {
        public $user_name;
        public $email;
        public $address;

        public function __construct($user_name, $email, $address)
        {
            $this->user_name = $user_name;
            $this->email = $email;
            $this->address = $address;
        }

        static function all() {
            $list = [];
            $db = DB::getInstance();
            $query = $db->query('SELECT * FROM users');

            foreach($query->fetchAll() as $item) {
                $list[] = new User($item["user_name"], $item["emai"], $item["content"]);
            }

            return $list;
        }

        static function create($user_name, $email, $address, $user_password) {
            $db = DB::getInstance();
            $statement = $db->prepare('INSERT INTO users SET user_name=?, email=?, address=?, user_password=?');
            $statement->execute([
                $user_name,
                $email,
                $address,
                sha1($user_password)
            ]);
        }

        static function loginUser($email, $password) {
            $db = DB::getInstance();
            $statement = $db->prepare('SELECT * FROM users WHERE email=? AND user_password=?');
            $statement->execute([
                $email,
                sha1($password)
            ]);
            $logged_in_user = $statement->fetch();
            return $logged_in_user;
        }
    }