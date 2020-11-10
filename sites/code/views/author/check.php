<h2>情報を確認してください！</h2>
<form action="?/author/thank" method="post">
    <input type="hidden" name="submit">
    <p>ニックネーム：<b><?php echo $data["name"] ?></b></p>
    <p>メールアドレス：<b><?php echo $data["email"] ?></b></p>
    <p>住所：<b><?php echo $data["address"] ?></b></p>
    <a href="?/author/register">&laquo;&nbsp;書き直す</a> | <input type="submit" value="登録する">
</form>
