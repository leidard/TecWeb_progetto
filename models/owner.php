<?php

class Azienda {

    public static function get() {
        return array(
            "email" => "admin",
            "password" => "admin",
        );
    }

    public static function update($obj) {
        if (isset($obj->open_at)) {

        }
    }
}