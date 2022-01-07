<?php
require_once __DIR__ . '/../../models/company.php';

class PublicCompanyService {
    public const DAY = 86400;
    public const WEEK = 604800;

    public static function get() {
        return (new Company())->get();
    }
}
