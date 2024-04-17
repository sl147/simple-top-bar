<?php

/**
 * class for input type radio
 */
class Stbar_class_settings_radio {

	function __construct (array $value_options) {
		$this->value_options = $value_options;
	}

    /**
     * get helper value
     * @param $id_option string id_option option
     * @return string helper text
     * 
     */
	private function stbar_get_helper( string $id_option) :string {
		foreach ( $this->value_options as $option ) {
			if ( sanitize_key($option['id_option']) == $id_option) {
				foreach ($option as $key => $value) {
					if ( 'helper' == $key ) {
						return (string) sanitize_text_field($value);
					}
				}
			}
		}
		return (string) "";
	}

    /**
     * input for type radio
     * @param $val array options
     * @param $index string name option, id for input
     * @return void
     * 
     */ 
	public function stbar_input_radio( array $val, string $index, string $settings_bd) :string{
		foreach ($this->value_options as $key => $option) {				
			if ($index == $option['id_option']) {
				$vals = $option['radio_options'];
			}
		}
		
		$vals = ($vals) ? $vals : [];
		$tmp  ="";
		foreach ($vals as $value) {
			$value_id = esc_attr($value['id_radio']);
			$selected = ($val[$index] == $value_id) ? "checked " : '';        
			$tmp .= "<div class='stbar_input_radio'>";
			$tmp .= "<input type='radio' id='".$value_id . "' name='" . $settings_bd . "[$index]' value='". $value_id . "' " . $selected . ">";
			$tmp .= "<label for='$value_id'>" . esc_attr($value['name_radio']) . "</label>";

			$tmp .="</div>";
		}

		return (string) $tmp . "<span style='margin-left: 30px;font-size:12px'>" . $this->stbar_get_helper($index) . "</span>";
	}
}