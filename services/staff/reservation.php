<?php
require_once __DIR__.'/../../models/reservation.php';

class StaffReservationService {

    public static function getAll() {
        return (new Reservation())->getAll();
    }

    public static function setNotes($id, $notes) {
        return (new Reservation())->setNotes($id, $notes);
    }

    public static function confirm($id) {
        return (new Reservation())->confirm($id, true);
    }

    public static function reject($id) {
        return (new Reservation())->confirm($id, false);
    }

    public static function get($id) {
        return (new Reservation())->get($id);
    }

    public static function getPlannedFor24hFrom($staff,  $time) {
        return (new Reservation())->getRangeOfStaff($staff, $time, $time + 86400);
    }
}