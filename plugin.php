<?php
/**
*Plugin Name: Vtupress Bot
*Plugin URI: https://bikendi.com
*Description: This Add-on adds the bot system
*Version: 1.0.0
*Author: Akor Victor
*Author URI: https://facebook.com/bikendi-tech-solutions
*/
if(!defined('ABSPATH')){
    $pagePath = explode('/wp-content/', dirname(__FILE__));
    include_once(str_replace('wp-content/' , '', $pagePath[0] . '/wp-load.php'));
};