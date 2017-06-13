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
 * PART 1. Defining Custom Database Table
 * ============================================================================
 *
 * In this part you are going to define custom database table,
 * create it, update, and fill with some dummy data
 *
 * http://codex.wordpress.org/Creating_Tables_with_Plugins
 *
 * In case your are developing and want to check plugin use:
 *
 * DROP TABLE IF EXISTS wp_firstrehab;
 * DELETE FROM wp_options WHERE option_name = 'custom_table_first_rehab_install_data';
 *
 * to drop table and option
 */

/**
 * $custom_table_first_rehab - holds current database version
 * and used on plugin update to sync database tables
 */
 
class first_rehab_part_one {
public function __construct() {
 
global $custom_table_first_rehab;
$custom_table_first_rehab = '1.3'; // version changed from 1.0 to 1.1

/**
 * register_activation_hook implementation
 *
 * will be called when user activates plugin first time
 * must create needed database tables
 */
function custom_table_first_rehab_install()
{
    global $wpdb;
    global $custom_table_first_rehab;

    $table_frpa = $wpdb->prefix . 'firstrehab'; // do not forget about tables prefix

    // sql to create your table
    // NOTICE that:
    // 1. each field MUST be in separate line
    // 2. There must be two spaces between PRIMARY KEY and its name
    //    Like this: PRIMARY KEY[space][space](id)
    // otherwise dbDelta will not work
    $sql = "CREATE TABLE " . $table_frpa . " (
      id int(11) NOT NULL AUTO_INCREMENT,
      name VARCHAR(100) NOT NULL,
      title VARCHAR(100) NOT NULL,	  
      clientname tinytext NOT NULL,
      contactemail VARCHAR(100) NOT NULL,
      telephone int(11) NULL,
      mobile VARCHAR(100) NOT NULL,
      address VARCHAR(100) NOT NULL,
      postcode VARCHAR(100) NOT NULL,
      numberofsessions VARCHAR(100) NOT NULL,
	  numberofcbt VARCHAR(100) NOT NULL,
      priceofsessions VARCHAR(100) NOT NULL,
	  priceofcbt VARCHAR(100) NOT NULL,
      clientgender VARCHAR(100) NOT NULL,
      clientdob VARCHAR(100) NOT NULL,
      dateofaccident VARCHAR(100) NOT NULL,
      solicitorname VARCHAR(100) NOT NULL,
      feeearnername VARCHAR(100) NOT NULL,
	  solicitorreference VARCHAR (100) NOT NULL,
      firstrehabnotes VARCHAR(100) NOT NULL, 
	  uploadinitial VARCHAR(100) NOT NULL,
      uploadinvoice VARCHAR(100) NOT NULL,
      uploaddischarge VARCHAR(100) NOT NULL,
      PRIMARY KEY  (id)
    );";

    // we do not execute sql directly
    // we are calling dbDelta which cant migrate database
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    // save current database version for later use (on upgrade)
    add_option('custom_table_first_rehab', $custom_table_first_rehab);

    /**
     * [OPTIONAL] Example of updating to 1.1 version
     *
     * If you develop new version of plugin
     * just increment $custom_table_first_rehab variable
     * and add following block of code
     *
     * must be repeated for each new version
     * in version 1.1 we change email field
     * to contain 200 chars rather 100 in version 1.0
     * and again we are not executing sql
     * we are using dbDelta to migrate table changes
     */
    $installed_ver = get_option('custom_table_first_rehab');
    if ($installed_ver != $custom_table_first_rehab) {
        $sql = "CREATE TABLE " . $table_frpa . " (
          id int(11) NOT NULL AUTO_INCREMENT,
          name VARCHAR(100) NOT NULL,		  
          title VARCHAR(100) NOT NULL,	  
           clientname tinytext NOT NULL,
           contactemail VARCHAR(100) NOT NULL,
           telephone int(11) NULL,
           mobile VARCHAR(100) NOT NULL,
           address VARCHAR(100) NOT NULL,
           postcode VARCHAR(100) NOT NULL,
           numberofsessions VARCHAR(100) NOT NULL,
	       numberofcbt VARCHAR(100) NOT NULL,
           priceofsessions VARCHAR(100) NOT NULL,
	       priceofcbt VARCHAR(100) NOT NULL,
           clientgender VARCHAR(100) NOT NULL,
           clientdob VARCHAR(100) NOT NULL,
           dateofaccident VARCHAR(100) NOT NULL,
           solicitorname VARCHAR(100) NOT NULL,
           feeearnername VARCHAR(100) NOT NULL,
	       solicitorreference VARCHAR (100) NOT NULL,
           firstrehabnotes VARCHAR(100) NOT NULL, 
           uploadinitial VARCHAR(100) NOT NULL,
           uploadinvoice VARCHAR(100) NOT NULL,
           uploaddischarge VARCHAR(100) NOT NULL,
           PRIMARY KEY  (id)
        );";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        // notice that we are updating option, rather than adding it
        update_option('custom_table_first_rehab', $custom_table_first_rehab);
    }
}
register_activation_hook(__FILE__, 'custom_table_first_rehab_install');

/**
 * register_activation_hook implementation
 *
 * [OPTIONAL]
 * additional implementation of register_activation_hook
 * to insert some dummy data
 */
function custom_table_first_rehab_install_data()
{
    global $wpdb;

    $table_frpa = $wpdb->prefix . 'firstrehab'; // do not forget about tables prefix

    $wpdb->insert($table_frpa, array(
	    'title' => 'Mr',
        'clientname' => 'Joe Bloggs',
		'telephone' => '0200000000',
        'mobile' => '07700000000',
        'address' => '1 The Street, London',
        'postcode' => 'W1 1AA',
        'contactemail' => 'joebloggs@example.com',
        'numberofsessions' => '1',
		'numberofcbt' => '1',
        'priceofsessions' => '100',
		'priceofcbt' => '150',
     //   'fileupload' => '',
        'clientgender' => 'male',
        'clientdob' => '20/01/2000',
        'dateofaccident' => '01/01/2017',
        'solicitorname' => '',
        'feeearnername' => '',
        'firstrehabnotes' => 'Notes go here...'    
    ));
    $wpdb->insert($table_frpa, array(
	    'title' => 'Mrs',
        'clientname' => 'Jane Doe',
		'telephone' => '0200000000',
        'mobile' => '07700000000',
        'address' => '1 The Street, London',
        'postcode' => 'W1 1AA',
        'contactemail' => 'janedoe@example.com',
        'numberofsessions' => '1',
		'numberofcbt' => '1',
        'priceofsessions' => '100',
		'priceofcbt' => '150',
     //   'fileupload' => '',
        'clientgender' => 'male',
        'clientdob' => '20/01/2000',
        'dateofaccident' => '01/01/2017',
        'solicitorname' => '',
        'feeearnername' => '',
		'solicitorreference' => '',
        'firstrehabnotes' => 'Notes go here...'      
    ));
}

register_activation_hook(__FILE__, 'custom_table_first_rehab_install_data');

/**
 * Trick to update plugin database, see docs
 */
function custom_table_frpa_update_db_check()
{
    global $custom_table_first_rehab;
    if (get_site_option('custom_table_first_rehab') != $custom_table_first_rehab) {
        custom_table_first_rehab_install();
    }
}

add_action('plugins_loaded', 'custom_table_frpa_update_db_check');

}
}

$obj = new first_rehab_part_one;