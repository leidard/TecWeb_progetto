<?php

class DBHelper {
    const HOST_DB = "db";
    const USERNAME = "root";
    const PASSWORD = "mariadb";
    const DATABASE_NAME = "scissorhands";

    private $conn;

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
        $ret = $this->conn->prepare($query);
        if (!$ret) die("prepare() failed: ". htmlspecialchars($this->conn->error));
        return $ret;
    }
}

$db = new DBHelper();