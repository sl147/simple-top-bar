<?php

/**
 * class for input type radio
 */
class Stbar_class_settings_radio {

    /**
     * input for type radio
     * @param $val array options
     * @param $index string name option, id for input
     * @return void
     * 
     */ 
	public function stbar_input_radio( array $val, string $index, string $settings_bd, array $value_options) :string{
		foreach ($value_options as $key => $option) {				
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

		return $tmp;
	}
}