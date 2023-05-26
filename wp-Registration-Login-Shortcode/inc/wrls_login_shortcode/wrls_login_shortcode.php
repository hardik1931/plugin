<?php
/**
 * WRLS_LOGIN_SHORTCODE setup
 *
 * @package WP Registeration Login Shortcode
 * @since   1.0.0
 */


if( !class_exists('WRLS_LOGIN_SHORTCODE') ) {
    class WRLS_LOGIN_SHORTCODE {
        // Construct fuction
        public function __construct() {
            add_shortcode( 'loginpage', array($this,'wrls_login_shortcode') );
            add_action( 'wp_ajax_wrls_get_login_user', array($this,'wrls_get_login_user') );
            add_action( 'wp_ajax_nopriv_wrls_get_login_user', array($this,'wrls_get_login_user') );
        }

        // Plugin login page shortcode
        public function wrls_login_shortcode() {

            if( is_user_logged_in() ){  
                echo '<div class="error_main">';
                    echo '<div class="error_container">';
                        echo '<p class="error_msg"><i class="fa fa-warning"></i>'.__( 'You Can`t Access This Page Because You Are All Ready Login In', 'wp-registration-login-shortcode' ).' <i class="fa fa-exclamation" aria-hidden="true"></i></p>';
                    echo '</div>';
                    echo '<div class="error_btn_div">';
                        echo '<a href="'.esc_url( admin_url() ).'" id="error_btn"><i class="fa fa-hand-o-right" aria-hidden="true"></i> '.__( 'GO to Dashboard', 'wp-registration-login-shortcode' ).'</a>';
                    echo '</div>';
                echo '</div>';
            }   
            else{
                echo '<div class="login_container">';
                    echo '<div class="login_box">';
                        echo '<h1 id="login_text">'.__( 'Login', 'wp-registration-login-shortcode' ).' </h1>';
                        echo '<form id="login_form" action="javascript:void(0)">';
                            echo '<div class="form-group">';
                                echo '<label for="email" id="login_lable"> '.__( 'Username', 'wp-registration-login-shortcode' ).' <span class="text-danger"> * </span></label>';
                                echo '<input type="text" name="login_Username" id="login_Username" class="form-control">';
                            echo '</div>';
                            echo '<div class="form-group">';
                                echo'<label for="password" id="login_lable"> '.__( 'Password', 'wp-registration-login-shortcode' ).' <span class="text-danger"> * </span></label>';
                                echo '<input type="password" name="login_password" id="login_password" class="form-control">';
                            echo '</div>';
                            echo '<div class="login">';
                                echo '<button class="btn btn-class" id="login_btn"> '.__( 'Login', 'wp-registration-login-shortcode' ).'</button>';
                            echo '</div>';
                        echo '</form>';
                        echo '<input type="hidden" id="admin_url" value="'.esc_url( admin_url() ).'">';
                    echo '</div>';
                echo '</div>';
            }
        }


        //get login user data
        public function wrls_get_login_user(){
            ob_clean();
            
            $login_response = [];

            if ( isset( $_POST['login_Username'] ) && isset( $_POST['login_password'] ) ) {
                $login_Username  = sanitize_text_field( $_POST['login_Username'] );
                $login_password  = sanitize_text_field( $_POST['login_password'] );

                $login_user = array(
                    'user_login'    => $login_Username,  // user_login.
                    'user_password' => $login_password,   // login password.
                );
                $users = wp_signon( $login_user);
            
                if ( ! is_wp_error($users) ) {
                    $status  = true;
                    $message ='You are successfully logged in !!';
                }
                else{
                    $status  = false;
                    $message = $users->get_error_message();
                }

                $login_response['status']  = $status;
                $login_response['message'] = $message;
            }
            else{
                $login_response['status']  = false;
                $login_response['message'] = __( 'Invalid request.', 'wp-registration-login-shortcode' );
              
            }
            echo json_encode($login_response);
            die();
        }
    }
$WRLS_LOGIN_SHORTCODE = new WRLS_LOGIN_SHORTCODE();
}