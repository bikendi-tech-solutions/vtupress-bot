<?php
include __DIR__.'/../init.php';

if (!isset($array['service']) || !isset($array['iuc'])) {
    $response["message"] = "Some required param are missing";
    echo json_encode($response);
    exit;
}

$service = sanitize_text_field($array['service']);
$iuc = sanitize_text_field($array['iuc']);

$apiresponse = file_get_contents("https://vtupress.com/billget.php?cableget&meter=$iuc&service=$service");

if(preg_match("/can't/i",$apiresponse )){
    $response["message"] = "Can't verify for the moment";
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