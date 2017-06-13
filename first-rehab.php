<?php

/**
 *
 * @link              http://trepidation.co.uk
 * @since             1.0.0
 * @package           first_rehab
 *
 * @wordpress-plugin
 * Plugin Name:       First Rehab Plugin
 * Plugin URI:        http://trepidation.co.uk
 * Description:       First Rehab Plugin.
 * Version:           1.0.0
 * Author:            Colin Gell
 * Author URI:        First Rehab Plugin
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       first-rehab
 * Domain Path:       /languages
 * Network:           True
 */

 
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-first-rehab-activator.php
 */
function activate_first_rehab() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-first-rehab-activator.php';
	first_rehab_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-first-rehab-deactivator.php
 */
function deactivate_first_rehab() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-first-rehab-deactivator.php';
	first_rehab_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_first_rehab' );
register_deactivation_hook( __FILE__, 'deactivate_first_rehab' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-first-rehab.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_first_rehab() {

	$plugin = new first_rehab();
	$plugin->run();

}
run_first_rehab(); 