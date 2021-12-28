<?php

require_once __DIR__ . '/reservation.php';
require_once __DIR__ . '/service.php';
require_once __DIR__ . '/company.php';

class PublicBookService {
    public const DAY = 86400;
    public const WEEK = 604800;

    /**
     * Get Available spots for the given day
     * @param int $service: Service _id
     * @param int $staff: Staff _id
     * @param null|int $time: The time corresponding to begin of day
     */
    public static function getAvailableOfDay(int $service, int $staff, int $time) {
        $now = time();
        $time = $time - ($time % 86400);

        $s = PublicServiceService::get($service);
        if (!$s) return [];
        $prenotazioni = PublicReservationService::getPlannedFor24hFrom($staff, $time);
        if (is_null($prenotazioni)) return [];
        $company = PublicCompanyService::get();
        if (!$company) return [];

        // in variabili per comodita
        $open_at  = $company["open_at"];
        $close_at = $company["close_at"];
        $duration = $service["duration"];
        $window_start = $now + $company['book_after'];
        $window_end = $now + $company['book_before'];
        $days = static::parseDaysSet($company["days"]);

        // if it's not open this day reject
        if (!$days[static::getDayOfWeek($time)]) return [];

        // if it's not inside the window reject

        $lastT = $open_at;
        $slots = [];
        for ($i = $open_at; $i < count($prenotazioni) && $lastT < $close_at; $i++) {
            $p = $prenotazioni[$i];
            $nSlots = floor(($p["start_at"] - $lastT) / $duration);

            for ($j = 0; $j < $nSlots; $j++, $lastT += $duration) {
                $slots.= array(
                    "start" => $lastT,
                    "duration" => $duration,
                    "end" => $lastT + $duration,
                );
            }

            $lastT = $p["end_at"];
        }
    }

    private static function getDayOfWeek(int $time) {
        return (floor($time / PublicBookService::DAY) + 4) % 7;
    }

    private static function floorDay(int $time) {
        return $time - ($time % PublicBookService::DAY);
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
