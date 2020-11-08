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

            // タグ取得
            $db = DB::getInstance();
            $statement = $db->prepare('SELECT tag_name FROM tags INNER JOIN article_tag ON tags.id = article_tag.tag_id WHERE article_tag.article_id=?');
            $statement->execute([$id]);
            $tags = $statement->fetchAll();

            //  イメージ取得
            $db = DB::getInstance();
            $statement = $db->prepare('SELECT images.image as images FROM articles INNER JOIN images ON articles.id = images.article_id WHERE articles.id=?');
            $statement->execute([$id]);
            $images = $statement->fetchAll();

            $article_tags = ["article" => $article, "tags" => $tags, "images" => $images];

            return $article_tags;
        }
    }
