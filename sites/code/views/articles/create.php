<h2>新しい投稿作成</h2>
<form action="/articles/store" method="post" enctype="multipart/form-data">
    <label for="title">タイトル</label><br>
    <input type="text" name="title" size="150"><br>
    <label for="content">本文</label><br>
    <textarea name="content" cols="149" rows="40"></textarea><br>
    <label for="images">画像</label><br>
    <input type="file" id="file" name="images[]" multiple><br>
    <input type="hidden" name="thumbnail" id="thumbnail" />
    <div id="imagePreview"></div>
    <label for="tags">タグ</label><br>
    <select name="tags[]" multiple>
        <?php foreach ($tags as $tag): ?>
            <option value="<?php echo $tag->tag_name; ?>"><?php echo $tag->tag_name ?></option>
        <?php endforeach; ?>
    </select><br>
    <input type="submit" class="btn-submit" value="作成する">
</form>

<?php if (isset($thumbnail)) {
    echo $thumbnail;
}