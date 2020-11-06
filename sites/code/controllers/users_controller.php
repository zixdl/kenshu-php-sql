<?php
    require_once("controllers/base_controller.php");
    require_once("models/User.php");

    class UsersController extends BaseController {
        public function __construct() {
            $this->folder = "users";
        }

        public function index() {
            $users = User::all();
            $data = ["users" => $users];
            $this->render("index", $data);
        }
    }