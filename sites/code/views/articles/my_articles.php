<h2>マイ投稿</h2>
<?php if (isset($articles)) :?>
    <?php foreach ($articles as $article): ?>
        <form action="/articles/<?php echo $article->id; ?>" method="post">
        ＞＞<a href="/articles/show/<?php echo $article->id; ?>"><?php echo $article->title; ?></a>
            <input type="hidden" name="method" value="DELETE">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars(Csrf::createCsrfToken(), ENT_QUOTES); ?>">
            <input type="submit" value="削除">
        </form>
    <?php endforeach; ?>
<?php endif; ?>
