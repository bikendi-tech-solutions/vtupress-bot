<?php
include __DIR__ . '/../init.php';

if (vp_getoption('allow_to_bank') != "yes" || vp_getoption("vtupress_custom_transfer") != "yes") {
    die(json_encode(["valid"=>true,"message"=>"Bank transfer not available at the moment"]));
}

// Filter function (keep only major commercial & PSB banks)
$mfb_filter = function($bank_name) {
    return true; // no filtering needed now because we manually selected 50 banks
};

if (vp_getoption("enable_nomba") == "yes") {

    // Nomba Top 50 Banks
    $banks = [
        "044" => "Access Bank",
        "063" => "Access Bank (Diamond)",
        "057" => "Zenith Bank",
        "058" => "GTBank",
        "011" => "First Bank of Nigeria",
        "214" => "First City Monument Bank",
        "033" => "United Bank for Africa",
        "032" => "Union Bank of Nigeria",
        "070" => "Fidelity Bank",
        "232" => "Sterling Bank",
        "076" => "Polaris Bank",
        "050" => "Ecobank Nigeria",
        "221" => "Stanbic IBTC Bank",
        "068" => "Standard Chartered Bank Nigeria",
        "035" => "Wema Bank",
        "082" => "Keystone Bank",
        "215" => "Unity Bank",
        "101" => "Providus Bank",
        "303" => "Lotus Bank",
        "305" => "Opay (Paycom)",
        "999992" => "Opay Digital Services",
        "100033" => "PalmPay",
        "999991" => "PalmPay Digital",
        "120004" => "Airtel Smartcash PSB",
        "120003" => "MTN Momo PSB",
        "120001" => "9PSB",
        "120002" => "Hope PSB",
        "301" => "Jaiz Bank",
        "302" => "TAJ Bank",
        "000027" => "Globus Bank",
        "104" => "Parallex Bank",
        "102" => "Titan Trust Bank",
        "567" => "VFD Bank",
        "100026" => "Alternative Bank",
        "400001" => "FSDH Merchant Bank",
        "559" => "Coronation Merchant Bank",
        "502" => "Rand Merchant Bank",
        "268" => "Platinum Mortgage Bank",
        "812" => "Gateway Mortgage Bank",
        "401" => "ASO Savings & Loans",
        "110059" => "Habari Pay",
        "311" => "Parkway ReadyCash",
        "107" => "Optimus Bank",
        "391" => "Xpress Wallet",
        "738" => "Xpress Payments",
        "964" => "Yello Digital Services",
        "148" => "Xpress MTS",
        "070008" => "Page Financials"
    ];

} else {

    // Paystack/Other Gateway Top 50 Banks
    $banks = [
        "044" => "Access Bank",
        "063" => "Access Bank (Diamond)",
        "057" => "Zenith Bank",
        "058" => "Guaranty Trust Bank",
        "011" => "First Bank of Nigeria",
        "214" => "First City Monument Bank",
        "033" => "United Bank For Africa",
        "032" => "Union Bank of Nigeria",
        "070" => "Fidelity Bank",
        "076" => "Polaris Bank",
        "232" => "Sterling Bank",
        "050" => "Ecobank Nigeria",
        "221" => "Stanbic IBTC Bank",
        "068" => "Standard Chartered Bank",
        "035" => "Wema Bank",
        "082" => "Keystone Bank",
        "215" => "Unity Bank",
        "101" => "Providus Bank",
        "303" => "Lotus Bank",
        "104" => "Parallex Bank",
        "102" => "Titan Bank",
        "000027" => "Globus Bank",
        "120004" => "Airtel Smartcash PSB",
        "120003" => "MTN Momo PSB",
        "120001" => "9PSB",
        "120002" => "HopePSB",
        "100039" => "Paystack Titan",
        "999992" => "Opay Digital Services",
        "999991" => "PalmPay Digital",
        "301" => "Jaiz Bank",
        "302" => "TAJ Bank",
        "567" => "VFD Bank",
        "559" => "Coronation Merchant Bank",
        "502" => "Rand Merchant Bank",
        "268" => "Platinum Mortgage Bank",
        "40165" => "Sage Grey Finance",
        "312" => "Chikum Microfinance Wallet",
        "110059" => "Habari Pay",
        "311" => "Parkway ReadyCash",
        "107" => "Optimus Bank",
        "391" => "Xpress Wallet",
        "738" => "Xpress Payments",
        "964" => "Yello Digital Services",
        "148" => "Xpress MTS",
        "070008" => "Page Financials",
        "100022" => "GoMoney"
    ];
}

asort($banks, SORT_NATURAL | SORT_FLAG_CASE);

$response["data"] = [];

foreach ($banks as $key => $val) {
    $response["data"][] = [
        "id" => $key,
        "name" => $val
    ];
}

echo json_encode($response);
