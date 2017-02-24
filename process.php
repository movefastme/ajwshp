<?php

require_once ('Parking.php');

$parking = new Parking();
$res = $parking->get_parking_id($_POST['car_id']);

echo json_encode([
    'status' => true,
    'return_parking_id' => $res
]);



