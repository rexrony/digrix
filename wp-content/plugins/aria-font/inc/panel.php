<?php
if ( ! defined( 'ABSPATH' ) ) exit;
function ariafont_settings_page() {
include ('font-setting.php');
}

function ariafont_about_page() {
include ('feedback.php');
}

function ariafont_font_settings_page() {
//Aria Font Setting Functions
}
function ariafont_create_menu() {
add_menu_page( __("آریا فونت", 'awp'), __("آریا فونت", 'awp'), 1,"ariafont-settings", "ariafont_settings_page" ,'dashicons-admin-customizer' );
add_submenu_page("ariafont-settings", __("فونت پوسته", 'awp'), __("فونت پوسته", 'awp'), 1, "ariafont-settings","ariafont_settings_page");
add_submenu_page("ariafont-settings", __("پشتیبانی", 'awp'), __("پشتیبانی", 'awp'), 1, "ariafont-about","ariafont_about_page");
add_action('admin_init', 'register_ariafont_settings');
}
add_action('admin_menu', 'ariafont_create_menu');
function register_ariafont_settings(){
// Register our settings
register_setting('ariafont_font_settings', 'ariafont_font_settings');
}



        



