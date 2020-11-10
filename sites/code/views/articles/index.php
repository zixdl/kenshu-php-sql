<?php if (isset($message)): ?>
    <h3><?php echo $message; ?></h3>
<?php endif; ?>

<?php foreach ($articles as $article): ?> 
    <p><a href="?/articles/show/<?php echo $article["id"]; ?>" style="color: #294c7a; text-decoration: none;">　＞＞　<?php echo $article["title"]; ?></a></p><br>
<?php endforeach; ?>
