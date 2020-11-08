<h2>記事投稿サービス</h2>
<?php if (isset($_SESSION["current_user"])): ?>
    <p style="color: #294c7a;"><b><?php echo $_SESSION["current_user"]. "さん、こんにちは！"; ?></b></p>
<?php else: ?>
    <a href="?/author/login">ログインする</a> |
    <a href="?/users">ユーザー一覧</a>
<?php endif; ?>

<h3>新着投稿</h3>
<?php foreach ($articles as $article): ?> 
    <p><a href="#" style="color: #294c7a; text-decoration: none;">　＞＞　<?php echo $article["title"]; ?></a></p><br>
<?php endforeach; ?>

<a href="?/articles">＞＞投稿一覧</a>

