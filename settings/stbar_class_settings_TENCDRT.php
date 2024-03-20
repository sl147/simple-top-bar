<?php

/**
 * class for input type text, number, date, range
 */
class Stbar_class_settings_TENCDRT {

    /**
     * get min max value for type number, date
     * @param $min_max string : min or max
     * @param $value_options array value options
     * @return int for number string for date
     * 
     */ 
	private function stbar_get_attribute (string $min_max, string $type, array $value_options) {
		foreach ( $value_options as $key => $option ) {
			if ( sanitize_key($option['id_option']) == $type) {
				foreach ($option as $key1 => $value) {					
					if ( 'validate' == $key1 ){
						foreach ($value as $key2 => $var) {
							if ($key2 == $min_max) return sanitize_text_field($var);
						}
					}
				}
			}
		}
		return false;
	}

    /**
     * get atribute min max value
     * @param $type string  type for input
     * @param $value_options array value options
     * @return value atribute min max
     */ 
	private function stbar_get_min_max( string $type, array $value_options) :string{
		$min = intval($this->stbar_get_attribute('check_min', $type, $value_options));
		$max = intval($this->stbar_get_attribute('check_max', $type, $value_options));

		$input  = (($min) || ($min === 0) ) ? " min=" . $min : "";
		$input .= (($max) || ($max === 0) ) ? " max=" . $max : "";
		return $input;
	}

    /**
     * get atribute pattern
     * @param $type for input
     * @param $value_options array value options
     * @return value atribute pattern
     */ 
	private function stbar_get_required( string $type, array $value_options) :string{
		return (string) ($this->stbar_get_attribute('required', $type, $value_options)) ? " required " : ""; 
	}

    /**
     * get atribute class
     * @param $type for input
     * @param $value_options array value options
     * @return value atribute class
     */ 
	private function stbar_get_class( string $type, array $value_options) :string{
		$class = sanitize_html_class($this->stbar_get_attribute('class', $type, $value_options));
		return (string) ($class) ? " class='" . $class . "'" : "";
	}
	
     /**
     * input for type TENCDRT (Text Email Number Checkbox Date Range Tel)
     * @param $val array options
     * @param $index string name option, id for input
     * @param $type string input type
     * @param $value_options array value options
     * @return void
     * 
     */ 
	public function stbar_input_TENCDRT(array $val, string $index, string $type, string $bd, array $value_options) :string{
		$tmp =  "<input type='$type' id='$index' name='".$bd."[$index]' ";
		if ( 'checkbox' == $type ) {
			$tmp .= "value='1' ".checked( 1, $val[$index], false );	
		}else {
			$tmp .=  "value='". $val[$index]."' ";	
		}

		if (   ( 'number' == $type ) 
			|| ( 'date'   == $type )
			|| ( 'range'  == $type ) ) $tmp .= $this->stbar_get_min_max( $index, $value_options );

		$tmp .= $this->stbar_get_required($index, $value_options);
		$tmp .= $this->stbar_get_class($index, $value_options);

		return $tmp . " />";
	}
}