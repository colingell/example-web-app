<?php

add_action('wpmu_new_blog', 'wpb_create_my_pages', 10, 2);

function wpb_create_my_pages($blog_id, $user_id){
  switch_to_blog($blog_id);

// create new page
  $page_id = wp_insert_post(array(
    'post_title'     => 'Login',
    'post_name'      => 'login',
    'post_content'  => '[showform event="' . $_POST[event] . '" amount="' . $_POST[amount] . '" bet_id="' . $bet_id . '"][showform]',
    'post_status'    => 'publish',
    'post_author'    => $user_id, // or "1" (super-admin?)
    'post_type'      => 'page',
    'menu_order'     => 1,
    'comment_status' => 'closed',
    'ping_status'    => 'closed',
 ));  
  
// Find and delete the WP default 'Sample Page'
$defaultPage = get_page_by_title( 'Sample Page' );
wp_delete_post( $defaultPage->ID );

  restore_current_blog();
}

$homepage = get_page_by_title( 'Login' );

if ( $homepage )
{
    update_option( 'page_on_front', $homepage->ID );
    update_option( 'show_on_front', 'page' );
}

add_shortcode('showform', 'showForm');

function showForm() {
extract( shortcode_atts( array(
        'event' => 'default event',
        'amount' => 20,//default amount
             'bet_id' => 0
    ), $atts ) );

	?>
	
	<!-- section -->
    <section class="aa_loginForm">
        <?php 
            global $user_login;
            // In case of a login error.
            if ( isset( $_GET['login'] ) && $_GET['login'] == 'failed' ) : ?>
    	            <div class="aa_error">
    		            <p><?php _e( 'FAILED: Try again!', 'AA' ); ?></p>
    	            </div>
            <?php 
                endif;
            // If user is already logged in.
            if ( is_user_logged_in() ) : ?>

                <div class="aa_logout"> 
                    
                    <?php 
                        _e( 'Hello ', 'AA' ); 
                        echo $user_login; 
                    ?>
                    
                    </br>
                    
                    <?php _e( 'You are already logged in.', 'AA' ); ?>

                </div>

                <a id="wp-submit" href="<?php echo wp_logout_url(); ?>" title="Logout">
                    <?php _e( 'Logout', 'AA' ); ?>
                </a>

            <?php 
                // If user is not logged in.
                else: 
                
                    // Login form arguments.
                    $args = array(
                        'echo'           => true,
                        'redirect'       => home_url( '/wp-admin/' ), 
                        'form_id'        => 'loginform',
                        'label_username' => __( 'Username' ),
                        'label_password' => __( 'Password' ),
                        'label_remember' => __( 'Remember Me' ),
                        'label_log_in'   => __( 'Log In' ),
                        'id_username'    => 'user_login',
                        'id_password'    => 'user_pass',
                        'id_remember'    => 'rememberme',
                        'id_submit'      => 'wp-submit',
                        'remember'       => true,
                        'value_username' => NULL,
                        'value_remember' => true
                    ); 
                    
                    // Calling the login form.
                    wp_login_form( $args );
                endif;
        ?> 

	</section>
	<?php
	
// include('wp-content/themes/twentyfourteen/test.php');
}

?>