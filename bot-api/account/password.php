<?php
include __DIR__ . '/../init.php';

if (!isset($array["password"])) {
    echo json_encode(["valid"   => true,"message" => "No password key"]);
    exit;
}

$password = $array["password"];
wp_set_password($password, $user_id);


$response["success"] = true;

echo json_encode($response);