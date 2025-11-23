<?php
include __DIR__ . '/../init.php';

if (!isset($array['network_id'])) {
    $response["message"] = "Network ID is required";
    echo json_encode($response);
    exit;
}

$vp_country = vp_country();
$bypass = $vp_country["bypass"];

$network_id = $array['network_id'];

if (!$vp_country[$network_id]) {
    $response["message"] = "Invalid Network ID";
    echo json_encode($response);
    exit;
}

$option_array = json_decode(get_option("vp_options"), true);

if (!empty(vp_option_array($option_array, "databaseurl")) && !empty(vp_option_array($option_array, "dataendpoint")) && vp_option_array($option_array, "smecontrol") == "checked" && !$bypass) {
    $response["data"][] = [
        "id" => "sme",
        "name" => "SME"
    ];
}

if (!empty(vp_option_array($option_array, "r2databaseurl")) && !empty(vp_option_array($option_array, "r2dataendpoint")) && vp_option_array($option_array, "corporatecontrol") == "checked" && !$bypass) {
    $response["data"][] = [
        "id" => "corporate",
        "name" => "CORPORATE"
    ];
}

if (!empty(vp_option_array($option_array, "rdatabaseurl")) && !empty(vp_option_array($option_array, "rdataendpoint")) && vp_option_array($option_array, "directcontrol") == "checked") {
    $response["data"][] = [
        "id" => "direct",
        "name" => "DIRECT GIFTING"
    ];
}

echo json_encode($response);