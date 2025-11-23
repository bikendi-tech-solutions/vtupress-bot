<?php
include __DIR__.'/../init.php';

if (!isset($array['service']) || !isset($array['iuc'])) {
    $response["message"] = "Some required param are missing";
    echo json_encode($response);
    exit;
}

$service = sanitize_text_field($array['service']);
$iuc = sanitize_text_field($array['iuc']);

$url = "https://vtupress.com/billget.php?billget&meter=$iuc&service=$service";

$apiresponse = file_get_contents($url);

if(preg_match("/can't/i",$apiresponse )){
    $response["message"] = $apiresponse;
    echo json_encode($response);
    exit;
}
elseif(preg_match("/error:/i",$apiresponse )){
    $response["message"] = "Error verifying!";
    echo json_encode($response);
    exit;
}
elseif(preg_match("/$iuc/i",$apiresponse )){
    $response["message"] = $apiresponse ;
    echo json_encode($response);
    exit;
}

    $response["success"] = true;
    $response["message"] = $apiresponse ;
    echo json_encode($response);
    exit;