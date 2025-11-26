<?php
include __DIR__ . '/../init.php';


//{"valid":true,"data":{"network_id":"1","network_name":"MTN","cable_type":"1","cable_type_name":"VTU","amount":"50","phone":"55543545545","pin":"4453"}}
$request = $array['data'];

//network_id is the gotv,dstv and co 
//cable_type is the plan id
$requiredFields = ["network_id", "network_name", "cable_type", "cable_type_name", "phone", "pin"];

foreach ($requiredFields as $field) {
    if (empty($array['data'][$field])) {
        $response["message"] = "Missing required field: $field";
        echo json_encode($response);
        exit;
    }
}

$network_id = sanitize_text_field($array['data']['network_id']);
$cable_type = sanitize_text_field($array['data']['cable_type']);
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
    'q' => 'cable',
    'id' => $user_id,
    'apikey' => $original_api,
    'iuc' => $phone,
    'plan' => $cable_type,
    'type' => $network_id
]);


if (is_wp_error($apiresponse)) {
    $response["message"] = "Registration request failed: " . $apiresponse->get_error_message();
    echo json_encode($response);
    exit;
}
$body = wp_remote_retrieve_body($apiresponse);
$data = json_decode($body, true);

if (!isset($data["Status"]) || !isset($data["Successful"]) || $data["Status"] != "100" || $data["Successful"] != "true") {
    error_log("cable Purchase failed: " . $body);
    $errorMessage = isset($data["message"]) ? $data["message"] : "Purchase failed $body";
    $response["success"] = false;
    $response["message"] = $errorMessage;
    echo json_encode($response);
    exit;
}

$response['data'] = [
    'success' => true,
    'message' => '',
    'transaction_id' => isset($data["request_id"]) ? $data["request_id"] : 'not_applied',
    'network' => strtoupper($request['network_id']),
    'plan' => $data["Cable_Plan"],
    'recipient' => $request['phone'],
    'amount' => floatval($request['amount']),
    'previous_balance' => isset($data["Previous_Balance"]) ? $data["Previous_Balance"] : '--',
    'charged' => isset($data["Amount_Charged"]) ? $data["Amount_Charged"] : floatval($request['amount']),

    'balance' => $data["Current_Balance"]
];

echo json_encode($response);