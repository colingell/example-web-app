<?php



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

 * DROP TABLE IF EXISTS wp_frfeeearner;

 * DELETE FROM wp_options WHERE option_name = 'custom_table_fee_earner_install_data';

 *

 * to drop table and option

 */



/**

 * $custom_table_fee_earner - holds current database version

 * and used on plugin update to sync database tables

 */

global $custom_table_fee_earner;

$custom_table_fee_earner = '1.2'; // version changed from 1.0 to 1.1



/**

 * register_activation_hook implementation

 *

 * will be called when user activates plugin first time

 * must create needed database tables

 */

function custom_table_fee_earner_install()

{

    global $wpdb;

    global $custom_table_fee_earner;



    $table_frfe = $wpdb->prefix . 'frfeeearner'; // do not forget about tables prefix



    // sql to create your table

    // NOTICE that:

    // 1. each field MUST be in separate line

    // 2. There must be two spaces between PRIMARY KEY and its name

    //    Like this: PRIMARY KEY[space][space](id)

    // otherwise dbDelta will not work

    $sql = "CREATE TABLE " . $table_frfe . " (

      id int(11) NOT NULL AUTO_INCREMENT,

      feeearnername VARCHAR(100) NOT NULL,

      solicitorname VARCHAR NOT NULL,

      feeearneraddress VARCHAR(100) NOT NULL,

      feeearnerpostalcode VARCHAR(100) NULL,   

      PRIMARY KEY  (id)

    );";



    // we do not execute sql directly

    // we are calling dbDelta which cant migrate database

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    dbDelta($sql);



    // save current database version for later use (on upgrade)

    add_option('custom_table_fee_earner', $custom_table_fee_earner);



    /**

     * [OPTIONAL] Example of updating to 1.1 version

     *

     * If you develop new version of plugin

     * just increment $custom_table_fee_earner variable

     * and add following block of code

     *

     * must be repeated for each new version

     * in version 1.1 we change email field

     * to contain 200 chars rather 100 in version 1.0

     * and again we are not executing sql

     * we are using dbDelta to migrate table changes

     */

    $installed_ver = get_option('custom_table_fee_earner');

    if ($installed_ver != $custom_table_fee_earner) {

        $sql = "CREATE TABLE " . $table_frfe . " (

          id int(11) NOT NULL AUTO_INCREMENT,

          feeearnername VARCHAR(100) NOT NULL,

		  solicitorname VARCHAR(100) NOT NULL,

          feeearneraddress VARCHAR(100) NOT NULL,

          feeearnerpostalcode VARCHAR(100) NOT NULL,      

          PRIMARY KEY  (id)

        );";



        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        dbDelta($sql);



        // notice that we are updating option, rather than adding it

        update_option('custom_table_fee_earner', $custom_table_fee_earner);

    }

}

register_activation_hook(__FILE__, 'custom_table_fee_earner_install');



/**

 * register_activation_hook implementation

 *

 * [OPTIONAL]

 * additional implementation of register_activation_hook

 * to insert some dummy data

 */

function custom_table_fee_earner_install_data()

{

    global $wpdb;



    $table_frfe = $wpdb->prefix . 'frfeeearner'; // do not forget about tables prefix



    $wpdb->insert($table_frfe, array(

        'feeearnername' => 'A1 feeearners',

		'solicitorname' => '',

        'feeearneraddress' => 'Legal Street',

        'feeearnerpostalcode' => 'AA1 1AA',

    ));

    $wpdb->insert($table_frfe, array(

        'feeearnername' => 'A2 feeearners',

		'solicitorname' => '',

        'feeearneraddress' => 'Legal Street',

        'feeearnerpostalcode' => 'AA1 1AA',

   

    ));

}



register_activation_hook(__FILE__, 'custom_table_fee_earner_install_data');



/**

 * Trick to update plugin database, see docs

 */

function custom_table_frfe_update_db_check()

{

    global $custom_table_fee_earner;

    if (get_site_option('custom_table_fee_earner') != $custom_table_fee_earner) {

        custom_table_fee_earner_install();

    }

}



