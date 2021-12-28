<?php

require_once __DIR__.'/../../models/staff.php';

class StaffStaffService {
    public static function getAll() {
        return (new Staff())->getAll();
    }

    public static function get($id) {
        return (new Staff())->get($id);
    }
}