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

        public function show() {
            $current_uri = $_SERVER['REQUEST_URI'];
            $current_uri_array = explode("/", $current_uri);
            $article = Article::getArticle(end($current_uri_array));

            if ($article["article"]) {
                $this->render("show", $article);
            }

            $error = ["error" => "投稿見つかれません！"];
            $this->render("show", $error);
        }
    }