add_action('plugins_loaded', 'custom_table_frfe_update_db_check');



/**

 * PART 2. Defining Custom Table List

 * ============================================================================

 *

 * In this part you are going to define custom table list class,

 * that will display your database records in nice looking table

 *

 * http://codex.wordpress.org/Class_Reference/WP_List_Table

 * http://wordpress.org/extend/plugins/custom-list-table-example/

 */



if (!class_exists('WP_List_Table')) {

    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');

}



/**

 * custom_table_frfe_List_Table class that will display our custom table

 * records in nice table

 */

class custom_table_frfe_List_Table extends WP_List_Table

{

    /**

     * [REQUIRED] You must declare constructor and give some basic params

     */

    function __construct()

    {

        global $status, $page;



        parent::__construct(array(

            'singular' => 'feeearner',

            'plural' => 'feeearners',

        ));

    }



    /**

     * [REQUIRED] this is a default column renderer

     *

     * @param $item - row (key, value array)

     * @param $column_name - string (key)

     * @return HTML

     */

    function column_default($item, $column_name)

    {

        return $item[$column_name];

    }



    /**

     * [OPTIONAL] this is example, how to render specific column

     *

     * method name must be like this: "column_[column_name]"

     *

     * @param $item - row (key, value array)

     * @return HTML

     */

    function column_age($item)

    {

        return '<em>' . $item['age'] . '</em>';

    }



    /**

     * [OPTIONAL] this is example, how to render column with actions,

     * when you hover row "Edit | Delete" links showed

     *

     * @param $item - row (key, value array)

     * @return HTML

     */

    function column_name($item)

    {

        // links going to /admin.php?page=[your_plugin_page][&other_params]

        // notice how we used $_REQUEST['page'], so action will be done on curren page

        // also notice how we use $this->_args['singular'] so in this example it will

        // be something like &feeearner=2

        $actions = array(

            'edit' => sprintf('<a href="?page=feeearners_form&id=%s">%s</a>', $item['id'], __('Edit', 'custom_table_frfe')),

            'delete' => sprintf('<a href="?page=%s&action=delete&id=%s">%s</a>', $_REQUEST['page'], $item['id'], __('Delete', 'custom_table_frfe')),

        );



        return sprintf('%s %s',

            $item['feeearnername'],

            $this->row_actions($actions)

        );

    }



    /**

     * [REQUIRED] this is how checkbox column renders

     *

     * @param $item - row (key, value array)

     * @return HTML

     */

    function column_cb($item)

    {

        return sprintf(

            '<input type="checkbox" name="id[]" value="%s" />',

            $item['id']

        );

    }



    /**

     * [REQUIRED] This method return columns to display in table

     * you can skip columns that you do not want to show

     * like content, or description

     *

     * @return array

     */

    function get_columns()

    {

        $columns = array(           

          'cb' => '<input type="checkbox" />', //Render a checkbox instead of text

		'name' =>  __('Fee Earner Name', 'custom_table_frpa'),			  

    //    'feeearnername' => __('Fee Earner Name', 'custom_table_frfe'),

        'feeearneraddress' => __('Fee Earner Address', 'custom_table_frfe'),

        'feeearnerpostalcode' => __('Fee Earner Postcode', 'custom_table_frfe'),

	    'solicitorname' => __('Solicitor', 'custom_table_frfe'),

        );

        return $columns;

    }



    /**

     * [OPTIONAL] This method return columns that may be used to sort table

     * all strings in array - is column names

     * notice that true on name column means that its default sort

     *

     * @return array

     */

    function get_sortable_columns()

    {

        $sortable_columns = array(

		'name' => array('feeearnername', true),		

        'feeearnername' => array('feeearnername', true),

        'feeearneraddress' => array('feeearneraddress', true),

        'feeearnerpostalcode' => array('feeearnerpostalcode', true),

		'solicitorname' => array('solicitorname', true),

        );

        return $sortable_columns;

    }



    /**

     * [OPTIONAL] Return array of bult actions if has any

     *

     * @return array

     */

