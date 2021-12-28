<?php
require_once __DIR__ . '/../../models/reservation.php';

class PublicReservationService {
    public static function getPlannedFor24hFrom($staff,  $time) {
        return (new Reservation())->getRangeOfStaff($staff, $time, $time + 86400);
    }
}
