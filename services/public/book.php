<?php

require_once __DIR__ . '/reservation.php';
require_once __DIR__ . '/service.php';
require_once __DIR__ . '/company.php';


class PublicBookService {
    public const DAY = 86400;
    public const WEEK = 604800;

    /**
     * @param int $service: Service _id
     * @param int $staff: Staff _id
     * @param null|int $time: Service _id
     */
    public static function getAvailable(int $service, int $staff, ?int $time) {
        $now = time();
        if (!$time || $time < $now) $time = time();

        // fetch dei vari valori necessari per calcoli
        $s = PublicServiceService::get($service);
        $prenotazioni = PublicReservationService::getPlannedOfStaff($staff);
        $company = PublicCompanyService::get();

        // in variabili per comodita
        $open_at  = $company["open_at"];
        $close_at = $company["close_at"];
        $start_at = $service["start_at"];
        $duration = $service["duration"];
        $window_start = $now + $company['book_after'];
        $window_end = $now + $company['book_before'];
        $days = static::parseDaysSet($company["days"]);

        $lastT = $window_start;
        $slots = [];
        foreach ($prenotazioni as $p) {
            // la prenotazione risiede prima del periodo prenotabile, ignora, prosegui
            if ($p["start_at"] < $window_start) {
                $lastT = $p["end_at"];
                continue;
            }

            // la prenotazione risiede dopo del periodo prenotabile, termina;
            if ($p["close_at"] > $window_end) {
                break;
            }

            // $lastT non e' in un giorno di apertura, procediamo
            $day_of_week = static::getDayOfWeek($lastT);
            if (!$days[$day_of_week]) {
                $lastT = static::nextDay($lastT);
                continue;
            }
        }


        for ($t = $window_start; $t <= $window_end - $duration;) {
            $day_of_week = (floor($time / PublicBookService::DAY) + 4) % 7;
            if (!$days[$day_of_week]) {
            }
        }
    }

    private static function getDayOfWeek(int $time) {
        return (floor($time / PublicBookService::DAY) + 4) % 7;
    }

    private static function floorDay(int $time) {
        return $time - $time % PublicBookService::DAY;
    }

    private static function nextDay(int $time) {
        return static::floorDay($time) + PublicBookService::DAY;
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
