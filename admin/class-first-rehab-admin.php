<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://trepidation.co.uk
 * @since      1.0.0
 *
 * @package    first_rehab
 * @subpackage first_rehab/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    first_rehab
 * @subpackage first_rehab/admin
 * @author     Your Name <email@example.com>
 */
class first_rehab_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $first_rehab    The ID of this plugin.
	 */
	private $first_rehab;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $first_rehab       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $first_rehab, $version ) {

		$this->first_rehab = $first_rehab;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in first_rehab_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The first_rehab_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->first_rehab, plugin_dir_url( __FILE__ ) . 'css/first-rehab-admin.css', array(), $this->version, 'all' );



	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in first_rehab_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The first_rehab_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->first_rehab, plugin_dir_url( __FILE__ ) . 'js/first-rehab-admin.js', array( 'jquery' ), $this->version, false );
        
	}

}




