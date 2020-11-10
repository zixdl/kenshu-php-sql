<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ホーム</title>
    <link rel="stylesheet" href="./assets/style.css">
</head>
<body>
    <div style="text-align: right">
        <a href="?/pages/home">ホーム</a>
        |
        <?php if (isset($_SESSION["current_user"])): ?>
            <a style="color: #294c7a;"><b><?php echo $_SESSION["current_user"]; ?></b></a>
            |
            <a href="?/articles/my_articles">マイ投稿</a>
            |
            <a href="?/articles/create">新投稿作成</a>
            |
            <a href="?/author/logout">ログアウト</a>
        <?php else: ?>
            <a href="?/author/login">ログイン</a>
        <?php endif; ?>
    </div>
    <div class="wrapper">
        <?= @$content ?>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="./assets/index.js"></script>
</body>
</html>