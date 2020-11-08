<h2>記事投稿サービス</h2>
<?php if (isset($_SESSION["current_user"])): ?>
    <p style="color: #294c7a;"><b><?php echo $_SESSION["current_user"]. "さん、こんにちは！"; ?></b></p>
<?php else: ?>
    <a href="?/author/login">Login</a> |
    <a href="?/users">All Users</a>
<?php endif; ?>