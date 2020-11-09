<?php
    class Article {
        static function all() {
            $db = DB::getInstance();
            $query = $db->query('SELECT * FROM articles ORDER BY id DESC');
            $articles = $query->fetchAll();

            return $articles;
        }

        static function getNewArticles() {
            $db = DB::getInstance();
            $query = $db->query('SELECT * FROM articles ORDER BY id DESC LIMIT 5');
            $articles = $query->fetchAll();

            return $articles;
        }

        static function getArticle($id) {
            //  投稿取得
            $db = DB::getInstance();
            $statement = $db->prepare('SELECT * FROM articles WHERE id=?');
            $statement->execute([$id]);
            $article = $statement->fetch();

            // 投稿のタグ取得
            $db = DB::getInstance();
            $statement = $db->prepare('SELECT tag_name FROM tags INNER JOIN article_tag ON tags.id = article_tag.tag_id WHERE article_tag.article_id=?');
            $statement->execute([$id]);
            $tags = $statement->fetchAll();

            //  投稿のイメージ取得
            $db = DB::getInstance();
            $statement = $db->prepare('SELECT images.* FROM articles INNER JOIN images ON articles.id = images.article_id WHERE articles.id=?');
            $statement->execute([$id]);
            $images = $statement->fetchAll();

            $article_tags_images = ["article" => $article, "tags" => $tags, "images" => $images];

            return $article_tags_images;
        }

        //  投稿作成
        static function create($title, $content, $author_id, $images, $tags = [], $thumbnail) {
            $db = DB::getInstance();
            $statement = $db->prepare('INSERT INTO articles SET title=?, content=?, author_id=?');
            $statement->execute([
                $title,
                $content,
                $author_id
            ]);
            $last_id = $db->lastInsertId();
            
            //  article_tagテーブルに挿入する
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

            //  imagesテーブルに挿入する
            if (!empty($images)) {
                foreach ($images as $key => $image) {
                    $image_name = date("YmdHis") . $image;
                    if ($key == $thumbnail) {
                        $db = DB::getInstance();
                        $statement = $db->prepare('INSERT INTO images SET image=?, is_thumbnail=1, article_id=?');
                        $statement->execute([
                        $image_name,
                        $last_id
                        ]);
                    }
                    else {
                        $db = DB::getInstance();
                        $statement = $db->prepare('INSERT INTO images SET image=?, is_thumbnail=0, article_id=?');
                        $statement->execute([
                        $image_name,
                        $last_id
                        ]);
                    }
                }
            }
        }
    }
