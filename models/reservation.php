<?php
require_once __DIR__ . "/helper.php";

class Reservation extends DBHelper {

    public function create($star_at, $end_at, $price, $staff, $customer, $service) {
        $stmt = $this->prepare("INSERT INTO reservation(company, start_at, end_at, price, staff, customer, service) VALUES (1, ?,?,?,?,?,?)");
        $stmt->bind_param("iidisi", $star_at, $end_at, $price, $staff, $customer, $service);
         
        if (!$stmt->execute()){
            echo "Error: ". $stmt->error;
        } 
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
        $stmt = $this->prepare("SELECT start_at, end_at, confirmed, R.price as price, S.name as staff, SVC.name as service FROM scissorhands.reservation as R
            INNER JOIN staff as S ON S._id = R.staff
            INNER JOIN service as SVC ON SVC._id = R.service
            WHERE R.company = 1 AND R.confirmed = TRUE AND R.customer = ? ORDER BY start_at DESC");
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
        $stmt = $this->prepare("SELECT * FROM reservation WHERE company = 1 AND staff = ? AND start_at >= ? AND end_at <= ? AND confirmed IS TRUE ORDER BY start_at ASC");
        $stmt->bind_param("iii", $staff, $from, $to);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getRange($from, $to) {
        $stmt = $this->prepare("SELECT 
            R._id as _id, R.start_at as start_at, R.end_at as end_at, R.price as price, S.name as staff, SVC.name as service, C.name as customer_name, C.surname as customer_surname  
        FROM 
            scissorhands.reservation as R
        INNER JOIN staff as S 
            ON S._id = R.staff
        INNER JOIN service as SVC 
            ON SVC._id = R.service 
        INNER JOIN customer as C
            ON C._id = R.customer
        WHERE R.company = 1 AND start_at >= ? AND end_at <= ? AND confirmed IS TRUE ORDER BY start_at DESC");
        $stmt->bind_param("ii", $from, $to);
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
        $stmt = $this->prepare("SELECT R._id as _id, R.start_at as start_at, R.end_at as end_at, R.price as price, S.name as staff, SVC.name as service  
        FROM 
            scissorhands.reservation as R
        INNER JOIN staff as S 
            ON S._id = R.staff
        INNER JOIN service as SVC 
            ON SVC._id = R.service 
        WHERE R.company = 1 AND R.confirmed is NULL AND R.customer = ? LIMIT 1");
        $stmt->bind_param('s', $customer);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function unconfirmedCount() {
        $stmt = $this->prepare("SELECT COUNT(_id) as count FROM reservation WHERE company = 1 AND confirmed is NULL GROUP BY company");
        if (!$stmt->execute()){
            echo "Error: ". $stmt->error;
        } 
        return $stmt->get_result()->fetch_assoc();
    }

    public function getAllUnconfirmed() {
        $stmt = $this->prepare("SELECT  R._id as _id, R.start_at as start_at, R.end_at as end_at, R.price as price, S.name as staff, SVC.name as service, C.name as customer_name, C.surname as customer_surname  
        FROM 
            scissorhands.reservation as R
        INNER JOIN staff as S 
            ON S._id = R.staff
        INNER JOIN service as SVC 
            ON SVC._id = R.service 
        INNER JOIN customer as C
            ON C._id = R.customer  WHERE R.company = 1 AND R.confirmed is NULL LIMIT 1");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function deleteOfCustomer($customer, $id) {
        $stmt = $this->prepare("DELETE FROM reservation WHERE company = 1 AND customer = ? AND _id = ? AND confirmed IS NULL ");
        $stmt->bind_param('s', $customer, $id);
        $stmt->execute();
    }
}
