<?php

/**
 * main class for admin Simple top bar plugin
 */
if( ! class_exists( 'STBAR_ADMIN_MAIN' ) ) {
    class STBAR_ADMIN_MAIN {

        private function stbar_set_option() {

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
                'text_TB' => array (
                    'id_option'    => 'stbar_text_option',
                    'label_option' => esc_html__('Text in top bar', 'simple-top-bar'),
                    'type_option'  => 'text',
                    'validate'     => array(
                        'required' => true,
                        'class'    => 'stbar_text_option'
                    ),
                ),
                'border radius' => array (
                    'id_option'    => 'stbar_border_radius',
                    'label_option' => esc_html__('Border radius (px)', 'simple-top-bar'),
                    'type_option'  => 'number',
                    'validate'     => array(
                        'check_min'   => 0,
                        'check_max'   => 50
                    ),
                ),
                'animation_TB' => array (
                    'id_option'    => 'stbar_animation',
                    'label_option' => esc_html__('Animation bar', 'simple-top-bar'),
                    'type_option'  => 'checkbox',
                ),
                'active_TB' => array (
                    'id_option'    => 'stbar_active',
                    'label_option' => esc_html__('Active bar', 'simple-top-bar'),
                    'type_option'  => 'checkbox',
                ),
                'active_TB_ns' => array (
                    'id_option'    => 'stbar_active_non_stop',
                    'label_option' => esc_html__('Active bar non stop', 'simple-top-bar'),
                    'type_option'  => 'checkbox',
                ),
                'delete_option' => array (
                    'id_option'    => 'stbar_delete_option',
                    'label_option' => esc_html__('Delete options when plugin deactivate', 'simple-top-bar'),
                    'type_option'  => 'checkbox',
                ),
            );

            $value_options_position = array(
                'updown' => array (
                    'id_option'    => 'stbar_updown',
                    'label_option' => esc_html__('Placement', 'simple-top-bar'),
                    'type_option'  => 'radio',
                    'radio_options'=> $this->stbar_get_updown(),
                    'validate'     => array(
                        'required' => true,
                    ),
                ),
                'position' => array (
                    'id_option'    => 'stbar_position',
                    'label_option' => esc_html__('Positioned', 'simple-top-bar'),
                    'type_option'  => 'radio',
                    'radio_options'=> $this->stbar_get_position(),
                    'validate'     => array(
                        'required' => true,
                    ),
                ),
            );

            $value_options_laptop = array(
                'TB_height' => array (
                    'id_option'    => 'stbar_block_height',
                    'label_option' => esc_html__('Height top bar > 576px (px)', 'simple-top-bar'),
                    'type_option'  => 'number',
                    'validate'     => array(
                        'required'  => true,
                        'check_min' => 20,
                        'check_max' => 150
                    ),
                ),
                
                'font_size' => array (
                    'id_option'    => 'stbar_font_size',
                    'label_option' => esc_html__('Font size > 576px (px)', 'simple-top-bar'),
                    'type_option'  => 'number',
                    'validate'     => array(
                        'required'  => true,
                        'check_min' => 8,
                        'check_max' => 20
                    ),
                ),
                'block_width_laptop' => array (
                    'id_option'    => 'stbar_block_width_laptop',
                    'label_option' => esc_html__('Bar width (%%)', 'simple-top-bar'),
                    'type_option'  => 'number',
                    'validate'     => array(
                        'required'  => true,
                        'check_min' => 50,
                        'check_max' => 100
                    ),
                ),
            );

            $value_options_tel = array(
                'TB_height_tel' => array (
                    'id_option'    => 'stbar_block_height_tel',
                    'label_option' => esc_html__('Height top bar < 576px (px)', 'simple-top-bar'),
                    'type_option'  => 'number',
                    'validate'     => array(
                        'required'  => true,
                        'check_min' => 20,
                        'check_max' => 150
                    ),
                ),
                'font_size_tel' => array (
                    'id_option'    => 'stbar_font_size_tel',
                    'label_option' => esc_html__('Font size < 576px (px)','simple-top-bar'),
                    'type_option'  => 'number',
                    'validate'     => array(
                        'required'  => true,
                        'check_min' => 10,
                        'check_max' => 30
                    ),
                ),
                'block width tel' => array (
                    'id_option'    => 'stbar_block_width_tel',
                    'label_option' => esc_html__('Bar width (%%)', 'simple-top-bar'),
                    'type_option'  => 'number',
                    'validate'     => array(
                        'required'  => true,
                        'check_min' => 50,
                        'check_max' => 100
                ),
            ),
            );

            $tmp = array();
            array_push($tmp, array(
                    'value_options'          => $value_options,
                    'value_options_position' => $value_options_position,
                    'value_options_laptop'   => $value_options_laptop,
                    'value_options_tel'      => $value_options_tel,
                    )
                );
            return $tmp;
        }

        public function stbar_admin_style() :void{
            wp_enqueue_style( 'stbar_admin', plugins_url( 'admin/css/stbar_admin.css', dirname(__FILE__) ), array(), STBAR_PLUGIN_VERSION);
            wp_enqueue_script( 'stbar_admin', plugins_url( 'admin/js/stbar_admin.js', dirname(__FILE__) ), array(), STBAR_PLUGIN_VERSION, true );
        }

        public function stbar_admin_run() :void{
            add_action( 'admin_enqueue_scripts',  array($this, 'stbar_admin_style') );
            require_once STBAR_PLUGIN_DIR_PATH . 'settings/stbar_settings.php';
            $tmp = new STBAR_option_settings( $this->stbar_set_option() );
        }

        private function stbar_form_radio( array $val) :array{
            $tmp = array();
            foreach ($val as $value) {
                array_push($tmp, array(
                    'id_radio'   => $value['id'],
                    'name_radio' => $value['name']
                    )
                );
            }
            return (array) $tmp;
        }

        private function set_radio( string $id, string $name) :array {
            return (array) array(
                'id'   => $id,
                'name' => $name
            );
        }

        private function stbar_get_position() :array {
            return (array) $this->stbar_form_radio(
                array(
                    'standard' => $this->set_radio('absolute', esc_html__('Movable', 'simple-top-bar')),
                    'fixed'    => $this->set_radio('fixed',    esc_html__('Fixed',   'simple-top-bar'))
                )
            );
        }
        
        private function stbar_get_updown() :array {
            return (array) $this->stbar_form_radio(
                array(
                    'up'   => $this->set_radio( 'up',   esc_html__('Up',   'simple-top-bar')),
                    'down' => $this->set_radio( 'down', esc_html__('Down', 'simple-top-bar'))
                )
            );
        }
    }
}