<?php
/**
 * WRLS_REGISTER_SHORTCODE setup
 *
 * @package  WP Registeration Login Shortcode
 * @since   1.0.0
 */

if( !class_exists( 'WRLS_REGISTER_SHORTCODE' ) ) {
    class WRLS_REGISTER_SHORTCODE {
        // Construct fuction
        public function __construct() {
            add_shortcode( 'registerpage', array($this,'wrls_registration_shortcode') );
            add_action( 'wp_ajax_wrls_get_register_user', array($this,'wrls_get_register_user') );
            add_action( 'wp_ajax_nopriv_wrls_get_register_user', array($this,'wrls_get_register_user') );

        }

        //Plugin  registration page shortcode
        public function wrls_registration_shortcode() {
            if( is_user_logged_in() ){
                echo '<div class="error_main">';
                    echo '<div class="error_container">';
                        echo '<p class="error_msg"><i class="fa fa-warning"></i>'.__( 'You Can`t Access This Page Because You Are All Ready Login In', 'wp-registration-login-shortcode' ).'<i class="fa fa-exclamation" aria-hidden="true"></i></p>';
                    echo '</div>';
                    echo '<div class="error_btn_div">';
                        echo '<a href="'.esc_url( home_url() ).'" id="error_btn"><i class="fa fa-hand-o-right" aria-hidden="true">
                        </i>'.__( 'GO to Home', 'wp-registration-login-shortcode' ).'</a>';
                    echo '</div>';
                echo '</div>';
            }
            else {
                echo '<div class="container-fluid Registration">';
                    echo '<div class="content Registration_body">';
                        echo '<div class="Registration_title">'.__( 'Registration', 'wp-registration-login-shortcode' ).' </div>';
                        echo '<form action="javascript:void(0)" id="register_form">';
                            echo '<div class="user-details">';
                                echo '<div class="input-box">';
                                    echo '<span class="details">'.__( 'Full Name', 'wp-registration-login-shortcode' ).'<span class="text-danger"> * </span></span>';
                                    echo '<input type="text"  name="full_name" id="full_name" >';
                                echo '</div>';
                                echo '<div class="input-box">';
                                    echo '<span class="details">'.__( 'Username', 'wp-registration-login-shortcode' ).' <span class="text-danger"> * </span></span>';
                                    echo '<input type="text" name="Username" id="Username"  >';
                                echo '</div>';
                                echo '<div class="input-box">';
                                    echo '<span class="details">'.__( 'Email', 'wp-registration-login-shortcode' ).' <span class="text-danger"> * </span></span>';
                                    echo '<input type="text"  name="Email" id="Email" >';
                                echo '</div>';
                                echo '<div class="input-box">';
                                    echo '<span class="details">'.__( 'Mobile Number', 'wp-registration-login-shortcode' ).' <span class="text-danger"> * </span></span>';
                                    echo '<input type="number" name="Phone_Number" id="Phone_Number" >';
                                echo '</div>';
                                echo '<div class="input-box">';
                                    echo '<span class="details"> '.__( 'Password', 'wp-registration-login-shortcode' ).' <span class="text-danger"> * </span></span>';
                                    echo '<input type="password" id="password" name="password" id="password" >';
                                echo '</div>';
                                echo '<div class="input-box">';
                                    echo '<span class="details"> '.__( 'Confirm Password', 'wp-registration-login-shortcode' ).' </span>';
                                    echo '<input type="password" name="Confirm_Password" >';
                                echo '</div>';
                            echo '</div>';
                            echo '<div class="button">';
                                echo '<input type="submit" value="'.__( 'Register', 'wp-registration-login-shortcode' ).'" id="register-btn">';
                            echo '</div>';
                        echo '</form>';
                        echo '<input type="hidden" id="home_url" value="'.esc_url( home_url() ).'">';
                    echo '</div>';
                echo '</div>';  
            }
        }

    

        //function get register user Data
        public function wrls_get_register_user(){
            ob_clean();

            $response = [];

            if ( isset( $_POST ) ) {
                $full_name    = sanitize_text_field( $_POST['full_name'] );
                $Username     = sanitize_text_field( $_POST['Username'] );
                $Email        = sanitize_email( $_POST['Email'] );
                $Phone_Number = sanitize_text_field( $_POST['Phone_Number'] );
                $password     = sanitize_text_field( $_POST['password'] );

            
                $data = array(
                'user_login' => $Username,     // login username.
                'user_pass'	 => $password,     // login password.
                'user_email' => $Email,        // login Email.
                'role'       => 'subscriber',  // login role.
                );

                $user_id = wp_insert_user( $data );
                    
                if ( ! is_wp_error( $user_id ) ) { 
                    $status= true;
                    $message='You are Successfully Registered !!';
                }
                else{
                    $status = false;
                    $message = $user_id->get_error_message();
                }
                $response['status']  = $status;
                $response['message'] = $message;
                
                echo wp_json_encode( $response );
                wp_die();
            }
        }
    }
$WRLS_REGISTER_SHORTCODE = new WRLS_REGISTER_SHORTCODE();
}