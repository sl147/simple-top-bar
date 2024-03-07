<?php

/**
 * main class for admin Simple top bar plugin
 */
if( ! class_exists( 'STBAR_ADMIN_MAIN' ) ) {
    class STBAR_ADMIN_MAIN {

        private function stbar_set_option() :array{

            return array(
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
                'position' => array (
                    'id_option'    => 'stbar_position',
                    'label_option' => esc_html__('Position', 'simple-top-bar'),
                    'type_option'  => 'radio',
                    'radio_options'=> $this->sl147_get_position(),
                    'validate'     => array(
                        'required' => true,
                    ),
                ),
                'updown' => array (
                    'id_option'    => 'stbar_updown',
                    'label_option' => esc_html__('Up Down', 'simple-top-bar'),
                    'type_option'  => 'radio',
                    'radio_options'=> $this->sl147_get_updown(),
                    'validate'     => array(
                        'required' => true,
                    ),
                ),
                'delete_option' => array (
                    'id_option'    => 'stbar_delete_option',
                    'label_option' => esc_html__('Delete options when plugin deactivate', 'simple-top-bar'),
                    'type_option'  => 'checkbox',
                ),
            );
        }
        public function stbar_admin_style(){
            wp_enqueue_style( 'stbar_admin', plugins_url( 'admin/css/stbar_admin.css', dirname(__FILE__) ), array(), STBAR_PLUGIN_VERSION);
            wp_enqueue_script( 'stbar_admin', plugins_url( 'admin/js/stbar_admin.js', dirname(__FILE__) ), array(), STBAR_PLUGIN_VERSION, true );
        }

        public function stbar_admin_run(){

            add_action( 'admin_enqueue_scripts',  array($this, 'stbar_admin_style') );

            $value_options = $this->stbar_set_option();

            require_once STBAR_PLUGIN_DIR_PATH . 'includes/stbar_settings.php';
            $stbar_options = new STBAR_option_settings( $value_options );             
        }

        private function sl147_form_radio($val){
            $tmp = array();
            foreach ($val as $value) {
                $item = array(
                'id_radio'   => $value['id'],
                'name_radio' => $value['name']
                );
                array_push($tmp, $item);
            }
            return $tmp;
        }

        private function set_radio($id, $name) {
            return array(
                'id'   => $id,
                'name' => $name
            );
        }

        private function sl147_get_position(){
            $val = array(
                'standard' => $this->set_radio('absolute', esc_html__('Movable', 'simple-top-bar')),
                'fixed'    => $this->set_radio('fixed',    esc_html__('Fixed',    'simple-top-bar'))
            );
            return $this->sl147_form_radio($val);
        }
        
        private function sl147_get_updown(){
            $val = array(
                'up'   => $this->set_radio('up',   esc_html__('Up',   'simple-top-bar')),
                'down' => $this->set_radio('down', esc_html__('Down', 'simple-top-bar')),
            );
            return $this->sl147_form_radio($val);
        }
    }
}