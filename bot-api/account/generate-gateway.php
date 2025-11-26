<?php
include __DIR__ . '/../init.php';


if(!isset($array["bank"])){
        echo json_encode(["message" => "No bank/gateway specified"]);
        exit;
}

$bank = $array["bank"];

$registerEndpoint = $vtupressUrl . '/wp-content/plugins/vtupress/generateAccounts.php';
$apiresponse = post($registerEndpoint, [
            'user_id' => $user_id,
            'for' => $bank
        ]);


if (is_wp_error($apiresponse)) {
    echo json_encode(["message" => "Registration request failed: " . $apiresponse->get_error_message()]);
    exit;
}
$body = wp_remote_retrieve_body($apiresponse);
$data = json_decode($body, true);

if($data != "100"){
    $response["message"] = $data;
}

$response["success"] = true;
$response["message"] = 'You can view your account number via the Account details option in the menu';

echo json_encode($response);