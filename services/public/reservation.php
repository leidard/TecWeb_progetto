<?php
require_once __DIR__.'/../../models/reservation.php';

class PublicReservationService {
    public static function getOfStaff($staff) {
        return (new Reservation())->getAllOfStaff($staff);
    }
}