<?php
require_once __DIR__."/helper.php";

class Company extends DBHelper {
    public function get() {
        $stmt = $this->prepare("SELECT * FROM company WHERE _id = 1 LIMIT 1");
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->fetch_assoc();
    }

    public function update($obj) {
        $stmt = $this->prepare("UPDATE company SET open_at = ?, close_at = ? WHERE _id = 1");
        $stmt->bind_param("i", $obj->open_at);
        $stmt->bind_param("i", $obj->close_at);
        $stmt->execute();
    }
}