    function get_bulk_actions()

    {

        $actions = array(

            'delete' => 'Delete'

        );

        return $actions;

    }



    /**

     * [OPTIONAL] This method processes bulk actions

     * it can be outside of class

     * it can not use wp_redirect coz there is output already

     * in this example we are processing delete action

     * message about successful deletion will be shown on page in next part

     */

    function process_bulk_action()

    {

        global $wpdb;

        $table_frfe = $wpdb->prefix . 'frfeeearner'; // do not forget about tables prefix



        if ('delete' === $this->current_action()) {

            $ids = isset($_REQUEST['id']) ? $_REQUEST['id'] : array();

            if (is_array($ids)) $ids = implode(',', $ids);



            if (!empty($ids)) {

                $wpdb->query("DELETE FROM $table_frfe WHERE id IN($ids)");

            }

        }

    }



    /**

     * [REQUIRED] This is the most important method

     *

     * It will get rows from database and prepare them to be showed in table

     */

    function prepare_items()

    {

        global $wpdb;

        $table_frfe = $wpdb->prefix . 'frfeeearner'; // do not forget about tables prefix



        $per_page = 25; // constant, how much records will be shown per page



        $columns = $this->get_columns();

        $hidden = array();

        $sortable = $this->get_sortable_columns();



        // here we configure table headers, defined in our methods

        $this->_column_headers = array($columns, $hidden, $sortable);



        // [OPTIONAL] process bulk action if any

        $this->process_bulk_action();



        // will be used in pagination settings

        $total_items = $wpdb->get_var("SELECT COUNT(id) FROM $table_frfe");



        // prepare query params, as usual current page, order by and order direction

        $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged']) - 1) : 0;

        $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'feeearnername';

        $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'asc';



        // [REQUIRED] define $items array

        // notice that last argument is ARRAY_A, so we will retrieve array

        $this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_frfe ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);



        // [REQUIRED] configure pagination

        $this->set_pagination_args(array(

            'total_items' => $total_items, // total items defined above

            'per_page' => $per_page, // per page constant defined at top of method

            'total_pages' => ceil($total_items / $per_page) // calculate pages count

        ));

    }

}



/**

 * PART 3. Admin page

 * ============================================================================

 *

 * In this part you are going to add admin page for custom table

 *

 * http://codex.wordpress.org/Administration_Menus

 */



/**

 * admin_menu hook implementation, will add pages to list feeearners and to add new one

 */

function custom_table_frfe_admin_menu()

{

    add_menu_page(__('feeearners', 'custom_table_frfe'), __('Fee Earner Names', 'custom_table_frfe'), 'read_private_pages', 'feeearners', 'custom_table_frfe_feeearners_page_handler',

'dashicons-star-filled', 14 );

   // add_submenu_page('persons', __('feeearner', 'custom_table_frfe'), __('Fee Earner', 'custom_table_frfe'), 'read_private_pages', 'feeearners', 'custom_table_frfe_feeearners_page_handler');

    // add new will be described in next part

    add_submenu_page('feeearners', __('Add new', 'custom_table_frfe'), __('Add new', 'custom_table_frfe'), 'read_private_pages', 'feeearners_form', 'custom_table_frfe_feeearners_form_page_handler');

}



add_action('admin_menu', 'custom_table_frfe_admin_menu');



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

function custom_table_frfe_feeearners_page_handler()

{

    global $wpdb;



    $table = new custom_table_frfe_List_Table();

    $table->prepare_items();



    $message = '';

    if ('delete' === $table->current_action()) {

        $message = '<div class="updated below-h2" id="message"><p>' . sprintf(__('Items deleted: %d', 'custom_table_frfe'), count($_REQUEST['id'])) . '</p></div>';

    }

    ?>

<div class="wrap">



    <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>

    <h2><?php _e('feeearner', 'custom_table_frfe')?> <a class="add-new-h2"

                                 href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=feeearners_form');?>"><?php _e('Add new', 'custom_table_frfe')?></a>

    </h2>

    <?php echo $message; ?>



    <form id="feeearners-table" method="GET">

        <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>

        <?php $table->display() ?>

    </form>



</div>

<?php

}



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

