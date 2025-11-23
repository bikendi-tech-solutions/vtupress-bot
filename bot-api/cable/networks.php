<?php
include __DIR__.'/../init.php';



    // $vp_country = vp_country();
    // $glo = $vp_country["glo"];
    // $mobile = $vp_country["9mobile"];
    // $mtn = $vp_country["mtn"];
    // $airtel = $vp_country["airtel"];
    // $bypass = $vp_country["bypass"];
    // $currency = $vp_country["currency"];
    // $symbol = $vp_country["symbol"]=
        $response["data"][] = [
            "id"=>"dstv",
            "name"=> "DSTV"
        ];
        $response["data"][] = [
            "id"=>"gotv",
            "name"=> "GOTV"
        ];
        $response["data"][] = [
            "id"=>"startimes",
            "name"=> "STARTIMES"
        ];


echo json_encode($response);
