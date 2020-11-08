<?php if (isset($error)): ?>
    <h2><?php echo $error; ?></h2>
<?php endif; ?>

<p style="color: #294c7a; font-size: 16px; font-weight: bold"><?php echo $article["title"]; ?></p>
<p><?php echo $article["content"]; ?></p>

<?php if (isset($images)): ?>
    <?php foreach ($images as $image): ?>
        <img src="uploads/<?php echo $image["images"]; ?>" alt="image<?php echo $article["id"]; ?> url" width="300" height="250"><br>
    <?php endforeach; ?>
<?php endif; ?>

<?php if (isset($tags)): ?>
    <p><span style="background-color: #cacaca">タグ：</span>
    <?php foreach($tags as $tag): ?>
        <span style="background-color: #cfcfcf; color: #297c4a;"><?php echo $tag["tag_name"] ?></span>
    <?php endforeach; ?>
    </p>
<?php endif; ?>

<a href="?/articles">＜＜戻る</a>