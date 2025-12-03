<?php
/**
*Plugin Name: Vtupress Bot
*Plugin URI: https://bikendi.com
*Description: This Add-on adds the bot system
*Version: 1.2.0
*Author: Akor Victor
*Author URI: https://facebook.com/bikendi-tech-solutions
*/
if(!defined('ABSPATH')){
    $pagePath = explode('/wp-content/', dirname(__FILE__));
    include_once(str_replace('wp-content/' , '', $pagePath[0] . '/wp-load.php'));
};



require __DIR__.'/plugin-update-checker/plugin-update-checker.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$myUpdateChecker = PucFactory::buildUpdateChecker(
	'https://github.com/bikendi-tech-solutions/vtupress-bot/',
	__FILE__,
	'vtupress-bot'
);
//Set the branch that contains the stable release.
$myUpdateChecker->setBranch('main');

$myUpdateChecker->setAuthentication('your-token-here');

$myUpdateChecker->getVcsApi()->enableReleaseAssets();