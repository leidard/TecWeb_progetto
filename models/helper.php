<?php

class DBHelper {
    const HOST_DB = "127.0.0.1";
    const USERNAME = "root";
    const PASSWORD = "mariadb";
    const DATABASE_NAME = "scissorhands";

    private mysqli $conn;

    public function __construct() {
        $this->conn = new mysqli(static::HOST_DB, static::USERNAME, static::PASSWORD, static::DATABASE_NAME);
        if ($this->conn->connect_error) {
            throw new Error("Database Connection Error");
        }
    }

    public function __destruct() {
        if ($this->conn) {
            $this->conn->close();
        }
    }

    public function prepare($query): mysqli_stmt {
        return $this->conn->prepare($query);
    }
}

$db = new DBHelper();