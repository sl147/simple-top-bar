<?php

/**
 * main class for admin Simple top bar plugin
 */
if( ! class_exists( 'STBAR_ADMIN_MAIN' ) ) {
    class STBAR_ADMIN_MAIN {

        public function stbar_admin_style(){
            wp_enqueue_style( 'stbar_admin', plugins_url( 'admin/css/stbar_admin.css', dirname(__FILE__) ), array(), STBAR_PLUGIN_VERSION);
            wp_enqueue_script( 'stbar_admin', plugins_url( 'admin/js/stbar_admin.js', dirname(__FILE__) ), array(), STBAR_PLUGIN_VERSION, true );
        }

        public function stbar_admin_run(){

            add_action( 'admin_enqueue_scripts',  array($this, 'stbar_admin_style') );

            $value_options = array(
                'background_color' => array (
                    'id_option'    => 'stbar_background_color',
                    'label_option' => esc_html__('Background color','simple-top-bar'),
                    'type_option'  => 'text',
                    'validate'     => array(
                        'check_color' => true
                    ),
                ),
                'font_color' => array (
                    'id_option'    => 'stbar_font_color',
                    'label_option' => esc_html__('Font color', 'simple-top-bar'),
                    'type_option'  => 'text',
                    'validate'     => array(
                        'check_color' => true
                    ),
                ),
                'TB_height' => array (
                    'id_option'    => 'stbar_block_height',
                    'label_option' => esc_html__('Height top bar > 576px (px)', 'simple-top-bar'),
                    'type_option'  => 'number',
                    'validate'     => array(
                        'required' => true,
                        'check_min'   => 10,
                        'check_max'   => 150
                    ),
                ),
                'TB_height_tel' => array (
                    'id_option'    => 'stbar_block_height_tel',
                    'label_option' => esc_html__('Height top bar < 576px (px)', 'simple-top-bar'),
                    'type_option'  => 'number',
                    'validate'     => array(
                        'required' => true,
                        'check_min'   => 10,
                        'check_max'   => 150
                    ),
                ),
                'font_size' => array (
                    'id_option'    => 'stbar_font_size',
                    'label_option' => esc_html__('Font size > 576px (px)', 'simple-top-bar'),
                    'type_option'  => 'number',
                    'validate'     => array(
                        'required' => true,
                        'check_min'   => 8,
                        'check_max'   => 20
                    ),
                ),
                'font_size_tel' => array (
                    'id_option'    => 'stbar_font_size_tel',
                    'label_option' => esc_html__('Font size < 576px (px)','simple-top-bar'),
                    'type_option'  => 'number',
                    'validate'     => array(
                        'required' => true,
                        'check_min'   => 10,
                        'check_max'   => 30
                    ),
                ),
                'text_TB' => array (
                    'id_option'    => 'stbar_text_option',
                    'label_option' => esc_html__('Text in top bar', 'simple-top-bar'),
                    'type_option'  => 'text',
                    'validate'     => array(
                        'required' => true,
                        'class'    => 'stbar_text_option'
                    ),
                ),
                'active_TB' => array (
                    'id_option'    => 'stbar_active',
                    'label_option' => esc_html__('Active top bar', 'simple-top-bar'),
                    'type_option'  => 'checkbox',
                ),
                'active_TB_ns' => array (
                    'id_option'    => 'stbar_active_non_stop',
                    'label_option' => esc_html__('Active top bar non stop', 'simple-top-bar'),
                    'type_option'  => 'checkbox',
                ),
                'delete_option' => array (
                    'id_option'    => 'stbar_delete_option',
                    'label_option' => esc_html__('Delete options when plugin deactivate', 'simple-top-bar'),
                    'type_option'  => 'checkbox',
                ),
            );
            if ( is_array($value_options) && count($value_options)) {
                require_once STBAR_PLUGIN_DIR_PATH . 'includes/stbar_settings.php';
                $stbar_options = new STBAR_option_settings( $value_options );    
            }
            
        }
    }
}