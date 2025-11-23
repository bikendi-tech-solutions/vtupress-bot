<?php
include __DIR__ . '/../init.php';

if (!isset($array['network_id'])) {
    $response["message"] = "Bill ID is required";
    echo json_encode($response);
    exit;
}

$network_id = $array['network_id'];

    $vp_country = vp_country();
    $symbol = $vp_country["symbol"];

$option_array = json_decode(get_option("vp_options"), true);

for($i=0; $i<=35; $i++){

    $plan = vp_option_array($option_array, "cbill" . $i );
    $name = vp_option_array($option_array, "cbilln" . $i );
    

    if (empty($plan) || empty($name)) continue ;

    $response["data"][] = [
        "id" => $i,
        "name" => $name
    ];

}

echo json_encode($response);