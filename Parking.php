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
        $sql = "SELECT parking_id FROM parking_log WHERE car_id = '{$car_id}' ORDER BY parking_id DESC LIMIT 1";
        $result = $this->conn->query($sql);

        $return = mysqli_fetch_assoc($result);
        return $return['parking_id'];
    }

    public function get_detail_parking($parking_id = '') {
        if (!$parking_id) {
            return false;
        }
        $sql = "SELECT * FROM parking_log WHERE parking_id = '{$parking_id}'";
        $result = $this->conn->query($sql);


        $return = mysqli_fetch_assoc($result);
        if ($return) {
            $hour = ceil((strtotime($return['check_out']) - strtotime($return['check_in'])) / 60 / 60);
            $return['hour'] = $hour;
            $return['price'] = $this->calculate_price($hour);
        }

        return $return;
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
                . " AND price = '{$data['price']}'"
                . " AND pay = '{$data['pay']}'"
                . " AND change = '{$data['change']}"
                . " WHERE parking_id = '{$parking_id}'";
        $return = $this->conn->query($sql);

        $return['seperate_change'] = seperate_change($data['change']);
        return $return;
    }

    public function seperate_change($change) {
        $bank500 = 0;
        $bank100 = 0;
        $bank50 = 0;
        $bank20 = 0;
        $bank10 = 0;

        if ($change >= 500) {
            $bank500 = floor($change / 500);
            $change -= $change - (500 * $bank500);
        }
        if ($change >= 100) {
            $bank100 = floor($change / 100);
            $change -= $change - (100 * $bank100);
        }
        if ($change >= 50) {
            $bank50 = floor($change / 50);
            $change -= $change - (50 * $bank50);
        }
        if ($change >= 20) {
            $bank20 = floor($change / 20);
            $change -= $change - (20 * $bank20);
        }
        if ($change >= 10) {
            $bank10 = floor($change / 10);
            $change -= $change - (10 * $bank10);
        }


        return [
            'bank500' => $bank500,
            'bank100' => $bank100,
            'bank50' => $bank50,
            'bank20' => $bank20,
            'bank10' => $bank10,
        ];
    }

}
