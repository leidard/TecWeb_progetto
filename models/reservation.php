<?php
require_once __DIR__ . "/helper.php";

class Reservation extends DBHelper {

    public function create($star_at, $end_at, $price, $staff, $customer, $service) {
        if (!!$this->getUnconfirmed($customer))
            throw new Error("Order Already Present");
        $stmt = $this->prepare("INSERT INTO reservation(start_at, end_at, price, staff, customer, service) VALUES (?,?,?,?,?,?)");
        $stmt->bind_param("iid", $star_at, $end_at, $price);
        $stmt->bind_param("isi", $staff, $customer, $service);
        $stmt->execute();
    }

    /**
     * @param int $id identifier
     * @param bool $confirm 
     */
    public function confirm($id, $confirm) {
        $stmt = $this->prepare("UPDATE reservation SET confirmed = ? WHERE _id = ? AND confirmed IS NULL");
        $stmt->bind_param("ii", $confirm, $id);
        $stmt->execute();
    }

    public function getAll() {
        $stmt = $this->prepare("SELECT * FROM reservation WHERE company = 1");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function get($id) {
        $stmt = $this->prepare("SELECT * FROM reservation WHERE company = 1 AND _id = ? LIMIT 1");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function setNotes($id, $notes) {
        $stmt = $this->prepare("UPDATE reservation SET notes = ?  WHERE _id = ?");
        $stmt->bind_param("si", $notes, $id);
        $stmt->execute();
    }

    public function getAllOfCustomer($customer) {
        $stmt = $this->prepare("SELECT * FROM reservation WHERE company = 1 AND customer = ?");
        $stmt->bind_param("s", $customer);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllOfStaff($staff) {
        $stmt = $this->prepare("SELECT * FROM reservation WHERE company = 1 AND staff = ? AND end_at >= UNIX_TIMESTAMP()");
        $stmt->bind_param("i", $staff);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getRangeOfStaff($staff, $from, $to) {
        $stmt = $this->prepare("SELECT * FROM reservation WHERE company = 1 AND staff = ? AND start_at >= ? end_at <= ? AND confirmed IS TRUE");
        $stmt->bind_param("i", $staff);
        $stmt->bind_param("i", $from);
        $stmt->bind_param("i", $to);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getOfCustomer($customer, $id) {
        $stmt = $this->prepare("SELECT * FROM reservation WHERE company = 1 AND customer = ? AND _id = ? LIMIT 1");
        $stmt->bind_param('si', $customer, $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getUnconfirmed($customer) {
        $stmt = $this->prepare("SELECT * FROM reservation WHERE company = 1 AND (confirmed is NULL) AND customer = ? LIMIT 1");
        $stmt->bind_param('s', $customer);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function deleteOfCustomer($customer, $id) {
        $stmt = $this->prepare("DELETE FROM reservation WHERE company = 1 AND customer = ? AND _id = ? AND confirmed IS NULL ");
        $stmt->bind_param('s', $customer, $id);
        $stmt->execute();
    }
}
