<?php
include __DIR__.'/../init.php';



    $vp_country = vp_country();
    $glo = $vp_country["glo"];
    $mobile = $vp_country["9mobile"];
    $mtn = $vp_country["mtn"];
    $airtel = $vp_country["airtel"];
    // $bypass = $vp_country["bypass"];
    // $currency = $vp_country["currency"];
    // $symbol = $vp_country["symbol"];

    if (strtolower($mtn) != ""):
        $response["data"][] = [
            "id"=>"mtn",
            "name"=> $mtn
        ];
    endif;
    if (strtolower($glo) != ""):
        $response["data"][] = [
            "id"=>"glo",
            "name"=> $glo
        ];
    endif;
    if (strtolower($airtel) != ""):
        $response["data"][] = [
            "id"=>"airtel",
            "name"=> $airtel
        ];
    endif;
    if (strtolower($mobile) != ""):
        $response["data"][] = [
            "id"=>"9mobile",
            "name"=> $mobile
        ];
    endif;

echo json_encode($response);
