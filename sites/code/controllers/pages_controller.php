<?php
    require_once("controllers/base_controller.php");
    require_once("models/Article.php");

    class PagesController extends BaseController {
        public function __construct() {
            $this->folder = "pages";
        }

        public function home() {
            session_start();
            $articles = Article::getNewArticles();
            $articles = ["articles" => $articles];

            $this->render("home", $articles);
        }

        public function error() {
            $this->render("error");
        }
    }