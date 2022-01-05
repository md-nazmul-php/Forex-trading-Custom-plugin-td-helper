<?php defined('ABSPATH') OR exit('No direct script access allowed');
/*This Template handle activation hooks of this plugin*/
// ===================== Create Long table ===============================
global $fxtable_db_version;
$fxtable_db_version = '1.1.0';
if (!function_exists('td_activation_hook')):

function td_activation_hook() {
global $wpdb;

$table_name_long = $wpdb->prefix . 'td_helper_crypto_table';
$sql = "CREATE TABLE " . $table_name_long . " (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(220) DEFAULT NULL,
`action` varchar(220) DEFAULT NULL,
`price_entry` FLOAT(9,4) DEFAULT NULL,
`stop_loss` FLOAT(9,4) DEFAULT NULL,
`price_target` FLOAT(9,4) DEFAULT NULL,
`day_in_market` int(11) DEFAULT NULL,
`position_size` int(11) DEFAULT NULL,
PRIMARY KEY  (id)
);";
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
dbDelta($sql);


$table_name_short = $wpdb->prefix . 'td_helper_forex_table';
$sql = "CREATE TABLE " . $table_name_short . " (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(220) DEFAULT NULL,
`action` varchar(220) DEFAULT NULL,
`price_entry` FLOAT(9,4) DEFAULT NULL,
`stop_loss` FLOAT(9,4) DEFAULT NULL,
`price_target` FLOAT(9,4) DEFAULT NULL,
`day_in_market` int(11) DEFAULT NULL,
`position_size` int(11) DEFAULT NULL,
PRIMARY KEY  (id)
);";
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
dbDelta($sql);
}
endif;