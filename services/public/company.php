<?php
require_once __DIR__ . '/../../models/company.php';

class PublicCompanyService {
    public const DAY = 86400;
    public const WEEK = 604800;

    public static function get() {
        return (new Company())->get();
    }

    public static function getDayOfWeek(int $time) {
        return (floor($time / PublicCompanyService::DAY) + 3) % 7;
    }

    public static function parseDaysSet(string $days) {
        $arr = explode(',', $days);
        return [
            in_array('MON', $arr),
            in_array('TUE', $arr),
            in_array('WED', $arr),
            in_array('THU', $arr),
            in_array('FRI', $arr),
            in_array('SAT', $arr),
            in_array('SUN', $arr),
        ];

        date("H:i", time());
    }

    public static function getDayOfWeekSTR(int $time) {
        switch (static::getDayOfWeek($time)) {
            case 0:
                return "Lunedì";
            case 1:
                return "Martedì";
            case 2:
                return "Mercoledì";
            case 3:
                return "Giovedì";
            case 4:
                return "Venerdì";
            case 5:
                return "Sabato";
            case 6:
                return "Domenica";
        }
    }

    public static function floorDay(int $time) {
        return $time - ($time % PublicCompanyService::DAY);
    }
}
