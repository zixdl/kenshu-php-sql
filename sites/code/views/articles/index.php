<?php foreach ($articles as $article): ?> 
    <p><a href="?/articles/<?php echo $article["id"]; ?>" style="color: #294c7a; text-decoration: none;">　＞＞　<?php echo $article["title"]; ?></a></p><br>
<?php endforeach; ?>
