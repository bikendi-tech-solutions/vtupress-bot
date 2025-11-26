<?php

include 'init.php';

//required fields
$requiredFields = ['number', 'username', 'firstName', 'lastName', 'email', 'pin', 'password'];
foreach ($requiredFields as $field) {
    if (empty($array[$field])) {
        echo json_encode(["error" => "Missing required field: $field"]);
        exit;
    }
}
$number = sanitize_text_field($owner_number);
$username = sanitize_text_field($array['username']);
$firstName = sanitize_text_field($array['firstName']);
$lastName = sanitize_text_field($array['lastName']);
$email = sanitize_email($array['email']);
$pin = sanitize_text_field($array['pin']);
$password = sanitize_text_field($array['password']);
$referer = isset($array['referer']) ? sanitize_text_field($array['referer']) : 1;

//send a request to vtupress to register user
$registerEndpoint = $vtupressUrl . '/wp-content/plugins/vtupress/userlogin.php';
$response = post($registerEndpoint, [
            'phone' => $number,
            'username' => $username,
            'fun' => $firstName,
            'lun' => $lastName,
            'email' => $email,
            'pin' => $pin,
            'pswd' => $password,
            'ref' => $referer
        ]);

//if wp error get the message
if (is_wp_error($response)) {
    echo json_encode(["message" => "Registration request failed: " . $response->get_error_message()]);
    exit;
}
$body = wp_remote_retrieve_body($response);
$data = json_decode($body, true);

if(!isset($data["status"]) || $data["status"] != "100"){
    error_log("Registration failed: " . $body);
    $errorMessage = isset($data["message"]) ? $data["message"] : "Registration failed";
    echo json_encode(["success" => false, "message" => $errorMessage]);
    exit;
}

$response['success'] = true;
$response['message'] = "----";

echo json_encode($response);