<?php
require_once __DIR__.'/../../models/company.php';

class PublicCompanyService {
    public static function get() {
        return (new Company())->get();
    }
}