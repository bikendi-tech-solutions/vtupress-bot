<?php

include 'init.php';

//required fields
$requiredFields = ['number', 'username', 'password'];
foreach ($requiredFields as $field) {
    if (empty($array[$field])) {
        echo json_encode(["valid"   => true, "message" => "Missing required field: $field"]);
        exit;
    }
}
$number = sanitize_text_field($owner_number);
$username = sanitize_text_field($array['username']);
$password = sanitize_text_field($array['password']);

// Authenticate using WordPress
$user = wp_authenticate($username, $password);

// wp_authenticate returns a WP_User object OR WP_Error
if (is_wp_error($user)) {
    $errorMessage =  "Invalid username and password";
    echo json_encode(["valid"   => true,"success" => false, "message" => $errorMessage]);
    exit;
}

$user_id = $user->ID;


if($channel == "whatsapp"){
    vp_updateuser($user_id,"vp_phone",$number);
}
elseif($channel == 'telegram'){
    vp_updateuser($user_id,"telegram_username",$number);
}
else{
    $errorMessage =  "Invalid channel";
    echo json_encode(["valid"   => true,"success" => false, "message" => $errorMessage]);
    exit;
}

$response['success'] = true;
$response['message'] = "----";

echo json_encode($response);