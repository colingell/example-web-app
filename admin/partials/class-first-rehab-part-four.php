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
 * PART 4. Form for adding and or editing row
 * ============================================================================
 *
 * In this part you are going to add admin page for adding and or editing items
 * You cant put all form into this function, but in this example form will
 * be placed into meta box, and if you want you can split your form into
 * as many meta boxes as you want
 *
 * http://codex.wordpress.org/Data_Validation
 * http://codex.wordpress.org/Function_Reference/selected
 */

/**
 * Form page handler checks is there some data posted and tries to save it
 * Also it renders basic wrapper in which we are callin meta box render
 */
 
 class first_rehab_part_four {
public function __construct() {
 
function custom_table_frpa_persons_form_page_handler()
{
    global $wpdb;
    $table_frpa = $wpdb->prefix . 'firstrehab'; // do not forget about tables prefix

    $message = '';
    $notice = '';

    // this is default $item which will be used for new records
    $default = array(
        'id' => 0,
		'name' => '',
		'title' => '',
        'clientname' => '',
		'telephone' => '',
        'mobile' => '',
        'address' => '',
        'postcode' => '',
        'contactemail' => '',
        'numberofsessions' => '',
		'numberofcbt' => '',
        'priceofsessions' => '',
		'priceofcbt' => '',
      //  'fileupload' => '',
        'clientgender' => '',
        'clientdob' => '',
        'dateofaccident' => '',
        'solicitorname' => '',
        'feeearnername' => '',
		'solicitorreference' => '',
        'firstrehabnotes' => '',
		'upload_initial' => '',
		'upload_invoice' => '',
		'upload_discharge' => ''
    );

    // here we are verifying does this request is post back and have correct nonce
    if (wp_verify_nonce($_REQUEST['nonce'], basename(__FILE__)))
		{    
        // combine our default item with request params
        $item = shortcode_atts($default, $_REQUEST);
        // validate data, and if all ok save item to database
        // if id is zero insert otherwise update
        $item_valid = custom_table_frpa_validate_person($item);
        if ($item_valid === true) {
            if ($item['id'] == 0) {
                $result = $wpdb->insert($table_frpa, $item);
                $item['id'] = $wpdb->insert_id;
                if ($result) {
                    $message = __('Item was successfully saved', 'custom_table_frpa');
                } else {
                    $notice = __('There was an error while saving item', 'custom_table_frpa');
                }
            } else {
                $result = $wpdb->update($table_frpa, $item, array('id' => $item['id']));
                if ($result) {
                    $message = __('Item was successfully updated', 'custom_table_frpa');
                } else {
                    $notice = __('There was an error while updating item', 'custom_table_frpa');
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
            $item = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_frpa WHERE id = %d", $_REQUEST['id']), ARRAY_A);
            if (!$item) {
                $item = $default;
                $notice = __('Item not found', 'custom_table_frpa');
            }
        }
    }

    // here we adding our custom meta box
    add_meta_box('persons_form_meta_box', 'Client data', 'custom_table_frpa_persons_form_meta_box_handler', 'person', 'normal', 'default');

    ?>
<div class="wrap">
    <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
    <h2><?php _e('Physio Client', 'custom_table_frpa')?> <a class="add-new-h2"
                                href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=persons');?>"><?php _e('back to list', 'custom_table_frpa')?></a>
    </h2>

    <?php if (!empty($notice)): ?>
    <div id="notice" class="error"><p><?php echo $notice ?></p></div>
    <?php endif;?>
    <?php if (!empty($message)): ?>
    <div id="message" class="updated"><p><?php echo $message ?></p></div>
    <?php endif;?>

    <form id="form" method="POST">
        <input type="hidden" name="nonce" value="<?php echo wp_create_nonce(basename(__FILE__))?>"/>
        <?php /* NOTICE: here we storing id to determine will be item added or updated */ ?>
        <input type="hidden" name="id" value="<?php echo $item['id'] ?>"/>

        <div class="metabox-holder" id="poststuff">
            <div id="post-body">
                <div id="post-body-content">
                    <?php /* And here we call our custom meta box */ ?>
                    <?php do_meta_boxes('person', 'normal', $item); ?>
                    <input type="submit" value="<?php _e('Save', 'custom_table_frpa')?>" id="submit" class="button-primary" name="submit">
                </div>
            </div>
        </div>
    </form>
</div>
<?php
}

/**
 * This function renders our custom meta box
 * $item is row
 *
 * @param $item
 */
function custom_table_frpa_persons_form_meta_box_handler($item)
{
    

?>


<table cellspacing="2" cellpadding="5" style="width: 100%;" class="form-table">
    <tbody>
	
<tr valign="top">
<th scope="row">Upload Initial Consultation</th>
<td><label for="upload_initial">
<input id="upload_initial" type="text" size="36" name="upload_initial" value="<?php echo esc_attr($item['upload_initial'])?>" />
<input id="upload_image_button_one" type="button" value="Upload Initial Consultation" />
<br />Enter an URL or upload an image for the banner.<br />
</label></td>
</tr>

<tr valign="top">
<th scope="row">Upload Invoice</th>
<td><label for="upload_invoice">
<input id="upload_invoice" type="text" size="36" name="upload_invoice" value="<?php echo esc_attr($item['upload_invoice'])?>" />
<input id="upload_image_button_two" type="button" value="Upload Invoice" />
<br />Enter an URL or upload an image for the banner.<br />
</label></td>
</tr>

<tr valign="top">
<th scope="row">Upload Discharge</th>
<td><label for="upload_discharge">
<input id="upload_discharge" type="text" size="36" name="upload_discharge" value="<?php echo esc_attr($item['upload_discharge'])?>" />
<input id="upload_image_button_three" type="button" value="Upload Discharge Form" />
<br />Enter an URL or upload an image for the banner.<br />
</label></td>
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

        $options.= sprintf("\t".'<option ="%1$s">%2$s</option>'."\n", $result->ID, $result->solicitorname);

    endforeach;

    /** Output the dropdown */
    echo '<select id="solicitorname" name="solicitorname" type="text" style="width: 95%" value="'; 
	echo esc_attr($item['solicitorname']); 
	echo'">';
	echo '<option selected="selected">'; echo esc_attr($item['solicitorname']); echo '</option>';
    echo $options;
    echo '</select>'."\n\n";

// endif; 

    ?>

         </td>
         </tr>
		 
		 <tr class="form-field">
		    <th valign="top" scope="row">
            <label for="title"><?php _e('Fee Earner', 'custom_table_frfe')?></label>
        </th>
        <td>
		<?php
        global $wpdb;
        // Add table name as variable to include prefix 		
        $frfeeearner = $wpdb->prefix . 'frfeeearner';
		$solresults =  $wpdb->get_results("SELECT `feeearnername` FROM $frfeeearner ");


    /** Loop through the $results and add each as a dropdown option */
    // $options = '';
    foreach($solresults as $solresult) :

        $feeoptions.= sprintf("\t".'<option ="%1$s">%2$s</option>'."\n", $feeresult->ID, $solresult->feeearnername);

    endforeach;

    /** Output the dropdown */
    echo '<select id="feeearnername" name="feeearnername" type="text" style="width: 95%" value="'; 
	echo esc_attr($item['feeearnername']); 
	echo'">';
	echo '<option selected="selected">'; echo esc_attr($item['feeearnername']); echo '</option>';
    echo $feeoptions;
    echo '</select>'."\n\n";
//  endif; 

    ?>

         </td>
         </tr>

	
	<tr class="form-field">
        <th valign="top" scope="row">
            <label for="title"><?php _e('Title', 'custom_table_frpa')?></label>
        </th>
        <td>
			<select id="title" name="title" type="text" style="width: 95%" value="<?php echo esc_attr($item['title'])?>">
            <option>Mr</option>
            <option>Mrs</option>
            <option>Miss</option>
            <option>Ms</option>
			<option>Dr</option>
			<option>Prof</option>
			<option>Sir</option>
			<option>Dame</option>
			<option>Lieutenant</option>
			<option>Sgt</option>
			<option>Major</option>
            </select>
        </td>
    </tr>
    <tr class="form-field">
        <th valign="top" scope="row">
            <label for="clientname"><?php _e('Client Name', 'custom_table_frpa')?></label>
        </th>
        <td>
            <input id="clientname" name="clientname" type="text" style="width: 95%" value="<?php echo esc_attr($item['clientname'])?>"
                   size="50" class="code" placeholder="<?php _e('Client Name', 'custom_table_frpa')?>" >
        </td>
    </tr>
	    <tr class="form-field">
        <th valign="top" scope="row">
            <label for="telephone"><?php _e('Telephone Number', 'custom_table_frpa')?></label>
        </th>
        <td>
            <input id="telephone" name="telephone" type="tel" style="width: 95%" value="<?php echo esc_attr($item['telephone'])?>"
                   size="50" class="code" placeholder="<?php _e('0200 000 000', 'custom_table_frpa')?>" >
        </td>
    </tr>
	<tr class="form-field">
        <th valign="top" scope="row">
            <label for="mobile"><?php _e('Mobile Number', 'custom_table_frpa')?></label>
        </th>
        <td>
            <input id="mobile" name="mobile" type="tel" style="width: 95%" value="<?php echo esc_attr($item['mobile'])?>"
                   size="50" class="code" placeholder="<?php _e('07700000000', 'custom_table_frpa')?>" >
        </td>
    </tr>
	<tr class="form-field">
        <th valign="top" scope="row">
            <label for="address"><?php _e('Client Address', 'custom_table_frpa')?></label>
        </th>
        <td>
            <textarea id="address" name="address" type="textarea" style="width: 95%; height: 125px;" value="<?php echo esc_attr($item['address'])?>"
                   size="200" rows="4" class="code" placeholder="<?php _e('Address goes here', 'custom_table_frpa')?>" ><?php echo esc_attr($item['address'])?></textarea>
        </td>
    </tr>
	<tr class="form-field">
        <th valign="top" scope="row">
            <label for="postcode"><?php _e('Postal Code', 'custom_table_frpa')?></label>
        </th>
        <td>
            <input id="postcode" name="postcode" type="text" style="width: 95%" value="<?php echo esc_attr($item['postcode'])?>"
                   size="50" class="code" placeholder="<?php _e('XX1 1XX', 'custom_table_frpa')?>" >
        </td>
    </tr>
	<tr class="form-field">
        <th valign="top" scope="row">
            <label for="contactemail"><?php _e('Contact E-mail', 'custom_table_frpa')?></label>
        </th>
        <td>
            <input id="contactemail" name="contactemail" type="email" style="width: 95%" value="<?php echo esc_attr($item['contactemail'])?>"
                   size="50" class="code" placeholder="<?php _e('example@example.com', 'custom_table_frpa')?>" >
        </td>
    </tr>
	<tr class="form-field">
        <th valign="top" scope="row">
            <label for="numberofsessions"><?php _e('Number of physio sessions', 'custom_table_frpa')?></label>
        </th>
        <td>
            <input id="numberofsessions" name="numberofsessions" type="number" style="width: 95%" value="<?php echo esc_attr($item['numberofsessions'])?>"
                   size="50" class="code" placeholder="<?php _e('1', 'custom_table_frpa')?>" >
        </td>
    </tr>
	
	<tr class="form-field">
        <th valign="top" scope="row">
            <label for="numberofcbt"><?php _e('Number of CBT sessions', 'custom_table_frpa')?></label>
        </th>
        <td>
            <input id="numberofcbt" name="numberofcbt" type="number" style="width: 95%" value="<?php echo esc_attr($item['numberofcbt'])?>"
                   size="50" class="code" placeholder="<?php _e('1', 'custom_table_frpa')?>" >
        </td>
    </tr>
	
	<tr class="form-field">
        <th valign="top" scope="row">
            <label for="priceofsessions"><?php _e('Price of physio sessions', 'custom_table_frpa')?></label>
        </th>
        <td>
            <input id="priceofsessions" name="priceofsessions" type="number" style="width: 95%" value="<?php echo esc_attr($item['priceofsessions'])?>"
                   size="50" class="code" placeholder="<?php _e('100', 'custom_table_frpa')?>" >
        </td>
    </tr>
	
		<tr class="form-field">
        <th valign="top" scope="row">
            <label for="priceofcbt"><?php _e('Price of CBT sessions', 'custom_table_frpa')?></label>
        </th>
        <td>
            <input id="priceofcbt" name="priceofcbt" type="number" style="width: 95%" value="<?php echo esc_attr($item['priceofcbt'])?>"
                   size="50" class="code" placeholder="<?php _e('150', 'custom_table_frpa')?>" >
        </td>
    </tr>
	

	<tr class="form-field">
        <th valign="top" scope="row">
            <label for="clientgender"><?php _e('Gender', 'custom_table_frpa')?></label>
        </th>
        <td>
         	<select id="clientgender" name="clientgender" type="text" style="width: 95%" value="<?php echo esc_attr($item['clientgender'])?>">                   
            <option>Male</option>
            <option>Female</option>
            <option>Transgender</option>
            <option>Non-binary</option>
			<option>Not disclosed</option>
			<option>Refused</option>
            </select>	   
        </td>
    </tr>
	<tr class="form-field">
        <th valign="top" scope="row">
            <label for="clientdob"><?php _e('Date of Birth', 'custom_table_frpa')?></label>
        </th>
        <td>
            <input id="clientdob" name="clientdob" type="date" style="width: 95%" value="<?php echo esc_attr($item['clientdob'])?>"
                   class="code" >
        </td>
    </tr>
	
	<tr class="form-field">
        <th valign="top" scope="row">
            <label for="dateofaccident"><?php _e('Date of Accident', 'custom_table_frpa')?></label>
        </th>
        <td>
            <input id="dateofaccident" name="dateofaccident" type="date" style="width: 95%" value="<?php echo esc_attr($item['dateofaccident'])?>"
                   class="code" >
        </td>
    </tr>
	<tr class="form-field">
        <th valign="top" scope="row">
            <label for="solicitorreference"><?php _e('Solicitor Reference', 'custom_table_frpa')?></label>
        </th>
        <td>
            <input id="solicitorreference" name="solicitorreference" type="text" style="width: 95%" value="<?php echo esc_attr($item['solicitorreference'])?>"
                   size="50" class="code" placeholder="<?php _e('', 'custom_table_frpa')?>" >
        </td>
    </tr>

	<tr class="form-field">
        <th valign="top" scope="row">
            <label for="firstrehabnotes"><?php _e('Client Notes', 'custom_table_frpa')?></label>
        </th>
        <td>
<textarea id="firstrehabnotes" name="firstrehabnotes" type="textarea" style="width: 95%; height: 125px;" value="<?php echo esc_attr($item['firstrehabnotes'])?>"
                   size="200" rows="4" class="code" placeholder="<?php _e('Notes go here' ,'custom_table_frpa')?>" > <?php echo esc_attr($item['firstrehabnotes'])?></textarea>
        </td>
    </tr>
    </tbody>
</table>
<?php
}
}
}

$obj = new first_rehab_part_four;