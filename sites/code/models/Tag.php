<?php
    class Tag {
        //  タグ取得
        static function all() {
            $db = DB::getInstance();
            $query = $db->query('SELECT * FROM tags ORDER BY tag_name DESC');
            $tags = $query->fetchAll();

            return $tags;
        }

        static function getTagsId() {
            $db = DB::getInstance();
            $query = $db->query('SELECT * FROM tags ORDER BY tag_name DESC');
            $tags = $query->fetchAll();
            
            return $tags;
        }
    }