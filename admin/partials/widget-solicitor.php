
<?php

function first_rehab_add_dashboard_widgets() {

	    wp_add_dashboard_widget(
                 'first_rehab_dashboard_widget',         // Widget slug.
                 'Add Solicitor',         // Title.
                 'first_rehab_dashboard_widget_function' // Display function.
        );
		
	//	add_meta_box( 'first_rehab_dashboard_widget', 'Add Solicitor', 'first_rehab_dashboard_widget_function', 'dashboard', 'side', 'high' );
}
add_action( 'wp_dashboard_setup', 'first_rehab_add_dashboard_widgets' );

/**
 * Create the function to output the contents of our Dashboard Widget.
 */
function first_rehab_dashboard_widget_function() {
	// Display whatever it is you want to show.


    global $wpdb;
    $table_frso = $wpdb->prefix . 'frsolicitor'; // do not forget about tables prefix

    $message = '';
    $notice = '';

    // this is default $item which will be used for new records
    $default = array(
        'id' => 0,
        'solicitorname' => '',
        'solicitoraddress' => '',
        'solicitorpostalcode' => '',
       
    );

    // here we are verifying does this request is post back and have correct nonce
    if (wp_verify_nonce($_REQUEST['nonce'], basename(__FILE__))) {
        // combine our default item with request params
        $item = shortcode_atts($default, $_REQUEST);
        // validate data, and if all ok save item to database
        // if id is zero insert otherwise update
        $item_valid = custom_table_frso_validate_solicitor($item);
        if ($item_valid === true) {
            if ($item['id'] == 0) {
                $result = $wpdb->insert($table_frso, $item);
                $item['id'] = $wpdb->insert_id;
                if ($result) {
                    $message = __('Item was successfully saved', 'custom_table_frso');
                } else {
                    $notice = __('There was an error while saving item', 'custom_table_frso');
                }
            } else {
                $result = $wpdb->update($table_frso, $item, array('id' => $item['id']));
                if ($result) {
                    $message = __('Item was successfully updated', 'custom_table_frso');
                } else {
                    $notice = __('There was an error while updating item', 'custom_table_frso');
                }
            }
        } else {
            // if $item_valid not true it contains error message(s)
            $notice = $item_valid;
        }
    }
    else {
        // if this is not post back we load item to edit or give new one to create
        $item = $default;
        if (isset($_REQUEST['id'])) {
            $item = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_frso WHERE id = %d", $_REQUEST['id']), ARRAY_A);
            if (!$item) {
                $item = $default;
              //  $notice = __('Item not found', 'custom_table_frso');
            }
        }
    }
	?>

    <?php if (!empty($notice)): ?>
    <div id="notice" class="error"><p><?php echo $notice ?></p></div>
    <?php endif;?>
    <?php if (!empty($message)): ?>
    <div id="message" class="updated"><p><?php echo $message ?></p></div>
    <?php endif;?>

    <form id="form" method="GET" >
        <input type="hidden" name="nonce" value="<?php echo wp_create_nonce(basename(__FILE__))?>"/>
        <?php /* NOTICE: here we storing id to determine will be item added or updated */ ?>
        <input type="hidden" name="id" value="<?php // echo $item['id'] ?>"/>

        <div class="metabox-holder" id="poststuff">
            <div id="post-body">
                <div id="post-body-content">
                    <?php /* And here we call our custom meta box */ ?>
                    <table cellspacing="2" cellpadding="5" style="width: 100%;" class="form-table">
    <tbody>
    <tr class="form-field">
        <th valign="top" scope="row">
            <label for="solicitorname"><?php _e('Solicitor Name', 'custom_table_frso')?></label>
        </th>
        <td>
            <input id="solicitorname" name="solicitorname" type="text" style="width: 95%" value="<?php // echo esc_attr($item['solicitorname'])?>"
                   size="50" class="code" placeholder="<?php _e('', 'custom_table_frso')?>" >
        </td>
    </tr>
	<tr class="form-field">
        <th valign="top" scope="row">
            <label for="solicitoraddress"><?php _e('Solicitor Address', 'custom_table_frso')?></label>
        </th>
        <td>
            <input id="solicitoraddress" name="solicitoraddress" type="text" style="width: 95%" value="<?php // echo esc_attr($item['solicitoraddress'])?>"
                   size="50" class="code" placeholder="<?php _e('', 'custom_table_frso')?>" >
        </td>
    </tr>
	<tr class="form-field">
        <th valign="top" scope="row">
            <label for="solicitorpostalcode"><?php _e('Postal Code', 'custom_table_frso')?></label>
        </th>
        <td>
            <input id="solicitorpostalcode" name="solicitorpostalcode" type="text" style="width: 95%" value="<?php // echo esc_attr($item['solicitorpostalcode'])?>"
                   size="50" class="code" placeholder="<?php _e('', 'custom_table_frso')?>" >
        </td>
    </tr>
    </tbody>
</table>
                    <input type="submit" value="<?php _e('Save', 'custom_table_frso')?>" id="submit" class="button-primary" name="submit">
                </div>
            </div>
        </div>
    </form>

  <?php
}