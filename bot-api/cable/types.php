<?php
include __DIR__ . '/../init.php';

if (!isset($array['network_id'])) {
    $response["message"] = "Cable ID is required";
    echo json_encode($response);
    exit;
}

$network_id = $array['network_id'];

    $vp_country = vp_country();
    $symbol = $vp_country["symbol"];

$option_array = json_decode(get_option("vp_options"), true);

for ($i = 1; $i <= 15; $i++) {

    $plan = vp_option_array($option_array, "ccable" . ($i - 1));
    $price = vp_option_array($option_array, "ccablep" . ($i - 1));
    $name = vp_option_array($option_array, "ccablen" . ($i - 1));
    

    if (empty($plan) || empty($price) || empty($name)) continue ;

    if(($network_id == 'gotv' || $network_id == "dstv") && !preg_match("/$network_id/i",$name)){
        continue;
    }
    elseif($network_id == "startimes" && preg_match("/gotv|dstv/i",$name)){
        continue;
    }

    $response["data"][] = [
        "id" => $i,
        "name" => $name." ".$symbol.$price
    ];

}

echo json_encode($response);