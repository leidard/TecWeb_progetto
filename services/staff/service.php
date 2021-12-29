<?php

require_once __DIR__.'/../../models/service.php';

class StaffServiceService {
    public static function create($name, $price, $duration, $desc) {
        return (new Service())->create($name, $price, $duration, $desc);
    }

    public static function getAll() {
        return (new Service())->getAll();
    }

    public static function get($id) {
        return (new Service())->get($id);
    }

    public static function delete($id) {
        return (new Service())->delete($id);
    }

    public static function update($id, $name, $price, $duration, $desc) {
        return (new Service())->update($id, $name, $price, $duration, $desc);
    }
}