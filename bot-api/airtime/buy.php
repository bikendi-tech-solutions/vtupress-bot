<?php
include __DIR__ . '/../init.php';


//{"valid":true,"data":{"network_id":"1","network_name":"MTN","airtime_type":"1","airtime_type_name":"VTU","amount":"50","phone":"55543545545","pin":"4453"}}
$request = $array['data'];

$requiredFields = ["network_id", "network_name", "airtime_type", "airtime_type_name", "amount", "phone", "pin"];

foreach ($requiredFields as $field) {
    if (empty($array['data'][$field])) {
        $response["message"] = "Missing required field: $field";
        echo json_encode($response);
        exit;
    }
}

$network_id = sanitize_text_field($array['data']['network_id']);
$airtime_type = sanitize_text_field($array['data']['airtime_type']);
$amount = sanitize_text_field($array['data']['amount']);
$phone = sanitize_text_field($array['data']['phone']);
$pin = sanitize_text_field($array['data']['pin']);

$original_pin = vp_getuser($user_id, 'vp_pin', true);
if ($pin != $original_pin) {
    $response["message"] = "Wrong Pin";
    echo json_encode($response);
    exit;
}


$original_api = vp_getuser($user_id, 'vr_id', true);
if (strtolower($original_api) == 'null' || strtolower($original_api) == 'false') {
    vp_updateuser($user_id, 'vr_id', uniqid());
    $original_api = vp_getuser($user_id, 'vr_id', true);
}

$registerEndpoint = $vtupressUrl . '/wp-content/plugins/vprest/';
$apiresponse = post($registerEndpoint, [
    'q' => 'airtime',
    'id' => $user_id,
    'apikey' => $original_api,
    'phone' => $phone,
    'amount' => $amount,
    'network' => $network_id,
    'type' => $airtime_type
]);


if (is_wp_error($apiresponse)) {
    $response["message"] = "Registration request failed: " . $apiresponse->get_error_message();
    echo json_encode($response);
    exit;
}
$body = wp_remote_retrieve_body($apiresponse);
$data = json_decode($body, true);

if (!isset($data["status"]) || !isset($data["Successful"]) || $data["status"] != "100" || $data["Successful"] != "true") {
    error_log("Airtime Purchase failed: " . $body);
    $errorMessage = isset($data["message"]) ? $data["message"] : "Purchase failed";
    $response["success"] = false;
    $response["message"] = $errorMessage;
    echo json_encode($response);
    exit;
}

$response['data'] = [
    'success' => true,
    'message' => '',
    'transaction_id' => isset($data["request_id"]) ? $data["request_id"] : 'not_applied',
    'network' => strtoupper($request['network_name']),
    'type' => strtoupper($request['airtime_type_name']),
    'amount' => floatval($request['amount']),
    'charged' => isset($data["Amount_Charged"]) ? $data["Amount_Charged"] : floatval($request['amount']),
    'recipient' => $request['phone'],
    'previous_balance' => isset($data["Previous_Balance"]) ? $data["Previous_Balance"] : '--',
    'balance' => $data["Current_Balance"]
];

echo json_encode($response);

