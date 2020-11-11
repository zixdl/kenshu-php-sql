<?php
    class Article {
        public $id;
        public $title;
        public $content;
        public $author_id;

        public function __construct($id, $title, $content, $author_id) {
            $this->id = $id;
            $this->title = $title;
            $this->content = $content;
            $this->author_id = $author_id;
        }
    
        static function all() {
            $db = DB::getInstance();
            $query = $db->query('SELECT * FROM articles ORDER BY id DESC');
            $articles_list = [];
            foreach ($query->fetchAll() as $item) {
                $articles_list[] = new Article($item["id"], $item["title"], $item["content"], $item["author_id"]);
            }

            return $articles_list;
        }

        /*  新着の５つの投稿を取得する    */
        static function getNewArticles() {
            $db = DB::getInstance();
            $query = $db->query('SELECT * FROM articles ORDER BY id DESC LIMIT 5');
            $articles = $query->fetchAll();

            return $articles;
        }

        static function getArticle($article_id) {
            /*  投稿取得    */
            $db = DB::getInstance();
            $statement = $db->prepare('SELECT * FROM articles WHERE id=?');
            $statement->execute([$article_id]);
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $article = new Article($result["id"], $result["title"], $result["content"], $result["author_id"]);

            // /* 投稿のタグ取得   */
            $statement = $db->prepare('SELECT tag_name FROM tags INNER JOIN article_tag ON tags.id = article_tag.tag_id WHERE article_tag.article_id=?');
            $statement->execute([$article_id]);
            $tags_list = [];            
            foreach ($statement->fetchAll() as $item) {
                $tags_list[] = new Tag($item["id"], $item["tag_name"]);
            }

            /*  投稿のイメージ取得  */
            $statement = $db->prepare('SELECT images.* FROM articles INNER JOIN images ON articles.id = images.article_id WHERE articles.id=?');
            $statement->execute([$article_id]);
            $images_list = [];
            foreach ($statement->fetchAll() as $item) {
                $images_list[] = new Image($item["image"], $item["is_thumbnail"]);
            }
            $article_tags_images = ["article" => $article, "tags" => $tags_list, "images" => $images_list];

            return $article_tags_images;
        }

        /*  投稿作成    */
        static function create($title, $content, $author_id, $images, $tags = [], $thumbnail) {
            $db = DB::getInstance();
            $statement = $db->prepare('INSERT INTO articles SET title=?, content=?, author_id=?');
            $statement->execute([
                $title,
                $content,
                $author_id
            ]);
            $last_id = $db->lastInsertId();
            
            /*  article_tagテーブルに挿入する   */
            if (!empty($tags)) {
                $tags_str = "";
                foreach ($tags as $key => $value) {
                    $tags_str .= '"'.$value.'",';
                }

                $tags_str = rtrim($tags_str, ",");

                $db = DB::getInstance();
                $query = $db->query('SELECT id FROM tags WHERE tag_name IN ('.$tags_str.')');
                $tags_id_arr = $query->fetchAll();

                $db = DB::getInstance();
                
                foreach ($tags_id_arr as $tag) {
                    $statement = $db->prepare('INSERT INTO article_tag SET article_id=?, tag_id=?');
                    $statement->execute([
                        $last_id,
                        $tag["id"]
                    ]);
                }
            }

            /*  imagesテーブルに挿入する    */
            if (!empty($images)) {
                foreach ($images as $key => $image) {
                    $image_name = date("YmdHis") . $image;
                    $db = DB::getInstance();
                    /*  サムネイルイメージを先に挿入する  */
                    if ($key == $thumbnail) {
                        $statement = $db->prepare('INSERT INTO images SET image=?, is_thumbnail=1, article_id=?');
                        $statement->execute([
                        $image_name,
                        $last_id
                        ]);
                    }
                    else {
                        $statement = $db->prepare('INSERT INTO images SET image=?, is_thumbnail=0, article_id=?');
                        $statement->execute([
                        $image_name,
                        $last_id
                        ]);
                    }
                }
            }
        }

        static function update($id, $title, $content, $images, $tags = [], $thumbnail_image) {
            $db = DB::getInstance();
            $statement = $db->prepare('UPDATE articles SET title=?, content=? WHERE id = ?');
            $statement->execute([
                $title,
                $content,
                $id
            ]);
            
            /*  article_tagテーブルを更新する   */
            if (!empty($tags)) {
                $tags_str = "";
                foreach ($tags as $key => $value) {
                    $tags_str .= '"'.$value.'",';
                }

                $tags_str = rtrim($tags_str, ",");

                $query = $db->query('SELECT id FROM tags WHERE tag_name IN ('.$tags_str.')');
                $tags_id_arr = $query->fetchAll();
                
                /*  古いタグを削除する */
                $delete_tag_statement = $db->prepare('DELETE FROM article_tag WHERE article_id=?');
                $delete_tag_statement->execute([$id]);
                
                /*  article_tagテーブルを更新する */
                foreach ($tags_id_arr as $tag) {
                    $statement = $db->prepare('INSERT INTO article_tag SET article_id=?, tag_id=?');
                    $statement->execute([
                        $id,
                        $tag["id"]
                    ]);
                }
            }

            /*  古いサムネイルを削除する    */
            $update_statement = $db->prepare('UPDATE images SET is_thumbnail=0 WHERE article_id=?');
            $update_statement->execute([
                $id,
            ]);

            /*  新しいサムネイルイメージを指定する  */
            $update_statement = $db->prepare('UPDATE images SET is_thumbnail=1 WHERE article_id=? AND image=?');
            $update_statement->execute([
                $id,
                $thumbnail_image
            ]);

            /*  新しいイメージをimagesテーブルに挿入する    */
            if (!empty($images[0])) {
                foreach ($images as $key => $image) {
                    $image_name = date("YmdHis") . $image;
                    $statement = $db->prepare('INSERT INTO images SET image=?, is_thumbnail=0, article_id=?');
                    $statement->execute([
                    $image_name,
                    $id
                    ]);
                }
            }
        }


        static function getUserArticles($user_id) {
            $articles_list = [];
            $db = DB::getInstance();
            $statement = $db->prepare('SELECT articles.* FROM articles WHERE author_id=?');
            $statement->execute([$user_id]);

            foreach($statement->fetchAll() as $item) {
                $articles_list[] = new Article($item["id"], $item["title"], $item["content"], $item["author_id"]);
            }

            return $articles_list;
        }

        /** 記事の投稿者のIDを取得する   */
        static function getArticleAuthorId($article_id) {
            $db = DB::getInstance();
            $statement = $db->prepare('SELECT author_id FROM articles where id=?');
            $statement->execute([$article_id]);
            $article_author_id = $statement->fetch();

            return $article_author_id["author_id"];
        }

        static function remove($article_id) {
            $db = DB::getInstance();
            $statement = $db->prepare('DELETE FROM article_tag WHERE article_id=?');
            $statement->execute([$article_id]);

            $statement = $db->prepare('DELETE FROM images WHERE article_id=?');
            $statement->execute([$article_id]);

            $statement = $db->prepare('DELETE FROM articles WHERE id=?');
            $statement->execute([$article_id]);
        }
    }
