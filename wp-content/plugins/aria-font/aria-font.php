<?php
/**
* Plugin Name: Aria Font
* Plugin URI: https://wordpress.org/plugins/aria-font
* Description: Change WordPress Theme Font
* Version: 1.1
* Author: AriaWP
* Author URI: https://ariawp.com
* License: GPLv2
*/
if ( ! defined( 'ABSPATH' ) ) exit;
 
include('inc/panel.php');

$options = get_option('ariafont_font_settings');
if(empty($options['bodyfontname'])){
	//Empty Entry
	}
else{
    function ariafont_fa_scripts() {
		$options = get_option('ariafont_font_settings');
    	wp_enqueue_style( 'ariafont-font', plugins_url( 'assets/css/' . esc_html( $options['bodyfontname'] ) . '.css', __FILE__ ) );
	}
	add_action( 'wp_enqueue_scripts', 'ariafont_fa_scripts', 999999);
}

?>