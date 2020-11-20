<?php
    class User {
        public $id;
        public $user_name;
        public $email;
        public $address;
        public $session_key;
        public $cookie_expires;

        public function __construct($id, $user_name, $email, $address, $session_key=null, $cookie_expires=null)
        {
            $this->id = $id;
            $this->user_name = $user_name;
            $this->email = $email;
            $this->address = $address;
            $this->session_key = $session_key;
            $this->cookie_expires = $cookie_expires;
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

        static function checkLoginUser($email, $password) {
            $db = DB::getInstance();
            $statement = $db->prepare('SELECT * FROM users WHERE email=? AND user_password=?');
            $statement->execute([
                $email,
                sha1($password)
            ]);

            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $logged_in_user = new User($result["id"], $result["user_name"], $result["email"], $result["address"]);
            return $logged_in_user;
        }

        static function autoLoginUser($id, $md5_email) {
            $db = DB::getInstance();
            $statement = $db->prepare('UPDATE users SET session_key=?, cookie_expires=? WHERE id=?');
            $statement->execute([
                $md5_email,
                time()+3600,
                $id,
            ]);
        }

        static function getLoginInfo($md5_email) {
            $db = DB::getInstance();
            $statement = $db->prepare('SELECT * FROM users WHERE session_key=?');
            $statement->execute([$md5_email]);
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $user = new User($result["id"], $result["user_name"], $result["email"], $result["address"], $result["session_key"], $result["cookie_expires"]);

            return $user;
        }

        static function destroySessionKey($user_id) {
            $db = DB::getInstance();
            $statement = $db->prepare('UPDATE users SET session_key=NULL, cookie_expires=NULL WHERE id=?');
            $statement->execute([$user_id]);
        }
    }