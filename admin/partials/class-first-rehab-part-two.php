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
 * Custom_Table_Example_List_Table class that will display our custom table
 * records in nice table
 */
class Custom_Table_FRPA_List_Table extends WP_List_Table
{
    /**
     * [REQUIRED] You must declare constructor and give some basic params
     */
    function __construct()
    {
        global $status, $page;

        parent::__construct(array(
            'singular' => 'person',
            'plural' => 'persons',
        ));
    }

    /**
     * [REQUIRED] this is a default column renderer
     *
     * @param $item - row (key, value array)
     * @param $column_name - string (key)
     * @return HTML
     */
    function column_default($item, $clientname)
    {
        return $item[$clientname];
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
        // be something like &person=2
        $actions = array(
            'edit' => sprintf('<a href="?page=persons_form&id=%s">%s</a>', $item['id'], __('Edit', 'custom_table_first_rehab')),
            'delete' => sprintf('<a href="?page=%s&action=delete&id=%s">%s</a>', $_REQUEST['page'], $item['id'], __('Delete', 'custom_table_first_rehab')),
            'view' => sprintf('<a href="?page=%s&action=view&id=%s">%s</a>', $_REQUEST['page'], $item['id'], __('View', 'custom_table_first_rehab')),
			
        );

        return sprintf('%s %s',
            $item['clientname'],
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
        // 'title' => __('Title', 'custom_table_frpa'),
		'name' =>  __('Client Name', 'custom_table_frpa'),		
		// 'clientname' => __('Client Name', 'custom_table_frpa'),
		// 'telephone' => __('Telephone Number', 'custom_table_frpa'),
        // 'mobile' => __('Mobile Number', 'custom_table_frpa'),
        'address' => __('Address', 'custom_table_frpa'),
        'postcode' => __('Postal Code', 'custom_table_frpa'),
        'contactemail' => __('E-Mail', 'custom_table_frpa'),
        'numberofsessions' => __('Number of Physio Sessions', 'custom_table_frpa'),
		'numberofcbt' => __('Number of CBT Sessions', 'custom_table_frpa'),
        // 'priceofsessions' => __('Price of sessions', 'custom_table_frpa'),
		// 'priceofcbt' => __('Price of CBT Sessions', 'custom_table_frpa'),
        // 'fileupload' => __('Uploaded Invoice', 'custom_table_frpa'),
        'clientgender' => __('Client Gender', 'custom_table_frpa'),
        'clientdob' => __('Date of Birth', 'custom_table_frpa'),
        'dateofaccident' => __('Date of Accident', 'custom_table_frpa'),
        'solicitorname' => __('Solicitor', 'custom_table_frpa'),
        'feeearnername' => __('Fee Earner', 'custom_table_frpa'),
		'solicitorreference' => __('Solicitor Reference', 'custom_table_frpa'),
        // 'firstrehabnotes' => __('Client Notes', 'custom_table_frpa'),
		// 'uploadinitial' => __('Uploaded Initial Consultation', 'custom_table_frpa'),
        // 'uploadinvoice' => __('Uploaded Invoice', 'custom_table_frpa'),
        // 'uploaddischarge' => __('Uploaded Discharge Form', 'custom_table_frpa')
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
		'name' => array('clientname', true),
        //'title' => array('title', true),
        //'clientname' => array('clientname', true),
        //'telephone' => array('telephone', true),
        //'mobile' => array('mobile', true),
        'address' => array('address', true),
        'postcode' => array('postcode', true),
        'contactemail' => array('contactemail', false),
        'numberofsessions' => array('numberofsessions', false),
		'numberofcbt' => array('numberofcbt', false),
        //'priceofsessions' => array('priceofsessions', true),
		//'priceofcbt' => array('priceofcbt', true),
        //'fileupload' => array('fileupload', true),
        'clientgender' => array('clientgender', true),
        'clientdob' => array('clientdob', true),
        'dateofaccident' => array('dateofaccident', true),
        'solicitorname' => array('solicitorname', true),
        'feeearnername' => array('feeearnername', true),
        'solicitorreference' => array('solicitorreference', false),
        //'firstrehabnotes' => array('firstrehabnotes', false),
        //'uploadinvoice' => array('uploadinvoice', false),
	    //'uploadinitial' => array('uploadinitial', false),
        //'uploaddischarge' => array('uploaddischarge', false)			
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
        $table_frpa = $wpdb->prefix . 'firstrehab'; // do not forget about tables prefix

        if ('delete' === $this->current_action()) {
            $ids = isset($_REQUEST['id']) ? $_REQUEST['id'] : array();
            if (is_array($ids)) $ids = implode(',', $ids);

            if (!empty($ids)) {
                $wpdb->query("DELETE FROM $table_frpa WHERE id IN($ids)");
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
        $table_frpa = $wpdb->prefix . 'firstrehab'; // do not forget about tables prefix

        $per_page = 25; // constant, how much records will be shown per page

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();

        // here we configure table headers, defined in our methods
        $this->_column_headers = array($columns, $hidden, $sortable);

        // [OPTIONAL] process bulk action if any
        $this->process_bulk_action();

        // will be used in pagination settings
        $total_items = $wpdb->get_var("SELECT COUNT(id) FROM $table_frpa");

        // prepare query params, as usual current page, order by and order direction
        $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged']) - 1) : 0;
        $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'clientname';
        $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'asc';

        // [REQUIRED] define $items array
        // notice that last argument is ARRAY_A, so we will retrieve array
        $this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_frpa ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);

        // [REQUIRED] configure pagination
        $this->set_pagination_args(array(
            'total_items' => $total_items, // total items defined above
            'per_page' => $per_page, // per page constant defined at top of method
            'total_pages' => ceil($total_items / $per_page) // calculate pages count
        ));
    }
}