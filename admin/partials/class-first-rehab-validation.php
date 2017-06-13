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
 * Simple function that validates data and retrieve bool on success
 * and error message(s) on error
 *
 * @param $item
 * @return bool|string
 */

class first_rehab_validation {
public function __construct() {
		
function custom_table_frpa_validate_person($item)
{
    $messages = array();

    if (empty($item['clientname'])) $messages[] = __('Client name is required', 'custom_table_frpa');
    if (!empty($item['contactemail']) && !is_email($item['contactemail'])) $messages[] = __('E-Mail is in wrong format', 'custom_table_frpa');
    if (empty($item['solicitorname'])) $messages[] = __('Solicitor is required', 'custom_table_frpa');	
    if (empty($item['feeearnername'])) $messages[] = __('Fee Earner is required', 'custom_table_frpa');	
    // if (!ctype_digit($item['telephone'])) $messages[] = __('Telephone in wrong format', 'custom_table_frpa');
    //...

    if (empty($messages)) return true;
    return implode('<br />', $messages);

}
}
}

$obj = new first_rehab_validation;