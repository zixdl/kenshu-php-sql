# kenshu-php-sql
## Issues
記事の編集機能が実装出来ていますが、一つの質問があります。
もし編集する時、投稿が持っているイメージの以外、ユーザーが改めて新しイメージをアップロードし、そのうち１枚をサムネイルイメージとして指定したい場合に対しての処理がどうすればいいのか？
この場合の処理がフロントエンドの方が主ですので、まだ考えています。
## 環境構築

- httpdのポート: 6969
- phpmyadminのポート: 8080

## URLの構造

- 完璧なURIの構造: 「/index.php?/{controller}/{action}/{id}」あるいは「/?/{controller}/{action}/」
- URIの例: /index.php?/articles/show/1
例えば、Articleテーブルは以下のURIがあリます：
    - Index: /index.php?/articles
    - Show: /index.php?/articles/show/1
    - Edit: /index.php?/articles/edit/1
    - Update: /index.php?/articles/update/1
    - Delete: /index.php?/articles/delete/1

このURIを「／］に基づいて分割すると次のような配列になります。
[0 => "", 1 => "index.php?", 2 => "articles", 3 => "show", 4 => "1"]

## システムの構築
このシステムはMVC建築に基づいて構築されています。この写真みたいです。
![alt text](https://viblo.asia/uploads/010d0558-8f86-471f-898f-da3344e2849a.png)

## 下記の機能が実装出来ます
- [x] ユーザー登録
- [x] ログイン
- [x] 記事作成、編集、閲覧、削除
    - [x] 画像は複数枚アップロードすることができる
    - [x] アップロードした画像のうち1枚をサムネイル画像として指定出来る
    - [x] タグは複数指定することができる
    - [x] ログインしていないユーザーは投稿された記事を閲覧できる
   


