<?php

/**
 * 
 */
class Sl147_TB_admin extends Sl147_TB_main {

    /**
     * Start class
     * 
     * @return void
     */
	
    public function run_admin(){
        $value_options = [
			'background_color' =>			
				array (
					'id_option'    => $this->tb_background_color,
					'label_option' => __('Background color', 'simple-top-bar'),
					'type_option'  => 'text',
					'validate'     => array(
						'required' => true,
						'check_color' => true
				),
            ),
            'font_color' => 
                array (
                    'id_option'    => $this->tb_font_color,
                    'label_option' => __('Font color', 'simple-top-bar'),
                    'type_option'  => 'text',
                    'validate'     => array(
                        'required' => true,
                        'check_color' => true
                ),
                ),
            'text_TB' => 
                array (
                    'id_option'    => $this->tb_text_option,
                    'label_option' => __('Text in top bar', 'simple-top-bar'),
                    'type_option'  => 'text',
                    'validate'     => array(
                        'required' => true,
                        'class'    => 'sl147_TB_text'
                ),
            ),
            'active_TB' => 
                array (
                    'id_option'    => $this->tb_active,
                    'label_option' => __('Active top bar', 'simple-top-bar'),
                    'type_option'  => 'checkbox',
                ),
            'active_TB_ns' => 
                array (
                    'id_option'    => $this->tb_active_non_stop,
                    'label_option' => __('Active top bar non stop', 'simple-top-bar'),
                    'type_option'  => 'checkbox',
                ),

			'border radius' => 
                array (
                    'id_option'    => $this->tb_border_radius,
                    'label_option' => __('Border radius (px)', 'simple-top-bar'),
                    'type_option'  => 'number',
                    'validate'     => array(
                        'check_min'   => 0,
                        'check_max'   => 50
                ),
            ),	
        ];

		$value_options_position = [
		    'position' => 
                array (
                    'id_option'    => $this->tb_position,
                    'label_option' => __('Position', 'simple-top-bar'),
                    'type_option'  => 'radio',
                    'radio_options'=> $this->sl147_get_position()
                ),
            'updown' => 
                array (
                    'id_option'    => $this->tb_updown,
                    'label_option' => __('Up Down', 'simple-top-bar'),
                    'type_option'  => 'radio',
                    'radio_options'=> $this->sl147_get_updown()
                ),
		];

        $value_options_laptop = [
            'block_width_laptop' => 
                array (
                    'id_option'    => $this->tb_block_width_laptop,
                    'label_option' => __('Bar width (%%)', 'simple-top-bar'),
                    'type_option'  => 'number',
                    'validate'     => array(
                        'required' => true,
                        'check_min'   => 50,
                        'check_max'   => 100
                ),
            ),
            'font_size' => 
                array (
                    'id_option'    => $this->tb_font_size_laptop,
                    'label_option' => __('Font size (px)', 'simple-top-bar'),
                    'type_option'  => 'number',
                    'validate'     => array(
                        'required' => true,
                        'check_min'   => 8,
                        'check_max'   => 20
                ),
            ),
            'TB_height' => 
                array (
                    'id_option'    => $this->tb_block_height_laptop,
                    'label_option' => __('Height top bar (px)', 'simple-top-bar'),
                    'type_option'  => 'number',
                    'validate'     => array(
                        'required' => true,
                        'check_min'   => 30,
                        'check_max'   => 100
                ),
            ),
        ];

        $value_options_tel = [
            'block width tel' => 
                array (
                    'id_option'    => $this->tb_block_width_tel,
                    'label_option' => __('Bar width (%%)', 'simple-top-bar'),
                    'type_option'  => 'number',
                    'validate'     => array(
                        'required' => true,
                        'check_min'   => 50,
                        'check_max'   => 100
                ),
            ),
            'font_size_tel' => 
                array (
                    'id_option'    => $this->tb_font_size_tel,
                    'label_option' => __('Font size (px)', 'simple-top-bar'),
                    'type_option'  => 'number',
                    'validate'     => array(
                        'required' => true,
                        'check_min'   => 10,
                        'check_max'   => 30
                ),
            ), 
			'TB_height_tel' => 
                array (
                    'id_option'    => $this->tb_block_height_tel,
                    'label_option' => __('Height top bar (px)', 'simple-top-bar'),
                    'type_option'  => 'number',
                    'validate'     => array(
                        'required' => true,
                        'check_min'   => 30,
                        'check_max'   => 150
                ),
            ),

        ];

        require_once PLUGIN_TB_DIR_PATH . 'settings/sl147_class_settings.php';

		$sl147_options = new Sl147_class_TB_settings(PLUGIN_TB_DIR_PATH, PLUGIN_TB_TEXT_DOMAIN, $this->page_slug, $value_options, $value_options_laptop, $value_options_tel, $value_options_position);
    }

    private function sl147_form_radio($val){
		$tmp = [];
        foreach ($val as $value) {
            $item = [
            'id_radio'   => $value['id'],
            'name_radio' => $value['name']
        ];
        array_push($tmp, $item);
        }
        return $tmp;
    }

    private function set_radio($id, $name) {
        return [
            'id'   => $id,
            'name' => $name
        ];
    }

    private function sl147_get_position(){
        $val = [
            'standard' => $this->set_radio('absolute', __('Movable', 'simple-top-bar')),
            'fixed'    => $this->set_radio('fixed',    __('Fixed',    'simple-top-bar'))
        ];
        return $this->sl147_form_radio($val);
    }
	
    private function sl147_get_updown(){
        $val = [
            'up'   => $this->set_radio('up',   __('Up',   'simple-top-bar')),
            'down' => $this->set_radio('down', __('Down', 'simple-top-bar')),
        ];
        return $this->sl147_form_radio($val);
    }
}