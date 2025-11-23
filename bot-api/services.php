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
        "name"=> "Data"
    ];
endif;
if(vp_option_array($option_array,"setcable") == "checked" ):
    $response["options"][] = [
        "key"=>"cable",
        "name"=> "Cable"
    ];
endif;
if(vp_option_array($option_array,"setbill") == "checked" ):
    $response["options"][] = [
        "key"=>"bill",
        "name"=> "Bill"
    ];
endif;


echo json_encode($response);
