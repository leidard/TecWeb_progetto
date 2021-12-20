<?php

require_once '../../models/service.php';

class PublicServiceService {
    public static function getAll() {
        return (new Service())->getAll();
    }

    public static function get($id) {
        return (new Service())->get($id);
    }
}