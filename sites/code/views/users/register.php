<h2>ユーザー登録</h2>
<?php if (isset($errors)):
    foreach($errors as $error):
?>
    <p style="color: red;">
        <?php echo htmlspecialchars($error, ENT_QUOTES); ?>
    </p>
<?php endforeach; 
    endif;
?>
<form action="?/users/register" method="post">
    <label for="name">ニックネーム:</label><br>
    <input type="text" name="name" size="50" value="<?php echo empty($_SESSION["new_user"]["name"])?"":htmlspecialchars($_SESSION["new_user"]["name"], ENT_QUOTES); ?>"><br>
    <label for="email">メールアドレス:</label><br>
    <input type="text" name="email" size="50" value="<?php echo empty($_SESSION["new_user"]["email"])?"":htmlspecialchars($_SESSION["new_user"]["email"], ENT_QUOTES); ?>"><br>
    <label for="address">アドレス:</label><br>
    <input type="text" name="address" size="50" value="<?php echo empty($_SESSION["new_user"]["address"])?"":htmlspecialchars($_SESSION["new_user"]["address"], ENT_QUOTES); ?>"><br>
    <label for="password">パスワード:</label><br>
    <input type="password" name="password" size="50"><br><br>
    <input type="submit" value="入力内容を確認する">
</form>
