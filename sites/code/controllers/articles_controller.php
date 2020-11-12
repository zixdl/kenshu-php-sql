<?php
    require_once("controllers/base_controller.php");
    require_once("models/Article.php");
    require_once("models/Tag.php");
    require_once("models/Image.php");
    require_once("helpers/articles_helper.php");

    class ArticlesController extends BaseController {
        public function __construct() {
            $this->folder = "articles";
        }

        /*  全部の投稿を取得する    */
        public function index() {
            $this->render("index", ["articles" => Article::all()]);
        }

        /*  新しい投稿を作成する    */
        public function create() {
            if (empty($_SESSION["id"])) {
                header("Location: /users/login");
                exit();
            }

            $tags = ["tags" => Tag::all()];
            $this->render("create", $tags);
        }

        public function store() {
            /*  フォームの入力をチェックする    */
            if (!empty($_POST)) {
                $form_error = ArticleHelper::formValidate($_POST, $_FILES);

                /*  入力したフォームにエラーがあるかどうかチェックする */
                if (empty($form_error)) {
                    /*  投稿を作成する  */
                    Article::create(
                        $_POST["title"],
                        $_POST["content"],
                        $_SESSION["id"],
                        $_FILES["images"]["name"],
                        $_POST["tags"],
                        $_POST["thumbnail"]
                    );

                    /*  ファイルをアプロードする    */
                    $count = 0;
                    foreach ($_FILES["images"]["name"] as $file) {
                        $image_name = date("YmdHis") . $file;
                        $filePath = "./uploads/". $image_name;
                        move_uploaded_file($_FILES["images"]["tmp_name"][$count], $filePath);
                        $count += 1;
                    }

                    $_SESSION["message"] = "投稿作成完了しました！";
                    header("Location: /articles");
                    exit();
                }
            }            
            /*  入力したフォームにエラーがある場合、再入力を求める  */
            unset($_FILES["images"]["name"][0]);
            $return_data = ["form_errors" => $form_error, "tags" => Tag::all()];

            $this->render("create", $return_data);
        }

        public function show() {
            /*  アドレス欄から投稿のidを取得する    */
            $current_uri = $_SERVER['REQUEST_URI'];
            $current_uri_array = explode("/", $current_uri);
            $article_info = Article::getArticle(end($current_uri_array));
            
            /** このidに応じて投稿があるかどうかをチェックする */
            if ($article_info["article"]->id) {
                $this->render("show", $article_info);
            }

            /** 投稿がない場合、エラーを返す */
            $error = ["error" => "投稿見つかれません！"];
            $this->render("show", $error);
        }

        public function edit() {
            /*  アドレス欄から投稿のidを取得する    */
            $current_uri = $_SERVER['REQUEST_URI'];
            $current_uri_array = explode("/", $current_uri);
            $article_id = $current_uri_array[count($current_uri_array) - 2];

            if ($_SESSION["id"] == Article::getArticleAuthorId($article_id)) {
                $article_info = Article::getArticle($article_id);
                $article_info["all_tags"] = Tag::all();
                if ($article_info["article"]->id) {
                    $this->render("edit", $article_info);
                    exit;
                }
                $error = ["error" => "投稿見つかれません！"];

                $this->render("show", $error);
                exit;
            }
            
            $_SESSION["errors"] =  ["error" => "更新権利ありません！"];

            header("Location: /");
            exit();
        }

        public function update() {
            $current_uri = $_SERVER['REQUEST_URI'];
            $current_uri_array = explode("/", $current_uri);

            if (!empty($_POST)) {
                /*  フォームの入力をチェックする    */
                $form_error = ArticleHelper::formValidate($_POST, $_FILES);
                /*  サムネイルイメージを指定する    */
                $thumbnail_image = end(explode("/", $_POST["thumbnail_image"]));

                /*  フォームのエラーをチェックする  */
                if (empty($form_error)) {
                    /*  新しいイメージを選択したら、ファイルをアプロードする    */
                    if (!empty($_FILES["images"]["name"][0])){
                        $count = 0;
                        foreach ($_FILES["images"]["name"] as $file) {
                            $image_name = date("YmdHis") . $file;
                            $filePath = "./uploads/". $image_name;
                            move_uploaded_file($_FILES["images"]["tmp_name"][$count], $filePath);
                            $count += 1;
                        }
                    }

                    Article::update(
                        end($current_uri_array),
                        $_POST["title"],
                        $_POST["content"],
                        $_FILES["images"]["name"],
                        $_POST["tags"],
                        $thumbnail_image
                    );
                    $_SESSION["message"] = "投稿編集完了しました！";

                    header("Location: /articles/".end($current_uri_array));
                    exit();
                }
            }
            $_SESSION["errors"] = $form_error;
            unset($_FILES["images"]["name"][0]);
            header("Location: /articles/".end($current_uri_array)."/edit");
            exit();
        }

        public function my_articles() {            
            /*  ユーザーが投稿した記事を取得する    */
            if (!empty($_SESSION["id"])) {
                $articles = Article::getUserArticles($_SESSION["id"]);
                if (!empty($articles)) {
                    $this->render("my_articles", ["articles" => $articles]);
                }

                $this->render("my_articles", ["error" => "投稿ありません！"]);
                exit;
            }
            
            header("Location: /users/login");
            exit();
        }

        public function destroy() {
            $current_uri = $_SERVER['REQUEST_URI'];
            $current_uri_array = explode("/", $current_uri);

            /* 削除の権利があるかどうかをチェックする  */
            if ($_SESSION["id"] == Article::getArticleAuthorId(end($current_uri_array))) {
                Article::remove(end($current_uri_array));
                $_SESSION["message"] = "投稿が削除されました!";
                header("Location: /articles/my_articles");
                exit();
            }

            $_SESSION["message"] = "削除権利ありません！";
            header("Location: /articles/my_articles");
            exit();
        }
    }