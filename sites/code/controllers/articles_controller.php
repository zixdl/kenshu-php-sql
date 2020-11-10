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

                if (!empty($_FILES["images"]["name"][0])) {
                    foreach ($_FILES["images"]["name"] as $file) {
                        $ext = substr($file, -3);
                        if ($ext != "jpg" && $ext != "png") {
                            $error["image"] = "＊ 写真などは「.gif」または「.jpg」の画像を指定してください";
                        }
                    }
                }

                if (empty($error)) {
                    //  ファイルをアプロードする
                    $count = 0;
                    foreach ($_FILES["images"]["name"] as $file) {
                        $image_name = date("YmdHis") . $file;
                        $filePath = "./uploads/". $image_name;
                        move_uploaded_file($_FILES["images"]["tmp_name"][$count], $filePath);
                        $count += 1;
                    }

                    //  投稿を作成する
                    Article::create(
                        $_POST["title"],
                        $_POST["content"],
                        $_SESSION["id"],
                        $_FILES["images"]["name"],
                        $_POST["tags"],
                        $_POST["thumbnail"]
                    );

                    $articles = Article::all();

                    $this->render("index", ["message" => "投稿作成完了しました！", "articles" => $articles]);
                }
            }
            
            unset($_FILES["images"]["name"][0]);
            $return_data = ["errors" => $error, "tags" => Tag::all(), "thumbnail" => $_POST["thumbnail"]];

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

        public function edit() {
            session_start();
            $current_uri = $_SERVER['REQUEST_URI'];
            $current_uri_array = explode("/", $current_uri);
            $article = Article::getArticle(end($current_uri_array));
            $article["all_tags"] = Tag::all();

            if ($article["article"]) {
                $this->render("edit", $article);
            }

            $error = ["error" => "投稿見つかれません！"];

            $this->render("show", $error);
        }

        public function update() {
            session_start();
            $current_uri = $_SERVER['REQUEST_URI'];
            $current_uri_array = explode("/", $current_uri);

            if (!empty($_POST)) {
                //  フォームをバリデーションする
                if ($_POST["title"] == "") {   
                    $error["title"] = "＊ タイトル必須";
                }
                if ($_POST["content"] == "") {
                    $error["content"] = "＊ 本文必須";
                }
                if (!empty($_FILES["images"]["name"][0])) {
                    foreach ($_FILES["images"]["name"] as $file) {
                        $ext = substr($file, -3);
                        if ($ext != "jpg" && $ext != "png") {
                            $error["image"] = "＊ 写真などは「.gif」または「.jpg」の画像を指定してください";
                        }
                    }
                }

                //  サムネイルイメージを指定する
                $thumbnail_image = end(explode("/", $_POST["thumbnail_image"]));

                //  フォームのエラーをチェックする
                if (empty($error)) {
                    Article::update(
                        end($current_uri_array),
                        $_POST["title"],
                        $_POST["content"],
                        $_FILES["images"]["name"],
                        $_POST["tags"],
                        $thumbnail_image
                    );

                    //  ファイルをアプロードする
                    $count = 0;
                    foreach ($_FILES["images"]["name"] as $file) {
                        $image_name = date("YmdHis") . $file;
                        $filePath = "./uploads/". $image_name;
                        move_uploaded_file($_FILES["images"]["tmp_name"][$count], $filePath);
                        $count += 1;
                    }

                    $_SESSION["message"] = "投稿編集完了しました！";

                    header("Location: ?/articles/show/".end($current_uri_array));
                    exit();
                }
            }

            $_SESSION["errors"] = $error;
            unset($_FILES["images"]["name"][0]);
            header("Location: ?/articles/edit/".end($current_uri_array));
            exit();
        }

        public function my_articles() {
            session_start();
            
            if (!empty($_SESSION["id"])) {
                $articles = Article::getUserArticles($_SESSION["id"]);
                if (!empty($articles)) {
                    $this->render("my_articles", ["articles" => $articles]);
                }

                $this->render("my_articles", ["error" => "投稿ありません！"]);
                exit;
            }
            
            header("Location: ?/author/login");
            exit();
        }

        public function delete() {
            session_start();
            $current_uri = $_SERVER['REQUEST_URI'];
            $current_uri_array = explode("/", $current_uri);

            if ($_SESSION["id"] == Article::getArticleAuthorId(end($current_uri_array))) {
                Article::remove(end($current_uri_array));
                $_SESSION["message"] = "投稿が削除されました!";
                header("Location: ?/articles/my_articles");
                exit();
            }

            $_SESSION["message"] = "削除権利ありません！";
            header("Location: ?/articles/my_articles");
            exit();
        }
    }