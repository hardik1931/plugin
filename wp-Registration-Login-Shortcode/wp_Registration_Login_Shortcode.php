<?php
/*
 * Plugin Name: Custom Registration Form And Login Form With Shortcode For WordPress
 * Plugin URI: #
 * Description: Custom login and register Shortcode add in your page
 * Version: 1.0.0
 * Author: ABC
 * Author URI: #
 * Text Domain:  wp-registration-login-shortcode
 * Domain Path: /languages
 */
hello hardikk
hell rsjj herte

 //avoid direct calls to this file
if ( !defined( 'ABSPATH' ) ) { exit; }


/**
 * Defind Class 
 */
defined('WP_REGISTRATION_LOGIN_SHORTCODE') or define('WP_REGISTRATION_LOGIN_SHORTCODE', plugin_dir_path(__FILE__) );
defined('WP_REGISTRATION_LOGIN_SHORTCODE_URL') or define('WP_REGISTRATION_LOGIN_SHORTCODE_URL', plugin_dir_url(__FILE__) );

if( ! class_exists('WRLS_MAIN') ) {
    class WRLS_MAIN {
        // Construct fuction
        public function __construct() {
            add_action( 'wp_enqueue_scripts', array($this,'wrls_enqueue_script_and_style') );
            add_action( 'admin_notices', array($this,'wrls_admin_shortcode_notice') ); 
            add_action( 'admin_menu', array($this,'wrls_admin_custom_menu_page') );
            require_once( WP_REGISTRATION_LOGIN_SHORTCODE . 'inc/wrls_login_shortcode/wrls_login_shortcode.php');
            require_once( WP_REGISTRATION_LOGIN_SHORTCODE . 'inc/wrls_register_shortcode/wrls_register_shortcode.php');
        }

        /**
         * Load plugin  All Sript/Style 
         */
        public function wrls_enqueue_script_and_style()
        { 
            wp_enqueue_style( 'wrls_main_css', WP_REGISTRATION_LOGIN_SHORTCODE_URL .'assets/css/wrls_main.css',array(), '1.0.0', 'all' );
            wp_enqueue_style( 'wrls_font_awesome_min_css', WP_REGISTRATION_LOGIN_SHORTCODE_URL .'assets/css/font-awesome.min.css',array(), '1.0.0', 'all' );
            wp_enqueue_style( 'wrls_bootsrap_min_css', WP_REGISTRATION_LOGIN_SHORTCODE_URL .'assets/css/bootstrap.min.css',array(), '1.0.0', 'all' );
            wp_enqueue_style( 'wrls_sweetalert_min_css', WP_REGISTRATION_LOGIN_SHORTCODE_URL .'assets/css/sweetalert2.min.css',array(), '1.0.0', 'all' );
            wp_enqueue_script( 'wrls_jquery_min_js', WP_REGISTRATION_LOGIN_SHORTCODE_URL .'assets/js/jquery.min.js',array(),'1.0.0' ,true );
            wp_enqueue_script( 'wrls_main_js', WP_REGISTRATION_LOGIN_SHORTCODE_URL .'assets/js/wrls_main.js',array(),'1.0.0' ,true );
            wp_enqueue_script( 'wrls_sweetalert_js', WP_REGISTRATION_LOGIN_SHORTCODE_URL .'assets/js/sweetalert2.all.min.js',array(),'1.0.0',true  );
            wp_enqueue_script( 'wrls_bootsrap_bundel_min_js', WP_REGISTRATION_LOGIN_SHORTCODE_URL .'assets/js/bootstrap.bundle.min.js',array(),'1.0.0',true  );
            wp_enqueue_script( 'wrls_validate_js', WP_REGISTRATION_LOGIN_SHORTCODE_URL .'assets/js/jquery.validate.min.js',array(),
            '1.0.0' ,true );
            wp_localize_script( 'wrls_main_js', 'wpadmin', array( 'wpadmin_url' => admin_url( 'admin-ajax.php' )));
        }


        /**
         * Register a custom menu page.
         */
        public function  wrls_admin_custom_menu_page() {
            add_menu_page(
                __( 'WRLS', 'wp-registration-login-shortcode' ),
                'WRLS',
                'manage_options',
                'custompage1',
                'wrls_admin_shortcode_notice',
                'dashicons-admin-plugins',
                
            ); 
        }
       

         /**
         * Add Plugin Admin ShorCode Notice Code.
         */
        public function wrls_admin_shortcode_notice()
        {
            $page=$_GET['page'];
                if ( $page == 'custompage1' ) {
                    echo '<div class="notice notice-info is-dismissible">';
                        echo '<p>'.esc_html('Login Page ShortCode :: [loginpage]', 'wp-registration-login-shortcode' ).'</p>';
                        echo '<p>'.esc_html('Register Page ShortCode :: [registerpage]', 'wp-registration-login-shortcode' ).'</p>';
                    echo '</div>';
                }
        }
    
    }
$WRLS_MAIN = new WRLS_MAIN();
}