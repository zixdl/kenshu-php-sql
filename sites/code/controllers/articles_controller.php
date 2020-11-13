<?php
    require_once "controllers/base_controller.php";
    require_once "models/Article.php";
    require_once "models/Tag.php";
    require_once "models/Image.php";
    require_once "helpers/articles_helper.php";
    require_once "config/csrf.php";

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

            $this->render("create", ["tags" => Tag::all()]);
        }

        public function store() {
            /*  CSRFトークンを確認する */
            if (!Csrf::validateCsrfToken()) {
                /*  トークンがない場合、エラーを返す  */
                die("正規の画面からご使用ください");
            }

            /*  フォームの入力をチェックする    */
            if (!empty($_POST)) {
                $form_error = ArticleHelper::formValidate($_POST, $_FILES);

                /*  入力したフォームにエラーがあるかどうかチェックする */
                if (empty($form_error)) {
                    /*  投稿を作成する  */
                    /*  トランザクションの実践が成功かどうかをチェックする    */

                    if (Article::create($_POST["title"], $_POST["content"], $_SESSION["id"], $_FILES["images"]["name"], $_POST["tags"], $_POST["thumbnail"])) {
                        /*  ファイルをアプロードする    */
                        $count = 0;
                        foreach ($_FILES["images"]["name"] as $file) {
                            $image_name = date("YmdHis") . $file;
                            $filePath = "./uploads/". $image_name;
                            move_uploaded_file($_FILES["images"]["tmp_name"][$count], $filePath);
                            $count += 1;
                        }
                        $_SESSION["message"] = "投稿作成完了しました！";                       
                    }
                    else {
                        $_SESSION["message"] = "投稿作成失敗でした！";
                    }

                    header("Location: /articles");
                    exit();
                }
            }
            unset($_FILES["images"]["name"][0]);
            $return_data = ["form_errors" => $form_error, "tags" => Tag::all()];

            $this->render("create", $return_data);
        }

        public function show() {
            $id = ArticleHelper::getIdFromURI();
            $article_info = Article::getArticle($id);
            
            /* このidに応じて投稿があるかどうかをチェックする */
            if ($article_info["article"]->id) {
                $this->render("show", $article_info);
            }

            /* 投稿がない場合、エラーを返す */
            $error = ["error" => "投稿見つかれません！"];
            $this->render("show", $error);
        }

        public function edit() {
            /*  アドレス欄から投稿のidを取得する    */
            $id = ArticleHelper::getEditIdFromURI();

            if ($_SESSION["id"] == Article::getArticleAuthorId($id)) {
                $article_info = Article::getArticle($id);
                $all_tags = Tag::all();
                if ($article_info["article"]->id) {
                    $this->render("edit", ["article" => $article_info["article"], "tags" => $article_info["tags"],
                        "images" => $article_info["images"], "all_tags" => $all_tags]);
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
            $id = ArticleHelper::getIdFromURI();            
            /*  CSRFトークンを確認する */
            if (!Csrf::validateCsrfToken()) {
                /*  トークンがない場合、エラーを返す  */
                die("正規の画面からご使用ください");
            }

            /*  フォームの入力をチェックする    */
            if (!empty($_POST)) {
                $form_error = ArticleHelper::formValidate($_POST, $_FILES);
                /*  サムネイルイメージを指定する    */
                $thumbnail_image = end(explode("/", $_POST["thumbnail_image"]));

                /*  フォームのエラーをチェックする  */
                if (empty($form_error)) {
                    /*  トランザクションの実践が成功かどうかをチェックする    */
                    if (Article::update($id, $_POST["title"], $_POST["content"], $_FILES["images"]["name"], $_POST["tags"], $thumbnail_image)) {
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
                        $_SESSION["message"] = "投稿編集完了しました！";
                    }
                    else {
                        $_SESSION["message"] = "投稿編集失敗でした！";
                    }
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
            $id = ArticleHelper::getIdFromURI();
            
            /*  CSRFトークンを確認する */
            if (!Csrf::validateCsrfToken()) {
                /*  トークンがない場合、エラーを返す  */
                die("正規の画面からご使用ください");
            }

            /* 削除の権利があるかどうかをチェックする  */
            if ($_SESSION["id"] == Article::getArticleAuthorId($id)) {
                /*  トランザクションの実践が成功かどうかをチェックする    */
                if (Article::remove($id)) {
                    $_SESSION["message"] = "投稿が削除されました!";
                    header("Location: /articles/my_articles");
                    exit();
                }

                $_SESSION["message"] = "削除できませんでした！";
                header("Location: /articles/my_articles");
                exit();               
            }

            $_SESSION["message"] = "削除権利ありません！";
            header("Location: /articles/my_articles");
            exit();
        }
    }