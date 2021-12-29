<?php

require_once __DIR__ . '/reservation.php';
require_once __DIR__ . '/service.php';
require_once __DIR__ . '/company.php';

class PublicBookService
{

    /**
     * Get Available spots for the given day
     * @param int $service: Service _id
     * @param int $staff: Staff _id
     * @param null|int $time: The time corresponding to begin of day
     */
    public static function getAvailableOfDay(int $service, int $staff, int $time)
    {
        $now = time();
        $now = $now - ($now % 1800) + 1800;
        $time = PublicCompanyService::floorDay($time);

        $s = PublicServiceService::get($service);
        if (!$s) return [];
        $company = PublicCompanyService::get();
        if (!$company) return [];
        $prenotazioni = PublicReservationService::getPlannedFor24hFrom($staff, $time);
        if (is_null($prenotazioni)) return [];


        // in variabili per comodita
        $open_at  = $time + $company["open_at"];
        $close_at = $time + $company["close_at"];
        $duration = $s["duration"];
        $window_start = $now + $company['book_after'];
        $window_end = $now + $company['book_before'];
        $days = PublicCompanyService::parseDaysSet($company["days"]);

        // if it's not open this day reject
        if (!$days[PublicCompanyService::getDayOfWeek($time)]) return [];

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
            $nSlots = floor(($close_at - $open_at) / $duration);

            for ($j = 0; $j < $nSlots; $j++, $lastT += $duration) {
                $slots[] = array(
                    "start" => $lastT,
                    "duration" => $duration,
                    "end" => $lastT + $duration,
                );
            }
        } else {
            for ($i = $open_at; $i < count($prenotazioni) && $lastT < $close_at; $i++) {
                $p = $prenotazioni[$i];

                // if the prenotation starts before the open_hour
                if ($p["start_at"] < $open_at || $p["close_at"] > $close_at) continue;

                $nSlots = floor(($p["start_at"] - $lastT) / $duration);

                for ($j = 0; $j < $nSlots; $j++, $lastT += $duration) {
                    $slots .= array(
                        "start" => $lastT,
                        "duration" => $duration,
                        "end" => $lastT + $duration,
                    );
                }

                $lastT = $p["end_at"];
            }
        }

        return $slots;
    }
}
