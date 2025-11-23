<?php
include __DIR__ . '/../init.php';

// 1. Ensure $user_id is actually defined before this point
// (e.g., passed via JSON input as discussed in previous steps)
if (!isset($user_id)) {
    // handle error or extract from input
}

$vp_country = vp_country();
// $currency = $vp_country["currency"];
$symbol = $vp_country["symbol"];
$user = get_userdata($user_id);
$balance = $symbol . number_format((vp_getuser($user_id, 'vp_bal', true)));
$pin = vp_getuser($user_id, 'vp_pin', true);
$plan = vp_getuser($user_id, 'vr_plan', true);
$apiKey = vp_getuser($user_id, 'vr_id', true);
$access = vp_getuser($user_id, 'vp_user_access', true) != 'false' ? vp_getuser($user_id, 'vp_user_access', true) : 'Active';

// 2. Use .= for Concatenation and \n for new lines
// Note: access user_email, usually not just 'email'
$response["data"] = "`Username: *{$user->user_login}*`\n";
$response["data"] .= "`Email: *{$user->user_email}*`\n";
$response["data"] .= "`Balance: *{$balance}*`\n";
$response["data"] .= "`Pin: *{$pin}*`\n";
$response["data"] .= "`Plan: *{$plan}*`\n";
// $response["data"] .= "ApiKey: *{$apiKey}*\n";
$response["data"] .= "`Status: *{$access}*`\n\n";
$response["data"] .= "*Bank Account Details:*\n\n";

if (vp_getoption('enable_paymentpoint') == "yes" && vp_getoption("vtupress_custom_paymentpoint") == "yes" && strlen(vp_getuser($user_id, "paymentpoint_accountnumber")) == 10) {

    $account = vp_getuser($user_id, "paymentpoint_accountnumber");
    $response["data"] .= "> Palmpay: $account\n";
}

if (vp_getoption('enable_nomba') == "yes" && vp_getoption("vtupress_custom_nomba") == "yes" && strlen(vp_getuser($user_id, "nomba_accountnumber")) == 10) {

    $account = vp_getuser($user_id, "nomba_accountnumber");
    $response["data"] .= "> Nomba: $account\n";
}

if (vp_getoption('enable_ncwallet') == "yes" && vp_getoption("vtupress_custom_ncwallet") == "yes" && strlen(vp_getuser($user_id, "ncwallet_accountnumber")) == 10) {

    $account = vp_getuser($user_id, "ncwallet_accountnumber");
    $response["data"] .= "> Nomba: $account\n";
}

if (vp_getoption('enable_payvessel') == "yes" && vp_getoption("vtupress_custom_payvessel") == "yes" && strlen(vp_getuser($user_id, "payvessel_accountnumber")) == 10) {

    $account = vp_getuser($user_id, "payvessel_accountnumber");
    $response["data"] .= "> 9 Payment Service: $account\n";
}

if (vp_getoption('enable_billstack') == "yes" && vp_getoption("vtupress_custom_billstack") == "yes" && strlen(vp_getuser($user_id, "billstack_accountnumber")) == 10) {

    $account = vp_getuser($user_id, "billstack_accountnumber");
    $response["data"] .= "> 9 Payment Service: $account\n";
}

if (vp_getoption('enable_monnify') == "yes") {
    $user_array = json_decode(get_user_meta($id, "vp_user_data", true), true);

    $bank_mode = vp_user_array($user_array, $id, "account_mode", true);
    if ($bank_mode === "live") {
        $account_number = vp_user_array($user_array, $id, "account_number", true);
        $bank_name_raw = vp_user_array($user_array, $id, "bank_name", true);
        if (is_numeric(stripos($bank_name_raw, "Wema"))) {
            $bank_name = "Wema";
        } elseif (is_numeric(stripos($bank_name_raw, "ster"))) {
            $bank_name = "Sterling";
        } elseif (is_numeric(stripos($bank_name_raw, "mon"))) {
            $bank_name = "Monniepoint";
        } else {
            $bank_name = $bank_name_raw; // Keep original if not matched
        }

        $response["data"] .= "> $bank_name : $account_number\n";

        if (!empty(vp_user_array($user_array, $id, "account_name1", true)) && vp_user_array($user_array, $id, "account_name1", true) !== "false") {
            $account_number1 = vp_user_array($user_array, $id, "account_number1", true);
            $bank_name1_raw = vp_user_array($user_array, $id, "bank_name1", true);
            if (is_numeric(stripos($bank_name1_raw, "Wema"))) {
                $bank_name1 = "Wema";
            } elseif (is_numeric(stripos($bank_name1_raw, "ster"))) {
                $bank_name1 = "Sterling";
            } elseif (is_numeric(stripos($bank_name1_raw, "mon"))) {
                $bank_name1 = "Monniepoint";
            } else {
                $bank_name1 = $bank_name1_raw;
            }

            $response["data"] .= "> $bank_name1 : $account_number1\n";

        }

        if (!empty(vp_user_array($user_array, $id, "account_name2", true)) && vp_user_array($user_array, $id, "account_name2", true) !== "false") {
            $account_number2 = vp_user_array($user_array, $id, "account_number2", true);
            $bank_name2_raw = vp_user_array($user_array, $id, "bank_name2", true);
            if (is_numeric(stripos($bank_name2_raw, "Wema"))) {
                $bank_name2 = "Wema";
            } elseif (is_numeric(stripos($bank_name2_raw, "ster"))) {
                $bank_name2 = "Sterling";
            } elseif (is_numeric(stripos($bank_name2_raw, "mon"))) {
                $bank_name2 = "Monniepoint";
            } else {
                $bank_name2 = $bank_name2_raw;
            }

            $response["data"] .= "> $bank_name2 : $account_number2\n";

        } 
    }
}




echo json_encode($response);
?>