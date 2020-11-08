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
    }