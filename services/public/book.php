<?php

require_once __DIR__ . '/reservation.php';
require_once __DIR__ . '/service.php';
require_once __DIR__ . '/company.php';


class PublicBookService {
    /**
     * @param int $service: Service _id
     * @param int $staff: Staff _id
     * @param null|int $time: Service _id
     */
    public static function getAvailable(int $service, int $staff, ?int $time) {
        $now = time();
        if (!$time || $time < $now) $time = time();
        $s = PublicServiceService::get($service);
        $already_reserved = PublicReservationService::getOfStaff($staff);
        $company = PublicCompanyService::get();

        $open_at  = $company["open_at"];
        $close_at = $company["close_at"];
        $not_before = $now + $company['book_after'];
        $not_after = $now + $company['book_before'];
        $days = static::parseDaysSet($company["days"]);


        $day_of_week = (floor($time / 86400) + 4) % 7;
        if ($days[$day_of_week])
    }

    private static function parseDaysSet(string $days) {
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
    }
}
