<?php
require_once __DIR__ . "/helper.php";

class Staff extends DBHelper {

    public function create($name, $surname, $DoB, $sex) {
        $stmt = $this->prepare("INSERT INTO staff(name, surname, date_of_birth, sex, company) VALUES (?,?,?,?,1)");
        $stmt->bind_param("ssss", $name, $surname, $DoB, $sex);
        $stmt->execute();
    }

    public function getAll() {
        $stmt = $this->prepare("SELECT * FROM staff WHERE company = 1");
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->fetch_all(MYSQLI_ASSOC);
    }

    public function get($id) {
        $stmt = $this->prepare("SELECT * FROM staff WHERE company = 1 AND _id = ? LIMIT 1");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->fetch_assoc();
    }

    public function update($id, $name, $surname, $DoB, $sex) {
        $stmt = $this->prepare("UPDATE staff SET name=?, surname = ?, date_of_birth = ?, sex = ? WHERE _id = ?");

        $stmt->bind_param("ssss", $name, $surname, $DoB, $sex);

        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->prepare("DELETE FROM staff WHERE _id = ?");
        $stmt->bind_param("i",  $id);
        $stmt->execute();
    }
}