function custom_table_frfe_feeearners_form_page_handler()

{

    global $wpdb;

    $table_frfe = $wpdb->prefix . 'frfeeearner'; // do not forget about tables prefix



    $message = '';

    $notice = '';



    // this is default $item which will be used for new records

    $default = array(

        'id' => 0,

        'feeearnername' => '',

		'solicitorname' => '',

        'feeearneraddress' => '',

        'feeearnerpostalcode' => '',

       

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

                $notice = __('Item not found', 'custom_table_frfe');

            }

        }

    }



    // here we adding our custom meta box

    add_meta_box('feeearners_form_meta_box', 'Fee Earner data', 'custom_table_frfe_feeearners_form_meta_box_handler', 'feeearner', 'normal', 'default');



    ?>

<div class="wrap">

    <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>

    <h2><?php _e('Fee Earner', 'custom_table_frfe')?> <a class="add-new-h2"

                                href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=feeearners');?>"><?php _e('back to list', 'custom_table_frfe')?></a>

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

                    <?php do_meta_boxes('feeearner', 'normal', $item); ?>

                    <input type="submit" value="<?php _e('Save', 'custom_table_frfe')?>" id="submit" class="button-primary" name="submit">

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

function custom_table_frfe_feeearners_form_meta_box_handler($item)

{

    ?>



<table cellspacing="2" cellpadding="5" style="width: 100%;" class="form-table">

    <tbody>

    <tr class="form-field">

        <th valign="top" scope="row">

            <label for="feeearnername"><?php _e('Fee Earner Name', 'custom_table_frfe')?></label>

        </th>

        <td>

            <input id="feeearnername" name="feeearnername" type="text" style="width: 95%" value="<?php echo esc_attr($item['feeearnername'])?>"

                   size="50" class="code" placeholder="<?php _e('', 'custom_table_frfe')?>" >

        </td>

    </tr>

	<tr class="form-field">

        <th valign="top" scope="row">

            <label for="feeearneraddress"><?php _e('Fee Earner Address', 'custom_table_frfe')?></label>

        </th>

        <td>

            <input id="feeearneraddress" name="feeearneraddress" type="text" style="width: 95%" value="<?php echo esc_attr($item['feeearneraddress'])?>"

                   size="50" class="code" placeholder="<?php _e('', 'custom_table_frfe')?>" >

        </td>

    </tr>

	<tr class="form-field">

        <th valign="top" scope="row">

            <label for="feeearnerpostalcode"><?php _e('Postal Code', 'custom_table_frfe')?></label>

        </th>

        <td>

            <input id="feeearnerpostalcode" name="feeearnerpostalcode" type="text" style="width: 95%" value="<?php echo esc_attr($item['feeearnerpostalcode'])?>"

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

	

    </tbody>

</table>

<?php

}



/**

 * Simple function that validates data and retrieve bool on success

 * and error message(s) on error

 *

 * @param $item

 * @return bool|string

 */

function custom_table_frfe_validate_feeearner($item)

{

    $messages = array();



    if (empty($item['feeearnername'])) $messages[] = __('Fee Earner Name is required', 'custom_table_frfe');

	if (empty($item['solicitorname'])) $messages[] = __('Please create a solicitor first', 'custom_table_frfe');

    // if (!empty($item['contactemail']) && !is_email($item['contactemail'])) $messages[] = __('E-Mail is in wrong format', 'custom_table_frfe');

    // if (!ctype_digit($item['agerange'])) $messages[] = __('Age Range in wrong format', 'custom_table_frfe');

    //if(!empty($item['agerange']) && !absint(intval($item['age'])))  $messages[] = __('Age can not be less than zero');

    //if(!empty($item['agerange']) && !preg_match('/[0-9]+/', $item['age'])) $messages[] = __('Age must be number');

    //...



    if (empty($messages)) return true;

    return implode('<br />', $messages);

}



