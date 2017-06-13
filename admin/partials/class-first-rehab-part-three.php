<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://trepidation.co.uk
 * @since      1.0.0
 *
 * @package    first_rehab
 * @subpackage first_rehab/admin/partials
 */


/**
 * PART 3. Admin page
 * ============================================================================
 *
 * In this part you are going to add admin page for custom table
 *
 * http://codex.wordpress.org/Administration_Menus
 */

/**
 * admin_menu hook implementation, will add pages to list persons and to add new one
 */
function custom_table_frpa_admin_menu()
{
    add_menu_page(__('Persons', 'custom_table_frpa'), __('First Rehab Physio Sessions', 'custom_table_frpa'), 'read_private_pages', 'persons', 'custom_table_frpa_persons_page_handler',
'dashicons-star-filled', 14 );
   // add_submenu_page('persons', __('Physio Session clients', 'custom_table_frpa'), __('Physio Sessions', 'custom_table_frpa'), 'read_private_pages', 'persons', 'custom_table_frpa_persons_page_handler');
    // add new will be described in next part
   add_submenu_page('persons', __('Add new physio client', 'custom_table_frpa'), __('Add new', 'custom_table_frpa'), 'read_private_pages', 'persons_form', 'custom_table_frpa_persons_form_page_handler');
	    // Edit will be described in next part
 //  add_submenu_page('persons', __('Add Fee Earner', 'custom_table_frpa'), __('Add Fee Earner', 'custom_table_frpa'), 'read_private_pages', 'persons_fee_earner', 'custom_table_frpa_persons_edit_page_handler');
}

add_action('admin_menu', 'custom_table_frpa_admin_menu');

/**
 * List page handler
 *
 * This function renders our custom table
 * Notice how we display message about successfull deletion
 * Actualy this is very easy, and you can add as many features
 * as you want.
 *
 * Look into /wp-admin/includes/class-wp-*-list-table.php for examples
 */
 
 class first_rehab_part_three {
public function __construct() {
 
function custom_table_frpa_persons_page_handler()
{
    global $wpdb;

    $table = new custom_table_frpa_List_Table();
    $table->prepare_items();

    $message = '';
    if ('delete' === $table->current_action()) {
        $message = '<div class="updated below-h2" id="message"><p>' . sprintf(__('Items deleted: %d', 'custom_table_frpa'), count($_REQUEST['id'])) . '</p></div>';
    }
    ?>
<div class="wrap">

    <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
    <h2><?php _e('Physio Sessions', 'custom_table_frpa')?> <a class="add-new-h2"
                                 href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=persons_form');?>"><?php _e('Add new', 'custom_table_frpa')?></a>
    </h2>
    <?php echo $message; ?>

    <form id="persons-table" method="GET">
        <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
        <?php $table->display() ?>
    </form>

</div>
<?php
}
}
}

$obj = new first_rehab_part_three;
