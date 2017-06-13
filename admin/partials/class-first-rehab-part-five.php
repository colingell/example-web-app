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
 * PART 5. Upload files with thickbox
 * ============================================================================
 *

 */
 
Class WPMU {
/* --------------------------------------------*
* Attributes
* -------------------------------------------- */

/** Refers to a single instance of this class. */

private static $instance = null;

/* Saved options */
public $options;

/* --------------------------------------------*
* Constructor
* -------------------------------------------- */

/**
* Creates or returns an instance of this class.
*
* @return WPMU_Theme_Options A single instance of this class.
*/
public static function get_instance() {

if (null == self::$instance) {
self::$instance = new self;
}

return self::$instance;
}

// end get_instance;

/**
* Initialize the plugin by setting localization, filters, and administration functions.
*/
private function __construct() {
// Add the page to the admin menu.
add_action('admin_menu', array(&$this, 'ink_menu_page'));

// Register javascript.
add_action('admin_enqueue_scripts', array(&$this, 'enqueue_admin_js'));

// Add function on admin initalization.
add_action('admin_init', array(&$this, 'ink_options_setup'));

// Call Function to store value into database.
add_action('init', array(&$this, 'store_in_database'));

// Call Function to delete image.
add_action('init', array(&$this, 'delete_image'));

// Call Function to delete discharge
add_action('init', array(&$this, 'delete_discharge'));

// Call Function to delete invoice
add_action('init', array(&$this, 'delete_invoice'));

// Call Function to delete initial consultation
add_action('init', array(&$this, 'delete_consultation'));


// Add CSS rule.
add_action('admin_enqueue_scripts', array(&$this, 'add_stylesheet'));
}

/* --------------------------------------------*
* Functions
* -------------------------------------------- */

/**
* Function will add option page under Appearance Menu.
*/
public function ink_menu_page() {
add_theme_page('media_uploader', 'Media Uploader', 'edit_theme_options', 'media_page', array($this, 'media_uploader'));
}

//Function that will display the options page.

public function media_uploader() {
global $wpdb;
$img_path = get_option('ink_image');
$upload_initial = get_option('upload_initial');
$upload_invoice = get_option('upload_invoice');
$upload_discharge = get_option('upload_discharge');
?>

<?php
}

//Call three JavaScript library (jquery, media-upload and thickbox) and one CSS for thickbox in the admin head.

public function enqueue_admin_js() {
wp_enqueue_script('media-upload'); //Provides all the functions needed to upload, validate and give format to files.
wp_enqueue_script('thickbox'); //Responsible for managing the modal window.
wp_enqueue_style('thickbox'); //Provides the styles needed for this window.
wp_enqueue_script('script', plugins_url('upload.js', __FILE__), array('jquery'), '', true); //It will initialize the parameters needed to show the window properly.
}

//Function that will add stylesheet file.
public function add_stylesheet(){
wp_enqueue_style( 'stylesheet', plugins_url( 'img-stylesheet.css', __FILE__ ));
}

// Here it check the pages that we are working on are the ones used by the Media Uploader.
public function ink_options_setup() {
global $pagenow;
if ('media-upload.php' == $pagenow || 'async-upload.php' == $pagenow) {
// Now we will replace the 'Insert into Post Button inside Thickbox'
add_filter('gettext', array($this, 'replace_window_text'), 1, 2);
// gettext filter and every sentence.
}
}

/*
* Referer parameter in our script file is for to know from which page we are launching the Media Uploader as we want to change the text "Insert into Post".
*/
function replace_window_text($translated_text, $text) {
if ('Insert into Post' == $text) {
$referer = strpos(wp_get_referer(), 'media_page');
if ($referer != '') {
return __('Upload File', 'ink');
}
}
return $translated_text;
}



// The Function store image path in option table.
public function store_in_database(){
	
if(isset($_POST['submit'])){
$image_path = $_POST['path'];
update_option('ink_image', $image_path);
update_option('upload_initial', $upload_initial);
update_option('upload_invoice', $upload_invoice);
update_option('upload_discharge', $upload_discharge);
}


}



// Below Function will delete image.
function delete_image() {
if(isset($_POST['remove'])){
global $wpdb;
$img_path = $_POST['path'];


// We need to get the images meta ID.
$query = "SELECT ID FROM wp_posts where guid = '" . esc_url($img_path) . "' AND post_type = 'attachment'";
$results = $wpdb->get_results($query);

// And delete it
foreach ( $results as $row ) {
wp_delete_attachment( $row->ID ); //delete the image and also delete the attachment from the Media Library.
}
delete_option('ink_image'); //delete image path from database.
}
}

// Below Function will delete invoice.
function delete_invoice() {
if(isset($_POST['remove-two'])){
global $wpdb;
$upload_invoice = $_POST['path-two'];

// We need to get the images meta ID.
$query = "SELECT ID FROM wp_posts where guid = '" . esc_url($upload_invoice) . "' AND post_type = 'attachment'";
$results = $wpdb->get_results($query);

// And delete it
foreach ( $results as $row ) {
wp_delete_attachment( $row->ID ); //delete the image and also delete the attachment from the Media Library.
}
delete_option('upload_invoice'); //delete image path from database.
}
}

// Below Function will delete initial consultation.
function delete_consultation() {
if(isset($_POST['remove-one'])){
global $wpdb;
$upload_initial = $_POST['path-one'];

// We need to get the images meta ID.
$query = "SELECT ID FROM wp_posts where guid = '" . esc_url($upload_initial) . "' AND post_type = 'attachment'";
$results = $wpdb->get_results($query);

// And delete it
foreach ( $results as $row ) {
wp_delete_attachment( $row->ID ); //delete the image and also delete the attachment from the Media Library.
}
delete_option('upload_initial'); //delete image path from database.
}
}

// Below Function will delete discharge.
function delete_discharge() {
if(isset($_POST['remove-three'])){
global $wpdb;
$upload_discharge = $_POST['path-three'];

// We need to get the images meta ID.
$query = "SELECT ID FROM wp_posts where guid = '" . esc_url($upload_discharge) . "' AND post_type = 'attachment'";
$results = $wpdb->get_results($query);

// And delete it
foreach ( $results as $row ) {
wp_delete_attachment( $row->ID ); //delete the image and also delete the attachment from the Media Library.
}
delete_option('upload_discharge'); //delete image path from database.
}
}

}
// End class

WPMU::get_instance();

?>
