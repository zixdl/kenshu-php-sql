<p style="color: #294c7a; font-size: 16px; font-weight: bold"><?php echo $article->title; ?></p>
<p style="font-size: 14px;"><?php echo $article->content; ?></p>

<?php if (isset($images)): ?>
    <!-- サムネイルを表示する -->
    <?php foreach ($images as $image): ?>
        <?php if ($image->is_thumbnail): ?>
            <div class="main">
                <img src="/uploads/<?php echo $image->image ?>" class="main-img" alt="main-img">
            </div>
        <?php endif; ?>
    <?php endforeach; ?>

    <!-- 画像を表示する -->
    <ul class="thumb-list">
    <?php foreach ($images as $image): ?>
            <li class="thumb-item">
                <img src="/uploads/<?php echo $image->image; ?>" alt="<?php echo $image->image; ?>" alt="mountain" class="thumb-item-img is-active">
            </li>
    <?php endforeach; ?>
    </ul>
<?php endif; ?>

<!-- タグを表示する -->
<?php if (!empty($tags[0])): ?>
    <p><span style="background-color: #cacaca">タグ：</span>
    <?php foreach($tags as $tag): ?>
        <span style="background-color: #cfcfcf; color: #297c4a;"><?php echo $tag->tag_name; ?></span>
    <?php endforeach; ?>
    </p>
<?php endif; ?>

<a href="/articles">＜＜戻る</a> 
<?php if ($article->author_id == $_SESSION["id"]): ?>
    | <a href="/articles/<?php echo htmlspecialchars($article->id, ENT_QUOTES); ?>/edit">編集＞＞</a>
<?php endif; ?>