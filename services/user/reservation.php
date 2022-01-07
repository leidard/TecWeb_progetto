<?php
require_once __DIR__.'/../../models/reservation.php';

class UserReservationService {
    public static function create($star_at, $end_at, $price, $staff, $customer, $service) {
        return (new Reservation())->create($star_at, $end_at, $price, $staff, $customer, $service);
    }

    public static function getAll($customer) {
        return (new Reservation())->getAllOfCustomer($customer);
    }

    public static function get($customer, $id) {
        return (new Reservation())->getOfCustomer($customer, $id);
    }

    public static function delete($customer, $id) {
        return (new Reservation())->deleteOfCustomer($customer, $id);
    }

    public static function getPlannedFor24hFrom($staff,  $time) {
        return (new Reservation())->getRangeOfStaff($staff, $time, $time + 86400);
    }
}