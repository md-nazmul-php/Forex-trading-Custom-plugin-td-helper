<?php defined('ABSPATH') OR exit('No direct script access allowed');
/**
* Plugin Name:TD Helper
* Description: TD Helper plugin is to display Crypto & Forex currency portfolio data. This is Using a free APi to get realtime currency rate data. Others fields are user generated. It hs beautiful back-end to handle data and allows to insert, delete and update data as well.
* Version:     1.0.1
* Requires at least: 5.6
* Requires PHP:      7.4
* Plugin URI: https://www.upwork.com/freelancers/~01bf696fab6c7c2afe
* Author:      Md Nazmul
* Author URI:  https://phpguru.co
* License:     GPLv2 or later
* License URI: https://www.gnu.org/licenses/gpl-2.0.html
* Text Domain: td-helper
* Domain Path: /languages
* ======================End Plugin Header===============================*/
/* ==== Include required files for this plugin =====*/
require plugin_dir_path( __FILE__ ) . 'td-helper-activation.php';
require plugin_dir_path( __FILE__ ) . 'td-helper-scripts.php';
/* ==== Register Activation Hook =====*/
register_activation_hook(__FILE__, 'td_activation_hook');
/*========= Include required files for crypto currency table's ============*/
require plugin_dir_path( __FILE__ ) . 'includes/crypto/td-crypto-functions.php';
require plugin_dir_path( __FILE__ ) . 'includes/crypto/td-crypto-table-handler.php';
require plugin_dir_path( __FILE__ ) . 'includes/crypto/td-crypto-shortcode.php';

/*========= Include required files for Forex currency table's ============*/
require plugin_dir_path( __FILE__ ) . 'includes/forex/td-forex-functions.php';
require plugin_dir_path( __FILE__ ) . 'includes/forex/td-forex-table-handler.php';
require plugin_dir_path( __FILE__ ) . 'includes/forex/td-forex-shortcode.php';