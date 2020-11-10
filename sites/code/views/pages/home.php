<h2 style="color: #294c7a;">記事投稿サービス</h2>

<h3>新着投稿</h3>
<?php foreach ($articles as $article): ?> 
    <p>＞＞<a href="?/articles/show/<?php echo $article["id"]; ?>" style="color: #294c7a; text-decoration: none;"><?php echo $article["title"]; ?></a></p><br>
<?php endforeach; ?>

<a href="?/articles">＞＞投稿一覧</a>

