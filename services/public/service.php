<?php

require_once __DIR__.'/../../models/service.php';

class PublicServiceService {
    public static function getAll() {
        return (new Service())->getAll();
    }

    public static function get($id) {
        return (new Service())->get($id);
    }
}