<?php
require_once __DIR__ . "/helper.php";

class Service extends DBHelper {

    public function create($name, $price, $duration, $desc) {
        $stmt = $this->prepare("INSERT INTO service (company, name, price, duration, description) values (1, ?, ?, ?, ?)");
        $stmt->bind_param("sdis", $name, $price, $duration, $desc);
        $stmt->execute();
    }

    public function getAll() {
        $stmt = $this->prepare("SELECT * FROM service WHERE company = 1");
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->fetch_all(MYSQLI_ASSOC);
    }

    public function get($id) {
        $stmt = $this->prepare("SELECT * FROM service WHERE company = 1 AND _id = ? LIMIT 1");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->fetch_assoc();
    }

    public function update($id, $name, $price, $duration, $desc) {
        $stmt = $this->prepare("UPDATE service SET name=?, price = ?, duration = ?, desc = ? WHERE _id = ?");
        
        $stmt->bind_param("sdis", $name, $price, $duration, $desc);

        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->prepare("DELETE FROM service WHERE _id = ?");
        $stmt->bind_param("i",  $id);
        $stmt->execute();
    }
}
