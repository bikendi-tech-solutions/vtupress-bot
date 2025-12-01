<?php
include 'init.php';



 $response["options"] = [];
     $response["options"][] = [
        "key"=>"account",
        "name"=> "Manage Account"
    ];
if(vp_option_array($option_array,"setairtime") == "checked" ):
    $response["options"][] = [
        "key"=>"airtime",
        "name"=> "Buy Airtime"
    ];
endif;
if(vp_option_array($option_array,"setdata") == "checked" ):
    $response["options"][] = [
        "key"=>"data",
        "name"=> "Buy Data"
    ];
endif;
if(vp_option_array($option_array,"setcable") == "checked" ):
    $response["options"][] = [
        "key"=>"cable",
        "name"=> "Tv Subscription"
    ];
endif;
if(vp_option_array($option_array,"setbill") == "checked" ):
    $response["options"][] = [
        "key"=>"bill",
        "name"=> "Utility Bills"
    ];
endif;

if(vp_getoption('allow_to_bank') == "yes" && vp_getoption("vtupress_custom_transfer") == "yes"):
    $response["options"][] = [
        "key"=>"transfer",
        "name"=> "Bank Transfer"
    ];
endif;


echo json_encode($response);
