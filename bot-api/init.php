<?php
// CORS FIX
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, api-key, bot-channel, X-Requested-With, Authorization");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Credentials: true");

// Handle Preflight (OPTIONS request)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}



error_reporting(0);

if (!defined('ABSPATH')) {
    $pagePath = explode('/wp-content/', dirname(__FILE__));
    include_once(str_replace('wp-content/', '', $pagePath[0] . '/wp-load.php'));
}

//check if vtupress plugin is active

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

$vp_plugin_slug   = 'vtupress/vtupress.php';
$vpr_plugin_slug  = 'vprest/vprest.php';

// Required minimum versions
$required_vtupress   = '7.0.9';
$required_vpreseller = '2.5.4';

// If plugin is not active at all
if ( !is_plugin_active( $vp_plugin_slug ) || !is_plugin_active( $vpr_plugin_slug ) ) {
    echo json_encode([
        "valid"   => true,
        "message" => "Core plugin is not active"
    ]);
    exit;
}

// Load plugin header data
$vp_data  = get_plugin_data( WP_PLUGIN_DIR . '/' . $vp_plugin_slug, false, false );
$vpr_data = get_plugin_data( WP_PLUGIN_DIR . '/' . $vpr_plugin_slug, false, false );

// Extract version strings
$vp_version  = $vp_data['Version'] ?? '';
$vpr_version = $vpr_data['Version'] ?? '';

// Version must be >= required (NOT !=)
$vp_ok  = version_compare($vp_version,  $required_vtupress,   '>=');
$vpr_ok = version_compare($vpr_version, $required_vpreseller, '>=');

// If version is lower than required
if ( !$vp_ok || !$vpr_ok ) {

    $error = "Required plugin version mismatch\n";
    $error .= "Vtupress Version: *{$vp_version}*\n";
    $error .= "Required Vtupress Version: *{$required_vtupress}*\n\n";
    $error .= "Vpreseller Version: *{$vpr_version}*\n";
    $error .= "Required Vpreseller Version: *{$required_vpreseller}*";

    echo json_encode([
        "valid"   => true,
        "message" => $error
    ]);
    exit;
}


include_once(WP_CONTENT_DIR . "/plugins/vtupress/functions.php");

if(vp_getoption('vtupress_custom_bot') != 'yes'){
    echo json_encode([
        "valid"   => true,
        "message" => "Please you need to purchase the bots custom order to make this addon work!"
    ]);
    exit;
}

// API key sent from JS is in HTTP_API_KEY
if (!isset($_SERVER["HTTP_API_KEY"])) {
    echo json_encode([
        "valid"   => true,
        "message" => "Missing API key"
    ]);
    exit;
}
elseif (!isset($_SERVER["HTTP_BOT_CHANNEL"])) {
    echo json_encode([
        "valid"   => true,
        "message" => "Bot Channel Not Stated"
    ]);
    exit;
}

$apiKey = $_SERVER["HTTP_API_KEY"];
$channel = $_SERVER["HTTP_BOT_CHANNEL"];

if($channel != "whatsapp" && $channel != "telegram"){
    echo json_encode([
        "valid"   => true,
        "message" => "Channel not valid"
    ]);
    exit;
}

global $bot_apiKey;

//check admin apiKey
$bot_apiKey = vp_getuser('1',"vr_id");
if ($apiKey !== $bot_apiKey) {
    echo json_encode([
        "valid"   => true,
        "message" => "Invalid API key"
    ]);
    exit;
}

$content = trim(file_get_contents("php://input"));
$array = json_decode($content, true);

$response = [];
//phone number
$owner_number = isset($array['number']) ? sanitize_text_field($array['number']) : '';
//if $owner_number starts with 234 , change it to 0
if (substr($owner_number, 0, 3) === '234') {
    $owner_number = '0' . substr($owner_number, 3);
}

//check if number exists in vtupress
global $wpdb;
$user_meta_table = $wpdb->prefix . "usermeta";

$pattern = '"vp_phone":"'. $owner_number .'"';

$user_id = $wpdb->get_var(
    $wpdb->prepare(
        "SELECT user_id FROM $user_meta_table 
         WHERE meta_key = %s 
         AND meta_value REGEXP %s",
        'vp_user_data',
        $pattern
    )
);

if ($user_id) {
    $response['valid'] = true;
} else {
    $response['valid'] = false;
}





function post($registerEndpoint, $data)
{
    global $bot_apiKey;
    $headers = [
        // 'Content-Type' => 'application/json',
        'cache-control' => 'no-cache',
    ];

    return wp_remote_post($registerEndpoint, [
        'headers' => $headers,
        'body' => array_merge($data,['bot_key'=>$bot_apiKey]),
        'timeout' => 120,
        'user-agent' => 'WABot/' . get_bloginfo('version') . '; ' . get_bloginfo('url'),
        'sslverify' => false, // Set to true in production with proper CA certs
    ]);
}

$vtupressUrl = vp_getoption('site_url', get_site_url());