<?php
    class User {
        public $id;
        public $user_name;
        public $email;
        public $address;

        public function __construct($id, $user_name, $email, $address)
        {
            $this->id = $id;
            $this->user_name = $user_name;
            $this->email = $email;
            $this->address = $address;
        }

        static function all() {
            $list = [];
            $db = DB::getInstance();
            $query = $db->query('SELECT * FROM users');

            foreach($query->fetchAll() as $item) {
                $list[] = new User($item["id"], $item["user_name"], $item["emai"], $item["address"]);
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

            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $logged_in_user = new User($result["id"], $result["user_name"], $result["email"], $result["address"]);
            // echo $logged_in_user->user_name;
            return $logged_in_user;
        }
    }