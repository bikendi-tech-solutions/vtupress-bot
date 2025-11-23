<?php
include __DIR__.'/../init.php';

$option_array = json_decode(get_option("vp_options"), true);
    for($j=0; $j<=3; $j++){
        $id = vp_option_array($option_array,"billid".$j);
        $name = strtoupper(vp_option_array($option_array,"billname".$j));

        if(empty($name) || empty($id)) continue ;
        $response["data"][] = [
            "id"=> $id,
            "name"=> $name
        ];

    }


echo json_encode($response);
