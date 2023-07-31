<?php

/**
 *
 * Plugin Name:       Simple top bar
 * Plugin URI:        https://vaolab.pl/
 * Description:       <code><strong>Simple top bar</strong></code>Customizer for top bar
 * Version:           1.0.0
 * Author:            Yaroslav Livchak
 * Author URI:        https://www.gomgal.lviv.ua/topBar
 * Text Domain:       simple-top-bar
 * Domain Path:       /languages
 * WC tested up to:   6.6.2
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'PLUGIN_TB_TEXT_DOMAIN', 'simple-top-bar' );
define( 'PLUGIN_TB_DIR_PATH', plugin_dir_path( __FILE__));
define( 'PLUGIN_TB_NAME', 'simple-top-bar');


function sl147_TB_textdomain() {
    $locale = determine_locale();
    //load_plugin_textdomain( 'simple-top-bar', false, PLUGIN_TB_DIR_PATH . 'languages/' );
    //load_plugin_textdomain( 'simple-top-bar', false, basename( dirname( __FILE__ ) ) . '/languages/' );
	load_plugin_textdomain( 'simple-top-bar', false, plugin_dir_path(__FILE__) . 'languages' );
}
add_action('plugins_loaded', 'sl147_TB_textdomain');

function deactivate_sl147_TB() {
    require_once WP_PLUGIN_DIR . '/sl147_TB/includes/class-sl147_TB-deactivator.php';
    Sl147_TB_Deactivator::deactivate();
}
register_deactivation_hook( __FILE__, 'deactivate_sl147_TB' );


function sl147_TB_plugin_add_settings_link( $links ) {
    $settings_link = '<a href="admin.php?page=sl147_tb_page">' . __( 'Settings', 'simple-top-bar'  ) . '</a>';
    array_push( $links, $settings_link );
    return $links;
}

$filter_name = "plugin_action_links_" . plugin_basename( __FILE__ );
add_filter( $filter_name, 'sl147_TB_plugin_add_settings_link' );

function sl147_TB_plugin_row_meta( $meta, $plugin_file ){
    if( false === strpos( $plugin_file, basename(__FILE__) ) )
        return $meta;

    $meta[] = '<a href="admin.php?page=sl147_tb_page"><span class="dashicons dashicons-admin-settings"></span>'. __( 'Settings', 'simple-top-bar'  ) .'</a>';
    return $meta; 
}
add_filter( 'plugin_row_meta', 'sl147_TB_plugin_row_meta', 10, 4 );

function sl147_TB_register_menu() {
        add_menu_page(__( 'Settings', 'simple-top-bar' ), __( 'Custom top bar', 'simple-top-bar' ), 1, 'sl147_tb_page', 'run_sl147_Top_Bar_admin' ,"dashicons-align-center", 5);
    }

function run_sl147_Top_Bar_admin() {
// При запуску меню запускаэться теж submenu Sl147_class_TB_settings з тим же слагом сторінки - sl147_tb_page. Тут меню служить тільки для виводу тексту меню в адмін панелі. Робота запускається із submenu 
}

function sl147_TB_admin_style(){
    wp_enqueue_style( 'sl147_TB_admin', plugins_url( 'admin/css/sl147_tb_admin.css', __FILE__ ) , array());
}

function sl147_TB_front_style(){
    wp_enqueue_style( 'sl147_TB_front_css', plugins_url( 'assets/css/sl147_tb_front.css', __FILE__ ) , array());
	wp_enqueue_script( 'sl147_TB_front_js', plugins_url( 'assets/js/sl147_tb_front.js', __FILE__ ) , array('jquery'));
	//wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '4.1.0', true ); 
}

require_once PLUGIN_TB_DIR_PATH . 'includes/class-sl147_TB_main.php';
//$plugin_main  = new Sl147_TB_main();

if(is_admin()) {
    require_once PLUGIN_TB_DIR_PATH . 'admin/partials/class-sl147_TB_admin.php';  
    $plugin_admin  = new Sl147_TB_admin();
    $plugin_admin->run_admin();

    add_action( 'admin_enqueue_scripts',  'sl147_TB_admin_style' );
    add_action( 'admin_menu', 'sl147_TB_register_menu' );
}else {
    add_action( 'wp_enqueue_scripts',  'sl147_TB_front_style' );
    require_once PLUGIN_TB_DIR_PATH . 'includes/class-sl147_TB.php';   
    $plugin  = new Sl147_TB();
    $plugin->run();   
}