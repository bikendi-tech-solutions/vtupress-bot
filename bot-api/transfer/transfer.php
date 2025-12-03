<?php
include __DIR__ . '/../init.php';


$array = $array['data'];
$request = $array;
$amount = 0;
//required fields
if (isset($array["get_details"])):
    $requiredFields = ['account_number', 'bank_code'];
else:
    $requiredFields = ['account_number', 'bank_code', 'amount'];
endif;


foreach ($requiredFields as $field) {
    if (empty($array[$field])) {
        echo json_encode(["valid"   => true,"message" => "Missing required field: $field"]);
        exit;
    }
}

$account_number = sanitize_text_field($array["account_number"]);
$bank_code = sanitize_text_field($array["bank_code"]);
$amount = isset($array["amount"]) ? sanitize_text_field($array["amount"]) : 0;


$payload = [
    'action' => 'transfer',
    'account_number' => $account_number,
    'bank_code' => $bank_code,
    'amount' => $amount,
    'user_id' => $user_id
];

if (isset($array["get_details"])) {
    $payload = array_merge($payload, ['get_details' => true]);
}

//get_details

$registerEndpoint = $vtupressUrl . '/wp-content/plugins/vtupress/transfer.php';
$apiresponse = post($registerEndpoint, $payload);


if (is_wp_error($apiresponse)) {
    echo json_encode(["valid"   => true,"message" => "Request failed: " . $apiresponse->get_error_message()]);
    exit;
}
$body = wp_remote_retrieve_body($apiresponse);
$data = json_decode($body, true);

if (isset($array["get_details"])) {
    if (isset($data['success']) && $data['success']) {
        $response["success"] = true;
        $response["name"] = $data["name"];
    } else {
        $response["success"] = false;
        $response["message"] = "Account Number Is Invalid";
    }

    echo json_encode($response);
        exit;

}

if(!isset($data['status'])){
    echo json_encode(["valid"   => true,"message" => "Transfer not successful. Please try again later"]);
    exit;
}
elseif($data['status'] != "success"){
    echo json_encode(["valid"   => true,"message" => "Transfer not successful. Please try again later"]);
    exit;
}


$response['data'] = [
    'success' => true,
    'message' => '',
    'bank_name' => strtoupper($request['bank_name']),
    'amount' => number_format(floatval($request['amount'])),
    'account_name' => $request['account_name'],
    'account_number' => $request['account_number'],
    'previous_balance' => number_format($data['amount_before']),
    'balance' => number_format($data['amount_now'])
];

echo json_encode($response);