# kenshu-php-sql
## Issues
記事の編集機能が実装出来ていますが、一つの質問があります。
もし編集する時、投稿が持っているイメージの以外、ユーザーが改めて新しイメージをアップロードし、そのうち１枚をサムネイルイメージとして指定したい場合に対しての処理がどうすればいいのか？
この場合の処理がフロントエンドの方が主ですので、まだ考えています。
## 環境構築

- httpdのポート: 6969
- phpmyadminのポート: 8080

## URLの構造
- リソースコントローラにより処理されるアクッションを実装しました。
![alt text](https://user-images.githubusercontent.com/63382767/98885166-e9da5a00-24d4-11eb-8034-6eddb880309f.png)
- 更新しましたこと:　フォームにPUTかDELETEのあるmethodというインプットを追加して、フォームをサブミットした時、このインプットをチェックするこそ、メソットはPOSTかPUTかDELETEかが判断出来ます。
これは私の解決方法です。PHPではPUTやDELETEというグローバル変数がないので、RESTfulなURIの実装が結構大変でした。他の解決方法が知っていたら、教えていただけると幸いです。


- 各URIの例:
    - Articleテーブルは以下のURIがあリます：
        - Index: /articles ----- GET
        - Show: /articles/1 ----- GET
        - Edit: /articles/1/edit ----- GET
        - Update: /articles/1 ----- PUT
        - Delete: /articles/1 ----- DELETE
        - Logged In User's Articles: /articles/my_articles
    
    - Userテーブルは下記のURIがあります:
        - Register: /users/register
        - Login: /users/login
        - Logout: /users/logout


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
   


