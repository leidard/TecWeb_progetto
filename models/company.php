<?php
require_once __DIR__."/helper.php";

class Company extends DBHelper {
    public function get() {
        $stmt = $this->prepare("SELECT * FROM company WHERE _id = 1 LIMIT 1");
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->fetch_assoc();
    }

    public function update($open_at, $close_at, $days) {
        $stmt = $this->prepare("UPDATE company SET open_at = ?, close_at = ?, days = ? WHERE _id = 1");
        $days = "$days";
        $stmt->bind_param("iis", $open_at, $close_at, $days);
        $stmt->execute();
    }
}