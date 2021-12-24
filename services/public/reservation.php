<?php
require_once __DIR__.'/../../models/reservation.php';

class PublicReservationService {
    public static function getPlannedOfStaff($staff) {
        return (new Reservation())->getAllOfStaff($staff);
    }
}