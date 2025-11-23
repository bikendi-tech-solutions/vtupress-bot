<?php
include __DIR__ . '/../init.php';

if (!isset($array["network_id"]) || !isset($array['type'])) {
    $response["message"] = "Some missing params";
    echo json_encode($response);
    exit;
}

$network_id = sanitize_text_field($array["network_id"]);
$type = sanitize_text_field($array["type"]);

$response["data"] = [];

$vp_country = vp_country();
$symbol = $vp_country["symbol"];

if ($type == "sme" && $network_id == "mtn") {
    for ($i = 0; $i <= 10; $i++) {
        $id = vp_option_array($option_array, "cdata" . $i);
        $api = vp_option_array($option_array, "api" . $i);
        $name = vp_option_array($option_array, "cdatan" . $i);
        $price = vp_option_array($option_array, "cdatap" . $i);
        if ($id == "" || $name == "" || $price == "") {
            continue;
        }

        $response["data"][] = [
            "id" => $api,
            "name" => $name . " " . $symbol.$price
        ];


    }
} elseif ($type == "sme" && $network_id == "glo") {
    for ($i = 0; $i <= 10; $i++) {
        $id = vp_option_array($option_array, "gcdata" . $i);
        $api = vp_option_array($option_array, "gapi" . $i);
        $name = vp_option_array($option_array, "gcdatan" . $i);
        $price = vp_option_array($option_array, "gcdatap" . $i);
        if ($id == "" || $name == "" || $price == "") {
            continue;
        }

        $response["data"][] = [
            "id" => $api,
            "name" => $name . " " . $symbol.$price
        ];


    }
} elseif ($type == "sme" && $network_id == "9mobile") {
    for ($i = 0; $i <= 10; $i++) {
        $id = vp_option_array($option_array, "9cdata" . $i);
        $api = vp_option_array($option_array, "9api" . $i);
        $name = vp_option_array($option_array, "9cdatan" . $i);
        $price = vp_option_array($option_array, "9cdatap" . $i);
        if ($id == "" || $name == "" || $price == "") {
            continue;
        }

        $response["data"][] = [
            "id" => $api,
            "name" => $name . " " . $symbol.$price
        ];


    }
} elseif ($type == "sme" && $network_id == "airtel") {
    for ($i = 0; $i <= 10; $i++) {
        $id = vp_option_array($option_array, "acdata" . $i);
        $api = vp_option_array($option_array, "aapi" . $i);
        $name = vp_option_array($option_array, "acdatan" . $i);
        $price = vp_option_array($option_array, "acdatap" . $i);
        if ($id == "" || $name == "" || $price == "") {
            continue;
        }

        $response["data"][] = [
            "id" => $api,
            "name" => $name . " " . $symbol.$price
        ];


    }
} elseif ($type == "corporate" && $network_id == "mtn") {
    for ($i = 0; $i <= 10; $i++) {
        $id = vp_option_array($option_array, "rcdata" . $i);
        $name = vp_option_array($option_array, "rcdatan" . $i);
        $price = vp_option_array($option_array, "rcdatap" . $i);
        $api = vp_option_array($option_array, "api3" . $i);

        if ($id == "" || $name == "" || $price == "") {
            continue;
        }

        $response["data"][] = [
            "id" => $api,
            "name" => $name . " " . $symbol.$price
        ];


    }
} elseif ($type == "corporate" && $network_id == "glo") {
    for ($i = 0; $i <= 10; $i++) {
        $id = vp_option_array($option_array, "rgcdata" . $i);
        $name = vp_option_array($option_array, "rgcdatan" . $i);
        $price = vp_option_array($option_array, "rgcdatap" . $i);
        $api = vp_option_array($option_array, "gapi3" . $i);

        if ($id == "" || $name == "" || $price == "") {
            continue;
        }

        $response["data"][] = [
            "id" => $api,
            "name" => $name . " " . $symbol.$price
        ];


    }
} elseif ($type == "corporate" && $network_id == "9mobile") {
    for ($i = 0; $i <= 10; $i++) {
        $id = vp_option_array($option_array, "r9cdata" . $i);
        $name = vp_option_array($option_array, "r9cdatan" . $i);
        $price = vp_option_array($option_array, "r9cdatap" . $i);
        $api = vp_option_array($option_array, "9api3" . $i);

        if ($id == "" || $name == "" || $price == "") {
            continue;
        }

        $response["data"][] = [
            "id" => $api,
            "name" => $name . " " . $symbol.$price
        ];


    }
} elseif ($type == "corporate" && $network_id == "airtel") {
    for ($i = 0; $i <= 10; $i++) {
        $id = vp_option_array($option_array, "racdata" . $i);
        $name = vp_option_array($option_array, "racdatan" . $i);
        $price = vp_option_array($option_array, "racdatap" . $i);
        $api = vp_option_array($option_array, "aapi3" . $i);

        if ($id == "" || $name == "" || $price == "") {
            continue;
        }

        $response["data"][] = [
            "id" => $api,
            "name" => $name . " " . $symbol.$price
        ];


    }
} elseif ($type == "direct" && $network_id == "mtn") {
    for ($i = 0; $i <= 10; $i++) {
        $id = vp_option_array($option_array, "r2cdata" . $i);
        $name = vp_option_array($option_array, "r2cdatan" . $i);
        $price = vp_option_array($option_array, "r2cdatap" . $i);
        $api = vp_option_array($option_array, "api2" . $i);

        if ($id == "" || $name == "" || $price == "") {
            continue;
        }

        $response["data"][] = [
            "id" => $api,
            "name" => $name . " " . $symbol.$price
        ];


    }
} elseif ($type == "direct" && $network_id == "glo") {
    for ($i = 0; $i <= 10; $i++) {
        $id = vp_option_array($option_array, "r2gcdata" . $i);
        $name = vp_option_array($option_array, "r2gcdatan" . $i);
        $price = vp_option_array($option_array, "r2gcdatap" . $i);
        $api = vp_option_array($option_array, "gapi2" . $i);

        if ($id == "" || $name == "" || $price == "") {
            continue;
        }

        $response["data"][] = [
            "id" => $api,
            "name" => $name . " " . $symbol.$price
        ];


    }
} elseif ($type == "direct" && $network_id == "9mobile") {
    for ($i = 0; $i <= 10; $i++) {
        $id = vp_option_array($option_array, "r29cdata" . $i);
        $name = vp_option_array($option_array, "r29cdatan" . $i);
        $price = vp_option_array($option_array, "r29cdatap" . $i);
        $api = vp_option_array($option_array, "9api2" . $i);

        if ($id == "" || $name == "" || $price == "") {
            continue;
        }

        $response["data"][] = [
            "id" => $api,
            "name" => $name . " " . $symbol.$price
        ];


    }
} elseif ($type == "direct" && $network_id == "airtel") {
    for ($i = 0; $i <= 10; $i++) {
        $id = vp_option_array($option_array, "r2acdata" . $i);
        $name = vp_option_array($option_array, "r2acdatan" . $i);
        $price = vp_option_array($option_array, "r2acdatap" . $i);
        $api = vp_option_array($option_array, "aapi2" . $i);

        if ($id == "" || $name == "" || $price == "") {
            continue;
        }

        $response["data"][] = [
            "id" => $api,
            "name" => $name . " " . $symbol.$price
        ];


    }
}

echo json_encode($response);