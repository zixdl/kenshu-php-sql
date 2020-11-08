<?php
    require_once("controllers/base_controller.php");
    require_once("models/User.php");

    class AuthorController extends BaseController {
        public function __construct() {
            $this->folder = "author";
        }

        public function login() {
            session_start();
            if (!empty($_COOKIE["email"])) {
                $_POST["email"] = $_COOKIE["email"];
                $_POST["password"] = $_COOKIE["password"];
                $_POST["save"] = "on";
            }
            if (!empty($_POST)) {
                if (!empty($_POST["email"]) && !empty($_POST["password"])) {
                    $login_user = User::loginUser(
                        $_POST["email"],
                        $_POST["password"]
                    );
                    
                    if ($login_user) {
                        //ログイン成功
                        $_SESSION["id"] = $login_user["id"];
                        $_SESSION["current_user"] = $login_user["user_name"];
                        $_SESSION["time"] = time();

                        //ログイン情報を記録する
                        if ($_POST["save"] === "on")
                        {
                            setcookie("email", $_POST["email"], time()+3600);
                            setcookie("password", $_POST["password"], time()+3600);
                        }

                        header("Location: /index.php");
                        exit();
                    }
                    else {
                        $error = ["error" => "* ログインに失敗しました。正しくご記入ください！"];
                    }
                }
                else {
                    $error = ["error" => "* メールアドレスとパスワードをご記入ください！"];
                }
            }

            if (isset($error)) {
                $this->render("login", $error);   
            }

            $this->render("login");
        }

        public function logout() {
            session_start();

            //  セッション情報を削除
            $_SESSION = [];
            if (ini_get("session.use_cookies")){
                $params = session_get_cookie_params();
                setcookie(session_name(), "", time() - 3600,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]);
            }

            session_destroy();

            //  Cookie情報も削除
            setcookie("email", "", time() - 3600);
            setcookie("password", "", time() - 3600);

            $this->render("login");
        }

        public function register() {
            session_start();
            if (!empty($_POST)) {
                if ($_POST["name"] == "") {   
                    $error["name"] = "＊ ニックネーム必須";
                }
                if ($_POST["email"] == "") {
                    $error["email"] = "＊ メールアドレス必須";
                }
                if ($_POST["address"] == "") {
                    $error["address"] = "＊ 住所必須";
                }
                if ($_POST["password"] == "") {
                    $error["password"] = "＊ パスワード必須";
                }
                if (strlen($_POST["password"]) < 4) {
                    $error["password"] = "＊ パスワードを４文字以上入力してください";
                }
                
                if (empty($error)) {
                    $_SESSION["new_user"] = $_POST;
                    $data = ["data" => $_SESSION["new_user"]];

                    $this->render("check", $data);
                }
            }

            if (isset($error)) {
                $errors = ["errors" => $error];
                $this->render("register", $errors);
            }
            
            $this->render("register");
        }

        public function thank() {
            session_start();
            if (!empty($_POST) && !empty($_SESSION["new_user"])) {
                User::create(
                    $_SESSION["new_user"]["name"],
                    $_SESSION["new_user"]["email"],
                    $_SESSION["new_user"]["address"],
                    $_SESSION["new_user"]["password"]
                );

                session_unset();

                $this->render("thank");
            }

            session_unset();
            $errors = ["errors" => ["＊　ユーザー登録失敗でした！"]];

            $this->render("register", $errors);
        }
    }
    