<?php
    require_once("controllers/base_controller.php");
    require_once("models/Article.php");

    class ArticlesController extends BaseController {
        public function __construct() {
            $this->folder = "articles";
        }

        public function index() {
            $articles = Article::all();
            $data = ["articles" => $articles];

            $this->render("index", $data);
        }
    }