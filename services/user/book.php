<?php

require_once __DIR__ . '/../../models/reservation.php';
require_once __DIR__ . '/../public/service.php';
require_once __DIR__ . '/../public/company.php';
require_once __DIR__ . '/../helpers.php';
require_once __DIR__ . '/../errors.php';

class UserBookingService {

    public static function canBook($customer) {
        return !(new Reservation())->getUnconfirmed($customer);
    }

    public static function getAll($customer) {
        return (new Reservation())->getAllOfCustomer($customer);
    }

    /**
     * Get Available spots for the given day
     * @param int $service: Service _id
     * @param int $staff: Staff _id
     * @param null|int $time: The time corresponding to begin of day
     */
    public static function getAvailableOfDay(int $service, int $staff, int $time) {
        $now = time();
        $now = $now - ($now % 1800) + 1800;
        $time = floorDay($time);

        $s = PublicServiceService::get($service);
        if (!$s) return [];
        $company = PublicCompanyService::get();
        if (!$company) return [];
        $prenotazioni = (new Reservation())->getRangeOfStaff($staff, $time, $time + 86400);
        if (is_null($prenotazioni)) return [];


        // in variabili per comodita
        $open_at  = $time + $company["open_at"];
        $close_at = $time + $company["close_at"];
        $duration = $s["duration"];
        $window_start = $now + $company['book_after'];
        $window_end = $now + $company['book_before'];
        $days = parseDaysSet($company["days"]);

        // if it's not open this day reject
        if (!$days[getDayOfWeek($time)]) return [];

        // if it's not inside the window reject
        if ($close_at < $window_start || $open_at > $window_end) {
            // se orario chiusura di quel giorno e' prima della inizio della finiestra di prenotazione
            // se orario apertura di quel giorno e' dopo della fine delle finestra di prenotazione
            return [];
        }

        // aggiusta orario inizio
        $open_at = max($window_start, $open_at);

        // aggiusta orario fine
        $close_at = min($window_end, $close_at);

        $lastT = $open_at;
        $slots = [];
        if (count($prenotazioni) === 0) {
            static::divide($slots, $open_at, $close_at, $duration);
        } else {
            for ($i = 0; $i < count($prenotazioni) && $lastT < $close_at; $i++) {
                $p = $prenotazioni[$i];

                // if the prenotation starts before the open_hour
                //if ($p["start_at"] < $open_at || $p["close_at"] > $close_at) continue;

                static::divide($slots, $lastT, $p["start_at"], $duration);

                $lastT = $p["end_at"];
            }
            static::divide($slots, $lastT, $close_at, $duration);
        }
        return $slots;
    }

    /**
     * 
     * @return array slots
     */
    private static function divide(array & $array, $from, $to, $duration) {
        $nSlots = floor(($to - $from) / $duration);
        for ($j = 0; $j < $nSlots; $j++, $from += $duration) {
            array_push($array, array(
                "start" => $from,
                "duration" => $duration,
                "end" => $from + $duration,
            ));
        }
    }

    private static function isValidSlot(int $service,int $staff,int $time) {
        $slots = static::getAvailableOfDay($service, $staff, $time);
        foreach($slots as $slot) {
            if ($slot["start"] === $time) return true;
            elseif ($slot["start"] > $time) return false;
        }
        return false;
    }

    public static function getUnconfirmed(string $customer) {
        return (new Reservation())->getUnconfirmed($customer);
    }

    public static function createReservation(string $user, int $service, int $staff, int $time) {
        $svcDoc = PublicServiceService::get($service);
        $duration = $svcDoc["duration"];
        $price = $svcDoc["price"];

        if (!static::isValidSlot($service, $staff, $time)) {
            throw new ReservationSlotsError();
        }

        if (!!(new Reservation())->getUnconfirmed($user))
            throw new ReservationPendingError();
        
        return (new Reservation())->create($time, $time + $duration, $price, $staff, $user, $service);
    }
}
