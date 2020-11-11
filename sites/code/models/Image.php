<?php 
    class Image {
        public $image;
        public $is_thumbnail;

        public function __construct($image, $is_thumbnail) {
            $this->image = $image;
            $this->is_thumbnail = $is_thumbnail;
        }
    }
    