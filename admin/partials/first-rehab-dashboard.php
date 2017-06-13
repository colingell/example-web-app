<?php 
function remove_menus(){
  
 // remove_menu_page( 'index.php' );                  //Dashboard
  remove_menu_page( 'jetpack' );                    //Jetpack* 
  remove_menu_page( 'edit.php' );                   //Posts
  remove_menu_page( 'upload.php' );                 //Media
  remove_menu_page( 'edit.php?post_type=page' );    //Pages
  remove_menu_page( 'edit-comments.php' );          //Comments
  remove_menu_page( 'themes.php' );                 //Appearance
  remove_menu_page( 'plugins.php' );                //Plugins
  remove_menu_page( 'users.php' );                  //Users
  remove_menu_page( 'tools.php' );                  //Tools
  remove_menu_page( 'options-general.php' );        //Settings
  
}
add_action( 'admin_menu', 'remove_menus' );


function remove_dashboard_widgets() {
	global $wp_meta_boxes;

unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
update_user_meta( get_current_user_id(), 'show_welcome_panel', false );
remove_action('welcome_panel', 'wp_welcome_panel');
remove_meta_box( 'dashboard_activity', 'dashboard', 'normal');

}

	add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );
	
	
//Remove sub level admin menus
function remove_admin_submenus() {
    remove_submenu_page( 'themes.php', 'theme-editor.php' );
    remove_submenu_page( 'themes.php', 'themes.php' );
    remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=post_tag' );
    remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=category' );
    remove_submenu_page( 'edit.php', 'post-new.php' );
    remove_submenu_page( 'themes.php', 'nav-menus.php' );
    remove_submenu_page( 'themes.php', 'widgets.php' );
    remove_submenu_page( 'themes.php', 'theme-editor.php' );
    remove_submenu_page( 'plugins.php', 'plugin-editor.php' );
    remove_submenu_page( 'plugins.php', 'plugin-install.php' );
    remove_submenu_page( 'users.php', 'users.php' );
    remove_submenu_page( 'users.php', 'user-new.php' );
    remove_submenu_page( 'upload.php', 'media-new.php' );
    remove_submenu_page( 'options-general.php', 'options-writing.php' );
    remove_submenu_page( 'options-general.php', 'options-discussion.php' );
    remove_submenu_page( 'options-general.php', 'options-reading.php' );
    remove_submenu_page( 'options-general.php', 'options-discussion.php' );
    remove_submenu_page( 'options-general.php', 'options-media.php' );
    remove_submenu_page( 'options-general.php', 'options-privacy.php' );
    remove_submenu_page( 'options-general.php', 'options-permalinks.php' );
    remove_submenu_page( 'index.php', 'update-core.php' );  // Dashboard > Updates
    remove_submenu_page( 'index.php', 'index.php' );        // Dashboard > Home
	remove_submenu_page( 'index.php', 'my-sites.php' ); // Dashboard > My Sites
	
}
add_action( 'admin_menu', 'remove_admin_submenus' );


function remove_admin_bar_links() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('wp-logo');          // Remove the WordPress logo
    $wp_admin_bar->remove_menu('about');            // Remove the about WordPress link
    $wp_admin_bar->remove_menu('wporg');            // Remove the WordPress.org link
    $wp_admin_bar->remove_menu('documentation');    // Remove the WordPress documentation link
    $wp_admin_bar->remove_menu('support-forums');   // Remove the support forums link
    $wp_admin_bar->remove_menu('feedback');         // Remove the feedback link
    $wp_admin_bar->remove_menu('site-name');        // Remove the site name menu
    $wp_admin_bar->remove_menu('view-site');        // Remove the view site link
    $wp_admin_bar->remove_menu('updates');          // Remove the updates link
    $wp_admin_bar->remove_menu('comments');         // Remove the comments link
    $wp_admin_bar->remove_menu('new-content');      // Remove the content link
    $wp_admin_bar->remove_menu('w3tc');             // If you use w3 total cache remove the performance link
   // $wp_admin_bar->remove_menu('my-account');       // Remove the user details tab
    $wp_admin_bar->remove_node('my-sites');         // Remove My Sites
}
add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_links' );

// Remove Help Tab from Dashboard
add_filter( 'contextual_help', 'mycontext_remove_help', 999, 3 );
      function mycontext_remove_help($old_help, $screen_id, $screen){
        $screen->remove_help_tabs();
        return $old_help;
    }
	
	// Changes name of dashboard label (menu 2)in dashboard side menu 
	function change_post_menu_label() {
    global $menu;
    $menu[2][0] = 'Quick Access';
} 
    add_action( 'admin_menu', 'change_post_menu_label' );
	
	// Changes title of Dashboard Panel
	    function my_custom_dashboard_name(){
        if ( $GLOBALS['title'] != 'Dashboard' ){
            return;
        }
        $GLOBALS['title'] =  __( 'Quick Access Panel' ); 
    }
    add_action( 'admin_head', 'my_custom_dashboard_name' );