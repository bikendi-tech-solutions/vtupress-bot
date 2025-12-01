<?php
include __DIR__ . '/../init.php';

if (!isset($array["pin"])) {
    echo json_encode(["valid"   => true,"message" => "No pin key"]);
    exit;
}

$pin = $array["pin"];
vp_updateuser( $user_id,"vp_pin", $pin);

$response["success"] = true;
echo json_encode($response);