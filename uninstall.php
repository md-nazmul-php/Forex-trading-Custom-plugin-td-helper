<?php
// if uninstall.php is not called by WordPress, die
if (!defined('WP_UNINSTALL_PLUGIN')) {
die;
}
// drop a custom database table
global $wpdb;
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}td_helper_crypto_table");
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}td_helper_forex_table");
?>