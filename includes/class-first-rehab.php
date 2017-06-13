<?php



/**

 * The file that defines the core plugin class

 *

 * A class definition that includes attributes and functions used across both the

 * public-facing side of the site and the admin area.

 *

 * @link       http://trepidation.co.uk

 * @since      1.0.0

 *

 * @package    first_rehab

 * @subpackage first_rehab/includes

 */



/**

 * The core plugin class.

 *

 * This is used to define internationalization, admin-specific hooks, and

 * public-facing site hooks.

 *

 * Also maintains the unique identifier of this plugin as well as the current

 * version of the plugin.

 *

 * @since      1.0.0

 * @package    first_rehab

 * @subpackage first_rehab/includes

 * @author     Colin Gell <colin@trepidation.co.uk>

 */

class first_rehab {



	/**

	 * The loader that's responsible for maintaining and registering all hooks that power

	 * the plugin.

	 *

	 * @since    1.0.0

	 * @access   protected

	 * @var      first_rehab_Loader    $loader    Maintains and registers all hooks for the plugin.

	 */

	protected $loader;



	/**

	 * The unique identifier of this plugin.

	 *

	 * @since    1.0.0

	 * @access   protected

	 * @var      string    $first_rehab    The string used to uniquely identify this plugin.

	 */

	protected $first_rehab;



	/**

	 * The current version of the plugin.

	 *

	 * @since    1.0.0

	 * @access   protected

	 * @var      string    $version    The current version of the plugin.

	 */

	protected $version;



	/**

	 * Define the core functionality of the plugin.

	 *

	 * Set the plugin name and the plugin version that can be used throughout the plugin.

	 * Load the dependencies, define the locale, and set the hooks for the admin area and

	 * the public-facing side of the site.

	 *

	 * @since    1.0.0

	 */

	public function __construct() {



		$this->first_rehab = 'first-rehab';

		$this->version = '1.0.0';



		$this->load_dependencies();

		$this->set_locale();

		$this->define_admin_hooks();

		$this->define_public_hooks();



	}



	/**

	 * Load the required dependencies for this plugin.

	 *

	 * Include the following files that make up the plugin:

	 *

	 * - first_rehab_Loader. Orchestrates the hooks of the plugin.

	 * - first_rehab_i18n. Defines internationalization functionality.

	 * - first_rehab_Admin. Defines all hooks for the admin area.

	 * - first_rehab_Public. Defines all hooks for the public side of the site.

	 *

	 * Create an instance of the loader which will be used to register the hooks

	 * with WordPress.

	 *

	 * @since    1.0.0

	 * @access   private

	 */

	private function load_dependencies() {



		/**

		 * The class responsible for orchestrating the actions and filters of the

		 * core plugin.

		 */

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-first-rehab-loader.php';



		/**

		 * The class responsible for defining internationalization functionality

		 * of the plugin.

		 */

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-first-rehab-i18n.php';



		/**

		 * The class responsible for defining actions that occur in the admin area.

		 */

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-first-rehab-admin.php';

		

		/**

		 * The class responsible for defining validation actions that occur in the admin area.

		 */

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/class-first-rehab-validation.php';

		

		/**

		 * The class responsible for defining all database table actions that occur in the admin area.

		 */

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/class-first-rehab-part-one.php';



		/**

		 * The class responsible for defining table list actions that occur in the admin area.

		 */

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/class-first-rehab-part-two.php';		



		/**

		 * The class responsible for defining admin menu hook actions that occur in the admin area.

		 */

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/class-first-rehab-part-three.php';

		

		/**

		 * The class responsible for defining adding actions that occur in the admin area.

		 */

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/class-first-rehab-part-four.php';		



		/**

		 * The class responsible for defining editing actions that occur in the admin area.

		 */

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/class-first-rehab-part-five.php';	

		

		/**

		 * The class responsible for defining solicitors form data that occur in the admin area.

		 */

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/first-rehab-solicitors.php';	

		

				/**

		 * The class responsible for defining solicitors form data that occur in the admin area.

		 */

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/first-rehab-feeearner.php';

		

		/**

		 * The class responsible for removing dashboard data that occur in the admin area.

		 */

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/first-rehab-dashboard.php';	



		/**

		 * The class responsible for adding 'add solicitor widget'.

		 */

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/widget-solicitor.php';	

		

		/**

		* The class responsible for adding 'add solicitor widget'.

		 */

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/widget-feeearner.php';

		

		/**

		* The class responsible for adding 'add physio client widget'.

		 */

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/widget-client.php';

		

		/**

		* The class responsible for adding front page login form.

		 */

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/login.php';		

		

		

		/**

		 * The class responsible for defining all actions that occur in the public-facing

		 * side of the site.

		 */

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-first-rehab-public.php';



		$this->loader = new first_rehab_Loader();



	}



	/**

	 * Define the locale for this plugin for internationalization.

	 *

	 * Uses the first_rehab_i18n class in order to set the domain and to register the hook

	 * with WordPress.

	 *

	 * @since    1.0.0

	 * @access   private

	 */

	private function set_locale() {



		$plugin_i18n = new first_rehab_i18n();



		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );



	}



	/**

	 * Register all of the hooks related to the admin area functionality

	 * of the plugin.

	 *

	 * @since    1.0.0

	 * @access   private

	 */

	private function define_admin_hooks() {



		$plugin_admin = new first_rehab_Admin( $this->get_first_rehab(), $this->get_version() );



		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );



	}



	/**

	 * Register all of the hooks related to the public-facing functionality

	 * of the plugin.

	 *

	 * @since    1.0.0

	 * @access   private

	 */

	private function define_public_hooks() {

	   



		$plugin_public = new first_rehab_Public( $this->get_first_rehab(), $this->get_version() );



		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );



		

	}



	/**

	 * Run the loader to execute all of the hooks with WordPress.

	 *

	 * @since    1.0.0

	 */

	public function run() {

		$this->loader->run();

	}



	/**

	 * The name of the plugin used to uniquely identify it within the context of

	 * WordPress and to define internationalization functionality.

	 *

	 * @since     1.0.0

	 * @return    string    The name of the plugin.

	 */

	public function get_first_rehab() {

		return $this->first_rehab;

	}



	/**

	 * The reference to the class that orchestrates the hooks with the plugin.

	 *

	 * @since     1.0.0

	 * @return    first_rehab_Loader    Orchestrates the hooks of the plugin.

	 */

	public function get_loader() {

		return $this->loader;

	}



	/**

	 * Retrieve the version number of the plugin.

	 *

	 * @since     1.0.0

	 * @return    string    The version number of the plugin.

	 */

	public function get_version() {

		return $this->version;

	}



}

// Added this as min-width was popping out in admin area - this is a quick fix solution

add_action('admin_head', 'my_custom_admin_width');

function my_custom_admin_width() {
  echo '<style>
#post-body-content {

    min-width: 100%;

}
  </style>';
}