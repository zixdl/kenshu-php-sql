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
            $req = $db->query('SELECT * FROM users');

            foreach($req->fetchAll() as $item) {
                $list[] = new User($item["user_name"], $item["emai"], $item["content"]);
            }

            return $list;
        }
    }