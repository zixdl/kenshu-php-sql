<?php
    require_once("controllers/base_controller.php");
    require_once("models/Article.php");
    require_once("models/Tag.php");

    class ArticlesController extends BaseController {
        public function __construct() {
            $this->folder = "articles";
        }

        public function index() {
            session_start();
            $articles = Article::all();
            $data = ["articles" => $articles];

            $this->render("index", $data);
        }

        public function create() {
            session_start();

            if (empty($_SESSION["id"])) {
                header("Location: ?/author/login");
            }

            $tags = ["tags" => Tag::all()];
            $this->render("create", $tags);
        }

        public function store() {
            session_start();
            if (!empty($_POST)) {
                if ($_POST["title"] == "") {   
                    $error["title"] = "＊ タイトル必須";
                }
                if ($_POST["content"] == "") {
                    $error["content"] = "＊ 本文必須";
                }
                if (!empty($_FILES["images"]["name"])) {
                    foreach ($_FILES["images"]["name"] as $file) {
                        $ext = substr($file, -3);
                        if ($ext != "jpg" && $ext != "png") {
                            $error["image"] = "＊ 写真などは「.gif」または「.jpg」の画像を指定してください";
                        }
                    }
                }

                if (empty($error)) {
                    Article::create(
                        $_POST["title"],
                        $_POST["content"],
                        $_SESSION["id"],
                        $_FILES["images"]["name"],
                        $_POST["tags"]
                    );

                    //  ファイルをアプロードする
                    $count = 0;
                    foreach ($_FILES["images"]["name"] as $file) {
                        $image_name = date("YmdHis") . $file;
                        $filePath = "./uploads/". $image_name;
                        move_uploaded_file($_FILES["images"]["tmp_name"][$count], $filePath);
                        $count += 1;
                    }
                    $articles = Article::all();

                    $this->render("index", ["message" => "投稿作成完了しました！", "articles" => $articles]);
                }
            }
            
            $return_data = ["errors" => $error, "tags" => Tag::all()];

            $this->render("create", $return_data);
        }

        public function show() {
            session_start();
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