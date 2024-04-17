<?php

/**
 * main class for admin Simple top bar plugin
 */
if( ! class_exists( 'STBAR_ADMIN_MAIN' ) ) {
    class STBAR_ADMIN_MAIN {

        private function stbar_set_option() :array {

            $value_options = array(
                'background_color' => array (
                    'id_option'    => 'stbar_background_color',
                    'label_option' => esc_html__('Bar background color','simple-top-bar'),
                    'type_option'  => 'text',
                    'validate'     => array(
                        'check_color' => true
                    ),
                    'helper'       => esc_html__('Enter bar background color', 'simple-top-bar'),
                ),
                'font_color' => array (
                    'id_option'    => 'stbar_font_color',
                    'label_option' => esc_html__('Bar text color', 'simple-top-bar'),
                    'type_option'  => 'text',
                    'validate'     => array(
                        'check_color' => true
                    ),
                    'helper'       => esc_html__('Enter bar text color', 'simple-top-bar'),
                ),
                'text_TB' => array (
                    'id_option'    => 'stbar_text_option',
                    'label_option' => esc_html__('Text in bar', 'simple-top-bar'),
                    'type_option'  => 'text',
                    'validate'     => array(
                        'required' => true,
                        'class'    => 'stbar_text_option'
                    ),
                    'helper'       => esc_html__('Enter here the text will be displayed in the bar', 'simple-top-bar'),
                ),
                'border radius' => array (
                    'id_option'    => 'stbar_border_radius',
                    'label_option' => esc_html__('Border radius (px)', 'simple-top-bar'),
                    'type_option'  => 'number',
                    'validate'     => array(
                        'check_min'   => 0,
                        'check_max'   => 50
                    ),
                    'helper'       => esc_html__("Defines the radius of a bar's corners. 0(zero) means rectangle", 'simple-top-bar'),

                ),
                'active_TB' => array (
                    'id_option'    => 'stbar_active',
                    'label_option' => esc_html__('Enable bar', 'simple-top-bar'),
                    'type_option'  => 'checkbox',
                    'helper'       => esc_html__('Enable or disable the bar', 'simple-top-bar'),
                ),
                'active_TB_ns' => array (
                    'id_option'    => 'stbar_active_permanently',
                    'label_option' => esc_html__('Enable bar permanently', 'simple-top-bar'),
                    'type_option'  => 'checkbox',
                    'helper'       => esc_html__('If the option is disabled, the panel will not displayed after closing. If the option is enabled, the panel will be displayed after the refreshing', 'simple-top-bar'),
                ),
                'animation_TB' => array (
                    'id_option'    => 'stbar_animation',
                    'label_option' => esc_html__('Enable bar animation', 'simple-top-bar'),
                    'type_option'  => 'checkbox',
                    'helper'       => esc_html__('Enable or disable bar animation', 'simple-top-bar'),
                ),                
                'delete_option' => array (
                    'id_option'    => 'stbar_delete_option',
                    'label_option' => esc_html__('Delete options when plugin deactivate', 'simple-top-bar'),
                    'type_option'  => 'checkbox',
                    'helper'       => esc_html__('If option enable all options will be deleted when plugin deactivate ', 'simple-top-bar'),
                ),
            );

            $value_options_position = array(
                'updown' => array (
                    'id_option'    => 'stbar_placement',
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
                    'label_option' => esc_html__('Bar height (px)', 'simple-top-bar'),
                    'type_option'  => 'number',
                    'validate'     => array(
                        'required'  => true,
                        'check_min' => 20,
                        'check_max' => 150
                    ),
                    'helper'       => esc_html__('The bar height in pixels. min 20px, max 150px', 'simple-top-bar'),
                ),
                
                'font_size' => array (
                    'id_option'    => 'stbar_font_size',
                    'label_option' => esc_html__('Bar text size (px)', 'simple-top-bar'),
                    'type_option'  => 'number',
                    'validate'     => array(
                        'required'  => true,
                        'check_min' => 10,
                        'check_max' => 30
                    ),
                    'helper'       => esc_html__('The bar text size in pixels. min 10px, max 30px', 'simple-top-bar'),
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
                    'helper'       => esc_html__('The bar width in percent. min 50% max 100%', 'simple-top-bar'),
                ),
            );

            $value_options_tel = array(
                'TB_height_tel' => array (
                    'id_option'    => 'stbar_block_height_tel',
                    'label_option' => esc_html__('Bar height (px)', 'simple-top-bar'),
                    'type_option'  => 'number',
                    'validate'     => array(
                        'required'  => true,
                        'check_min' => 20,
                        'check_max' => 150
                    ),
                    'helper'       => esc_html__('The bar height in pixels. min 20px, max 150px', 'simple-top-bar'),
                ),
                'font_size_tel' => array (
                    'id_option'    => 'stbar_font_size_tel',
                    'label_option' => esc_html__('Bar font size (px)','simple-top-bar'),
                    'type_option'  => 'number',
                    'validate'     => array(
                        'required'  => true,
                        'check_min' => 10,
                        'check_max' => 30
                    ),
                    'helper'       => esc_html__('The bar text size in pixels. min 10px, max 30px', 'simple-top-bar'),
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
                    'helper'       => esc_html__('The bar width in percent. min 50% max 100%', 'simple-top-bar'),
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
            return (array) $tmp;
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
                    'fixed'    => $this->set_radio('fixed',    esc_html__('Fixed',   'simple-top-bar')),
                    'standard' => $this->set_radio('absolute', esc_html__('Movable', 'simple-top-bar')),
                )
            );
        }
        
        private function stbar_get_updown() :array {
            return (array) $this->stbar_form_radio(
                array(
                    'up'   => $this->set_radio( 'up',   esc_html__('Top',   'simple-top-bar')),
                    'down' => $this->set_radio( 'down', esc_html__('Bottom', 'simple-top-bar'))
                )
            );
        }
    }
}