<?php
include __DIR__ . '/../init.php';

if (!isset($array['network_id'])) {
    $response["message"] = "Network ID is required";
    echo json_encode($response);
    exit;
}

$vp_country = vp_country();

$network_id = $array['network_id'];

if (!$vp_country[$network_id]) {
    $response["message"] = "Invalid Network ID";
    echo json_encode($response);
    exit;
}

$option_array = json_decode(get_option("vp_options"), true);

if (!empty(vp_option_array($option_array, "airtimebaseurl")) && !empty(vp_option_array($option_array, "airtimeendpoint")) && vp_option_array($option_array, "vtucontrol") == "checked") {
    $response["data"][] = [
        "id" => "vtu",
        "name" => "VTU"
    ];
}

if (!empty(vp_option_array($option_array, "sairtimebaseurl")) && !empty(vp_option_array($option_array, "sairtimeendpoint")) && vp_option_array($option_array, "sharecontrol") == "checked") {
    $response["data"][] = [
        "id" => "share",
        "name" => "Share & Sell"
    ];
}

if (!empty(vp_option_array($option_array, "wairtimebaseurl")) && !empty(vp_option_array($option_array, "wairtimeendpoint")) && vp_option_array($option_array, "awufcontrol") == "checked") {
    $response["data"][] = [
        "id" => "awuf",
        "name" => "AWUF"
    ];
}

echo json_encode($response);