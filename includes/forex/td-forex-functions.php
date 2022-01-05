<?php defined('ABSPATH') OR exit('No direct script access allowed');

/*====== Start WP List Table Class ===========*/
if (!class_exists('WP_List_Table')) {
	
require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}
class td_forex_List_Table extends WP_List_Table
{
function __construct()
{
global $status, $page;
parent::__construct(array(
'singular' => 'forex',
'plural'   => 'forexs',
));
}
function column_default($item, $column_name)
{
return $item[$column_name];
}
function column_name($item)
{
$actions = array(
	
'edit' => sprintf('<a href="?page=add-td-helper-forex&id=%s">%s</a>', $item['id'], __('Edit', 'fxtable')),
'delete' => sprintf('<a href="?page=%s&action=delete&id=%s">%s</a>', $_REQUEST['page'], $item['id'], __('Delete', 'fxtable')),
);
return sprintf('%s %s',
$item['name'],
$this->row_actions($actions)
);
}
function column_cb($item)
{
return sprintf(
'<input type="checkbox" name="id[]" value="%s" />',
$item['id']
);
}
function get_columns()
{
$columns = array(
'cb' => '<input type="checkbox" />',
'name'      => __('Currency Name', 'td-helper'),
'action'     => __('Action', 'td-helper'),
'price_entry'     => __('Entry-Price', 'td-helper'),
'stop_loss'   => __('Stop Losse', 'td-helper'),
'price_target'       => __('Targeted', 'td-helper'),
'day_in_market'       => __('Day In Market', 'td-helper'),
'position_size'       => __('Position', 'td-helper'),
);
return $columns;
}
function get_sortable_columns()
{
$sortable_columns = array(
'name'      => array('name', true),
'action'     => array('action', true),
'price_entry'     => array('price_entry', true),
'stop_loss'   => array('stop_loss', true),
'price_target'   => array('price_target', true),
'day_in_market'   => array('day_in_market', true),
'position_size'   => array('position_size', true),
);
return $sortable_columns;
}
function get_bulk_actions()
{
$actions = array(
'delete' => 'Delete'
);
return $actions;
}
function process_bulk_action()
{
global $wpdb;
$table_name = $wpdb->prefix . 'td_helper_forex_table';
if ('delete' === $this->current_action()) {
$ids = isset($_REQUEST['id']) ? $_REQUEST['id'] : array();
if (is_array($ids)) $ids = implode(',', $ids);
if (!empty($ids)) {
$wpdb->query("DELETE FROM $table_name WHERE id IN($ids)");
}
}
}
function prepare_items()
{
global $wpdb;
$table_name = $wpdb->prefix . 'td_helper_forex_table';
$per_page = 10;
$columns = $this->get_columns();
$hidden = array();
$sortable = $this->get_sortable_columns();
$this->_column_headers = array($columns, $hidden, $sortable);
$this->process_bulk_action();
$total_items = $wpdb->get_var("SELECT COUNT(id) FROM $table_name");
$paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged']) - 1) : 0;
$orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'name';
$order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'asc';
$this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);
$this->set_pagination_args(array(
'total_items' => $total_items,
'per_page' => $per_page,
'total_pages' => ceil($total_items / $per_page)
));
}
}
function td_forex_admin_menu()
{
add_submenu_page(
	'td-helper',
	'View Forex Data',
	'View Forex Data',
	'activate_plugins',
	'td-helper-forex',
	'td_forex_handler_cb',
	10
);
add_submenu_page(
	'td-helper',
	'Add Forex Data',
	'Add Forex Data',
	'activate_plugins',
	'add-td-helper-forex',
	'td_forex_datas_form_page_handler_cb',
	10
);
}
add_action('admin_menu', 'td_forex_admin_menu');


if (!function_exists('td_forex_validate_datas')):
function td_forex_validate_datas($item)
{
$messages = array();
if (empty($item['name'])) $messages[] = __(' Currency Name is required', 'td-helper');
if (empty($item['action'])) $messages[] = __('Action field is required', 'td-helper');
if (empty($item['price_entry'])) $messages[] = __('Entry Price is required', 'td-helper');
if (empty($item['stop_loss'])) $messages[] = __('Stop Loss Value is required', 'td-helper');
if (empty($item['price_target'])) $messages[] = __('Targeted Value is required', 'td-helper');
if (empty($item['day_in_market'])) $messages[] = __(' Day In Market is required', 'td-helper');
if (empty($item['position_size'])) $messages[] = __(' Position value is required', 'td-helper');
if (empty($messages)) return true;
return implode('<br />', $messages);
}
endif;