<?php
include __DIR__ . '/../init.php';

$response["data"] = [];

$response["data"][] = [
        "id" => "account-details",
        "name" => "Account Details"
    ];

$response["data"][] = [
        "id" => "account-generate-account",
        "name" => "Generate Account"
    ];

$response["data"][] = [
        "id" => "account-change-password",
        "name" => "Change Password"
    ];

$response["data"][] = [
        "id" => "account-change-pin",
        "name" => "Change Pin"
    ];
    

echo json_encode($response);