<?php
include __DIR__ . '/../init.php';

$response["data"] = [];
if( vp_getoption('enable_paymentpoint') == "yes" ){
    $response["data"][] = [
        "id" => "paymentpoint",
        "name" => "Paymentpoint"
    ];

}
if( vp_getoption('enable_nomba') == "yes" ){
    $response["data"][] = [
        "id" => "nomba",
        "name" => "Nomba"
    ];
}
if( vp_getoption('enable_ncwallet') == "yes" ){
    $response["data"][] = [
        "id" => "ncwallet",
        "name" => "Ncwallet"
    ];
}
if( vp_getoption('enable_billstack') == "yes" ){
    $response["data"][] = [
        "id" => "billstack",
        "name" => "Billstack"
    ];
}

if( vp_getoption('enable_monnify') == "yes" ){
    $response["data"][] = [
        "id" => "monnify",
        "name" => "Monnify"
    ];
}

if( vp_getoption('enable_payvessel') == "yes" ){
    $response["data"][] = [
        "id" => "payvessel",
        "name" => "Payvessel"
    ];
}

echo json_encode($response);