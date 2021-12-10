<?php

class Azienda {

    public static function get() {
        return array(
            "open_at" => 28800,
            "close_at" => 75600,
            "days" => [false, true, true, true, true, true, false],
            "book_after" => 1800,
            "book_before" => 2592000
        );
    }

    public static function update($obj) {
        if (isset($obj->open_at)) {

        }
    }
}