<?php

require_once ('Parking.php');

$parking = new Parking();
$res = $parking->save_history($_POST['parking_id'], $_POST['data']);

echo json_encode([
    'status' => true,
    'data' => $res
]);



