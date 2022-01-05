<?php defined('ABSPATH') OR exit('No direct script access allowed');
/*====== This template is to handle Wp List table data ==============*/
if (!function_exists('td_crypto_handler_cb')):
function td_crypto_handler_cb()
{
global $wpdb;
$table = new td_crypto_List_Table();
$table->prepare_items();
$message = '';
if ('delete' === $table->current_action()) {
$ids = isset($_REQUEST['id']) ? $_REQUEST['id'] : array();
if (is_array($ids)){
$message = '<div class="updated below-h2" id="message"><p>' . sprintf(__('Items deleted: %d', 'td-helper'), count($ids)) . '</p></div>';
}else{
$message = '<div class="updated below-h2" id="message"><p>' . sprintf(__('Item deleted %d', 'td-helper'),1) . '</p></div>';
}
}
?>
<div class="wrap">
    <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
    <h2><?php _e('Crypto Table ', 'td-helper')?> <a class="add-new-h2"
    href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=add-td-helper');?>"><?php _e('Add new', 'td-helper')?></a>
    </h2>
<div style="padding: 1px 1px; margin:0px auto; background-color: white; text-align: center;">
    <p style="color: green;">Please use shortcode <b style="color: red;">[td-crypto-table]</b> too display this table in your post or page.</p>
</div> 
    <?php echo $message; ?>
    <form id="datas-table" method="POST">
        <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
        <?php $table->display() ?>
    </form>
</div>
<?php
}
endif;
if (!function_exists('td_crypto_datas_form_page_handler_cb')):
function td_crypto_datas_form_page_handler_cb()
{
global $wpdb;
$table_name = $wpdb->prefix . 'td_helper_crypto_table';
$message = '';
$notice = '';
$default = array(
'id' => 0,
'name' => '',
'action' => '',
'price_entry' => null,
'stop_loss'   => null,
'price_target' => '',
'day_in_market' => '',
'position_size' => '',
);
if ( isset($_REQUEST['nonce']) && wp_verify_nonce($_REQUEST['nonce'], basename(__FILE__))) {
$item = shortcode_atts($default, $_REQUEST);
$item_valid = td_crypto_validate_datas($item);
if ($item_valid === true) {
if ($item['id'] == 0) {
$result = $wpdb->insert($table_name, $item);
$item['id'] = $wpdb->insert_id;
if ($result) {
$message = __('Item was successfully saved', 'td-helper');
} else {
$notice = __('There was an error while saving item', 'td-helper');
}
} else {
$result = $wpdb->update($table_name, $item, array('id' => $item['id']));
if ($result) {
$message = __('Item was successfully updated', 'td-helper');
} else {
$notice = __('There was an error while updating item', 'td-helper');
}
}
} else {
$notice = $item_valid;
}
}
else {
$item = $default;
if (isset($_REQUEST['id'])) {
$item = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $_REQUEST['id']), ARRAY_A);
if (!$item) {
$item = $default;
$notice = __('Item not found', 'td-helper');
}
}
}
add_meta_box('datas_form_meta_box', __('Add Data', 'td-helper'), 'td_crypto_datas_form_meta_box_handler_cb', 'data', 'normal', 'default');
?>
<div class="wrap">
    <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
    <h2><?php _e('Adding Crypto Data', 'td-helper')?> <a class="add-new-h2"
    href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=td-helper');?>"><?php _e('Back to list/ View page', 'td-helper')?></a>
    </h2>
    <?php if (!empty($notice)): ?>
    <div id="notice" class="error"><p><?php echo $notice ?></p></div>
    <?php endif;?>
    <?php if (!empty($message)): ?>
    <div id="message" class="updated"><p><?php echo $message ?></p></div>
    <?php endif;?>
    <!-- ==========    Start form to insert meta data ======== -->
    <form id="form" method="POST">
        <input type="hidden" name="nonce" value="<?php echo wp_create_nonce(basename(__FILE__))?>"/>
        
        <input type="hidden" name="id" value="<?php echo $item['id'] ?>"/>
        <div class="metabox-holder" id="poststuff">
            <div id="post-body">
                <div id="post-body-content">
                    
                    <?php do_meta_boxes('data', 'normal', $item); ?>
                    <input type="submit" value="<?php _e('Save Currency Data', 'td-helper')?>" id="submit" class="button-primary" name="submit">
                </div>
            </div>
        </div>
    </form>
</div>
<?php
}
endif;
// <!-- ==========    Start form to insert meta data ======== -->
if (!function_exists('td_crypto_datas_form_meta_box_handler_cb')):
function td_crypto_datas_form_meta_box_handler_cb($item)
{
?>
<tbody >
    
    <div class="formdatabc">
        <div class="form2bc">
            <p class="fxinput">
                <label for="name"><?php _e('Currency Name:', 'td-helper')?></label>
                <br>
                <input oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);" id="name" name="name" type="text" value="<?php echo esc_attr($item['name'])?>">
            </p>
            <p class="fxinput">
                <label for="action"><?php _e('Action:', 'td-helper')?></label>
                <br>
                <input oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);"  id="action" name="action" type="text" value="<?php echo esc_attr($item['action'])?>">
            </p>
            <p class="fxinput">
                <label for="price_entry"><?php _e('Entry Price:', 'td-helper')?></label>
                <br>
                <input id="price_entry" name="price_entry" type="text" value="<?php echo esc_attr($item['price_entry'])?>">
            </p>
            <p class="fxinput">
                <label for="stop_loss"><?php _e(' Stop Loss:', 'td-helper')?></label>
                <br>
                <input id="stop_loss" name="stop_loss" type="text" value="<?php echo esc_attr($item['stop_loss'])?>">
            </p>
            <p class="fxinput">
                <label for="price_target"><?php _e('targeted:', 'td-helper')?></label>
                <br>
                <input id="price_target" name="price_target" type="text" value="<?php echo esc_attr($item['price_target'])?>">
            </p>
            <p class="fxinput">
                <label for="day_in_market"><?php _e('Day In Market:', 'td-helper')?></label>
                <br>
                <input id="day_in_market" name="day_in_market" type="text" value="<?php echo esc_attr($item['day_in_market'])?>">
            </p>
            <p class="fxinput">
                <label for="position_size"><?php _e('Position :', 'td-helper')?></label>
                <br>
                <input id="position_size" name="position_size" type="text" value="<?php echo esc_attr($item['position_size'])?>">
            </p>
        </div>
    </form>
</div>
</tbody>
<?php
}
endif;