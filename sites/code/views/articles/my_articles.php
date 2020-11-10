<h2>マイ投稿</h2>
<?php if (isset($_SESSION["message"])): ?>
    <h3 style="color: #294c7a;"><?php echo $_SESSION["message"]; ?></h2>
    <?php unset($_SESSION["message"]); ?>
<?php endif; ?>
<?php if (isset($error)): ?>
<p><?php echo htmlspecialchars($error, ENT_QUOTES); ?></p>
<?php endif; ?>
<?php if (isset($articles)) :?>
    <?php foreach ($articles as $article): ?> 
        <p>＞＞<a href="?/articles/show/<?php echo $article["id"]; ?>"><?php echo $article["title"]; ?></a>| <a href="?/articles/delete/<?php echo $article["id"]; ?>" style="color: #294c7a; text-decoration: none;">削除</a></p><br>
    <?php endforeach; ?>
<?php endif; ?>