<?php if (isset($_SESSION["errors"])):
    foreach($_SESSION["errors"] as $error):
?>
    <p style="color: red;">
        <?php echo htmlspecialchars($error, ENT_QUOTES); ?>
    </p>
<?php endforeach; 
    endif;
    unset($_SESSION["errors"]);
?>

<form action="?/articles/update/<?php echo htmlspecialchars($article["id"], ENT_QUOTES); ?>" method="post" enctype="multipart/form-data">
    <label for="title">タイトル</label><br>
    <input type="text" name="title" size="150" value="<?php echo $article["title"]; ?>"><br>
    <label for="content">本文</label><br>
    <textarea name="content" cols="149" rows="40"><?php echo $article["content"]; ?></textarea><br>
    <label for="images">画像</label><br>
    <input type="file" id="file" name="images[]" multiple><br>
        <?php if (isset($images)): ?>
            <!-- サムネイルを表示する -->
            <?php foreach ($images as $image): ?>
                <?php if ($image["is_thumbnail"]): ?>
                    <div class="main">
                        <img src="./uploads/<?php echo $image["image"]; ?>" class="main-img">
                    </div>
                    <input type="hidden" name="thumbnail_image" id="thumbnail_image" value="<?php echo htmlspecialchars($image["image"], ENT_QUOTES); ?>"/>
                <?php endif; ?>
            <?php endforeach; ?>
            <!-- 画像を表示する -->
            <div id="imagePreview">
                <ul class="thumb-list">
                    <?php foreach ($images as $image): ?>
                        <li class="thumb-item">
                            <img src="./uploads/<?php echo $image["image"]; ?>" alt="<?php echo $image["images"]; ?>" alt="mountain" class="thumb-item-img is-active">
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    <input type="hidden" name="thumbnail" id="thumbnail" />

    <label for="tags">タグ</label><br>
    <select name="tags[]" style="width: 120px;" multiple>
        <?php foreach ($all_tags as $all_tag):
        // 選択されたタグに「selected」を付与する
            $flag = 0; 
            foreach ($tags as $tag):
                if ($all_tag["tag_name"] === $tag["tag_name"]):
                    $flag = 1;
                    break; 
                endif;
            endforeach;
    
            if ($flag): ?>
                <option value="<?php echo $tag["tag_name"]; ?>" selected><?php echo $all_tag["tag_name"] ?></option>
                <p><?php echo $flag; ?></p>
            <?php else: ?>
                <option value="<?php echo $all_tag["tag_name"]; ?>"><?php echo $all_tag["tag_name"] ?></option>
            <?php endif;
        endforeach;?>
    </select><br>
    <input type="submit" class="btn-submit" value="編集する">
</form>