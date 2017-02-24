<?php

require_once ('Parking.php');

$parking = new Parking();
$res = $parking->get_detail_parking($_POST['parking_id']);

echo json_encode([
    'status' => true,
    'data' => $res
]);



