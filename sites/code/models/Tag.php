<?php
    class Tag {
        public $id;
        public $tag_name;

        public function __construct($id, $tag_name) {
            $this->id = $id;
            $this->tag_name = $tag_name;
        }
        /*  タグ取得    */
        static function all() {
            $db = DB::getInstance();
            $query = $db->query('SELECT * FROM tags ORDER BY tag_name DESC');
            $tags_list = [];
            foreach ($query->fetchAll() as $item) {
                $tags_list[] = new Tag($item["id"], $item["tag_name"]);
            }

            return $tags_list;
        }
    }
    