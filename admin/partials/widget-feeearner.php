<?php
function fee_earner_add_dashboard_widgets() {

	 wp_add_dashboard_widget(
                 'fee_earner_dashboard_widget',         // Widget slug.
                 'Add Fee Earner',         // Title.
                 'fee_earner_dashboard_widget_function' // Display function.
        );	
		
// add_meta_box( 'fee_earner_dashboard_widget', 'Add Fee Earner', 'fee_earner_dashboard_widget_function', 'dashboard', 'side', 'high' );

}
add_action( 'wp_dashboard_setup', 'fee_earner_add_dashboard_widgets' );

/**
 * Create the function to output the contents of our Dashboard Widget.
 */
function fee_earner_dashboard_widget_function() {
	// Display whatever it is you want to show.

    global $wpdb;
    $table_frfe = $wpdb->prefix . 'frfeeearner'; // do not forget about tables prefix

    $message = '';
    $notice = '';

    // this is default $item which will be used for new records
    $default = array(
        'id' => 0,
        'feeearnername' => '',
        'feeearneraddress' => '',
        'feeearnerpostalcode' => '',
        'solicitorname' => '',		
    );

    // here we are verifying does this request is post back and have correct nonce
    if (wp_verify_nonce($_REQUEST['nonce'], basename(__FILE__))) {
        // combine our default item with request params
        $item = shortcode_atts($default, $_REQUEST);
        // validate data, and if all ok save item to database
        // if id is zero insert otherwise update
        $item_valid = custom_table_frfe_validate_feeearner($item);
        if ($item_valid === true) {
            if ($item['id'] == 0) {
                $result = $wpdb->insert($table_frfe, $item);
                $item['id'] = $wpdb->insert_id;
                if ($result) {
                    $message = __('Item was successfully saved', 'custom_table_frfe');
                } else {
                    $notice = __('There was an error while saving item', 'custom_table_frfe');
                }
            } else {
                $result = $wpdb->update($table_frfe, $item, array('id' => $item['id']));
                if ($result) {
                    $message = __('Item was successfully updated', 'custom_table_frfe');
                } else {
                    $notice = __('There was an error while updating item', 'custom_table_frfe');
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
            $item = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_frfe WHERE id = %d", $_REQUEST['id']), ARRAY_A);
            if (!$item) {
                $item = $default;
            //    $notice = __('Item not found', 'custom_table_frfe');
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
            <label for="feeearnername"><?php _e('Fee Earner Name', 'custom_table_frfe')?></label>
        </th>
        <td>
            <input id="feeearnername" name="feeearnername" type="text" style="width: 95%" value="<?php // echo esc_attr($item['feeearnername'])?>"
                   size="50" class="code" placeholder="<?php _e('', 'custom_table_frfe')?>" >
        </td>
    </tr>
	<tr class="form-field">
        <th valign="top" scope="row">
            <label for="feeearneraddress"><?php _e('Fee Earner Address', 'custom_table_frfe')?></label>
        </th>
        <td>
            <input id="feeearneraddress" name="feeearneraddress" type="text" style="width: 95%" value="<?php // echo esc_attr($item['feeearneraddress'])?>"
                   size="50" class="code" placeholder="<?php _e('', 'custom_table_frfe')?>" >
        </td>
    </tr>
	<tr class="form-field">
        <th valign="top" scope="row">
            <label for="feeearnerpostalcode"><?php _e('Postal Code', 'custom_table_frfe')?></label>
        </th>
        <td>
            <input id="feeearnerpostalcode" name="feeearnerpostalcode" type="text" style="width: 95%" value="<?php // echo esc_attr($item['feeearnerpostalcode'])?>"
                   size="50" class="code" placeholder="<?php _e('', 'custom_table_frfe')?>" >
        </td>
    </tr>
	
	
	
		<tr class="form-field">
		    <th valign="top" scope="row">
            <label for="title"><?php _e('Solicitor', 'custom_table_frfe')?></label>
        </th>
        <td>
		<?php
        global $wpdb;
        // Add table name as variable to include prefix  
	    $frsolicitor = $wpdb->prefix . 'frsolicitor';
		$results =  $wpdb->get_results("SELECT `solicitorname` FROM $frsolicitor ");


    /** Loop through the $results and add each as a dropdown option */
    // $options = '';
    foreach($results as $result) :

        $options.= sprintf("\t".'<option value="%1$s">%2$s</option>'."\n", $result->ID, $result->solicitorname);

    endforeach;

    /** Output the dropdown */
    echo '<select id="solicitorname" name="solicitorname" type="text" style="width: 95%" value="">'."\n";
    echo $options;
    echo '</select>'."\n\n";

// endif; 

    ?>

         </td>
         </tr>
	
	
	
	
	
	
	
	
	
    </tbody>
</table>
                    <input type="submit" value="<?php _e('Save', 'custom_table_frfe')?>" id="submit" class="button-primary" name="submit">
					
                </div>
            </div>
        </div>
    </form>

  <?php
}