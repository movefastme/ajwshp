<?php

Class Parking {

    private $conn;

    function __construct() {
        //connect DB
        $servername = "localhost";
        $username = "root";
        $password = "xitgmLwmp";
        $dbname = "parking";

// Create connection
        $conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $this->conn = $conn;
    }

    public function get_parking_id($car_id) {
        if (!$car_id) {
            return false;
        }
        $sql = "SELECT parking_id FROM parking_log WHERE car_id = '{$car_id} ORDER BY parking_id DESC LIMIT 1'";
        $result = $this->conn->query($sql);

        return mysqli_fetch_assoc($result);
    }

    public function get_detail_parking($parking_id = '') {
        if (!$parking_id) {
            return false;
        }
        $sql = "SELECT * FROM parking_log WHERE parking_id = '{$parking_id}'";
        $result = $this->conn->query($sql);

        return mysqli_fetch_assoc($result);
    }

    public function calculate_price($hour) {
        if ($hour <= 1) {
            return 0;
        } else if ($hour >= 2 && $hour <= 4) {
            return 20;
        } else {
            return (10 * ($hour - 4)) + 20;
        }
    }

    public function save_history($parking_id, $data) {
        $sql = "UPDATE parking_log SET"
                . " check_out = '{" . date('Y-m-d H:i:s') . "}'"
                . " AND price = '{$data['price']}'"
                . " AND pay = '{$data['pay']}'"
                . " AND change = '{$data['change']}"
                . " WHERE parking_id = '{$parking_id}'";
        return $this->conn->query($sql);
    }

}
