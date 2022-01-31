<?php
require_once __DIR__.'/../../models/company.php';
require_once __DIR__.'/../helpers.php';

class StaffCompanyService {
    public static function get() {
        return (new Company())->get();
    }

    public static function update($open_at, $close_at, array $days) {
        return (new Company())->update($open_at, $close_at, encodeDayArray($days));
    }
}