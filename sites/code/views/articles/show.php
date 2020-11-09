<?php if (isset($error)): ?>
    <h2><?php echo $error; ?></h2>
<?php endif; ?>

<p style="color: #294c7a; font-size: 16px; font-weight: bold"><?php echo $article["title"]; ?></p>
<p style="font-size: 14px;"><?php echo $article["content"]; ?></p>

<?php if (isset($images)): ?>
    <?php foreach ($images as $image): ?>
        <?php if ($image["is_thumbnail"]): ?>
            <div class="main">
                <h3>Thumbnail</h3>
                <img src="./uploads/<?php echo $image["image"]; ?>" class="main-img" disabled>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
    <?php foreach ($images as $image): ?>
        <ul class="thumb-list">
            <li class="thumb-item">
                <img src="./uploads/<?php echo $image["image"]; ?>" alt="<?php echo $image["images"]; ?>" alt="mountain" class="thumb-item-img is-active">
            </li>
        </ul>
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