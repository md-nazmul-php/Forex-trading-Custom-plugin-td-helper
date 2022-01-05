<?php defined('ABSPATH') OR exit('No direct script access allowed');
/*========= This templete is to include CSS and Javascript files ==========*/
if (!function_exists('td_custom_admin_styles')):

function td_custom_admin_styles() {
	wp_enqueue_style('td-helper-custom-admin-styles', plugins_url('/css/td-back-end.css', __FILE__ ));
		}
add_action('admin_enqueue_scripts', 'td_custom_admin_styles');
endif;
/**
* Front End enqueue scripts and styles
*/
if (!function_exists('td_front_end_scripts')):
function td_front_end_scripts() {
wp_enqueue_style( 'style-name', plugins_url('/css/td-front-end.css', __FILE__ ));

// wp_enqueue_script( 'script-name', get_template_directory_uri() . '/js/example.js', array(), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'td_front_end_scripts' );
endif;