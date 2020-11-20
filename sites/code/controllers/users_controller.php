<?php
    require_once("controllers/base_controller.php");
    require_once("models/User.php");
    require_once("helpers/users_helper.php");
    require_once("config/csrf.php");

    class UsersController extends BaseController {
        public function __construct() {
            $this->folder = "users";
        }

        public function index() {
            $users = User::all();            
            $this->render("index", ["users" => $users]);
        }

        public function login() {
            /*  ユーザーがログイン情ほを記録しているかをチェックする    */
            if (!empty($_SESSION["current_user"])) {
                header("Location: /");
                exit();
            }

            if (!empty($_COOKIE["encrypted_token"])) {
                $user_info = User::getLoginInfo($_COOKIE["encrypted_email"]);
                if ($user_info->cookie_expires < time()) {
                    $_SESSION["id"] = $user_info->id;
                    $_SESSION["current_user"] = $user_info->user_name;
                    $md5_email = md5($user_info->email);
                    User::autoLoginUser($user_info->id, $md5_email);
                    setcookie("encrypted_token", $md5_email, time()+3600);

                    header("Location: /");
                    exit();
                }
            }

            /*  入力したフォームをチェックする */
            if (!empty($_POST)) {
                if (!empty($_POST["email"]) && !empty($_POST["password"])) {
                    $login_user = User::checkLoginUser(
                        $_POST["email"],
                        $_POST["password"],
                    );
                    
                    if (!empty($login_user->id)) {
                        /*  ログイン成功    */
                        $_SESSION["id"] = $login_user->id;
                        $_SESSION["current_user"] = $login_user->user_name;

                        /*  ログイン情報を記録する  */
                        if ($_POST["save"] === "on")
                        {   
                            $md5_email = md5($login_user->email);
                            User::autoLoginUser($login_user->id, $md5_email);
                            setcookie("encrypted_email", $md5_email, time()+3600);
                        }

                        header("Location: /");
                        exit();
                    }
                    /*  ログイン失敗    */
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
            /*  セッション情報を削除    */
            User::destroySessionKey($_SESSION["id"]);
            $_SESSION = [];
            if (ini_get("session.use_cookies")){
                $params = session_get_cookie_params();
                setcookie(session_name(), "", time() - 3600,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]);
            }

            session_destroy();

            /*  Cookie情報も削除    */
            setcookie("encrypted_email", "", time() - 3600);

            header("Location: /users/login");
        }

        public function register() {
            if (!empty($_POST)) {
                /*  入力したフォームをチェックする  */
                $form_error = UserHelper::formValidate($_POST);
                
                if (empty($form_error)) {
                    $_SESSION["new_user"] = $_POST;
                    $data = ["data" => $_SESSION["new_user"]];

                    $this->render("check", $data);
                }
            }

            if (isset($form_error)) {
                $this->render("register", ["form_errors" => $form_error]);
            }
            
            $this->render("register");
        }

        public function thank() {
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
