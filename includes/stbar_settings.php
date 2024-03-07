<?php

if( ! class_exists( 'STBAR_option_settings' ) ) {
	class STBAR_option_settings {

	    /**
	     * @param $stbar_value_options array description each option element as 
	     *         array(id_option => id option, label_option =>label option,  type_option=> type option for input)
	     * 
	     * 
	     */ 	
		function __construct( array $stbar_value_options) {

			$this->stbar_value_options   = $stbar_value_options;
			$this->stbar_page_slug       = 'stbar_page_slug';
			$this->stbar_section_id      = 'stbar_section_id';
			$this->stbar_option_name     = 'stbar_option_name';
			$this->stbar_option_group    = 'stbar_option_group';		
			$this->stbar_settings_errors = 'stbar_settings_errors';

			add_action( 'admin_menu',            array($this,'stbar_register_menu') );
			add_action( 'admin_init',            array( $this, 'stbar_register_options' ) );
			add_action( 'admin_notices',         array( $this, 'stbar_display_notice' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'stbar_color_picker' ) );
	    }

	    /**
	     * register smenu
	     * @return void
	     */ 
		public function stbar_register_menu() {
            add_menu_page(esc_html__( 'Settings', 'simple-top-bar' ), esc_html__( 'Simple top bar', 'simple-top-bar' ), 'manage_options', 'stbar_page_slug',  array( $this, 'stbar_form_display' ) ,"dashicons-align-center",5);
        }

	    /**
	     * register script and style for color picker
	     * 
	     */ 
	    public function stbar_color_picker( $hook ) {
	        wp_enqueue_script( 'wp-color-picker' );
	        wp_enqueue_style ( 'wp-color-picker' );
	    }
	    
	    /**
	     * display option section
	     * 
	     * @return void
	     */ 
		public function stbar_display_section() :void{

		}

	    /**
	     * register options
	     * 
	     * @return void
	     */ 
		public function stbar_register_options() :void{
			register_setting(
				$this->stbar_option_group,
				$this->stbar_option_name,
				array($this,'stbar_options_validate')
			 );

			add_settings_section( $this->stbar_section_id, '', array($this,'stbar_display_section'), $this->stbar_page_slug );
			if( is_array($this->stbar_value_options)) {
				foreach ($this->stbar_value_options as $option) {
					$this->stbar_add_field( esc_html( $option['id_option'] ), esc_html( $option['label_option'] ), esc_html( $option['type_option'] ));
				}
			}
		}

	    /**
	     * add setting field
	     * @param $name_field string name field
	     * @param $label string label for input
	     * @param $type  string type for input
	     * @return void
	     * 
	     */ 
		private function stbar_add_field(string $name_field, string $label, string $type, string $vals = "") :void {
			add_settings_field(
				$name_field,
				$label,
				array($this, 'stbar_display_input_options'),
				$this->stbar_page_slug,
				$this->stbar_section_id,
				array( 
					'label_for'  => $name_field,
					'class'      => 'stbar_class',
					'name_field' => $name_field,
					'type_field' => $type,
					'vals'       => $vals
				)
			);
		}

	    /**
	     * get attribute 
	     * @param $key_value string value key in value_options
	     * @return int for number string for date
	     * 
	     */ 
		private function stbar_get_attribute (string $key_value, string $type) :string{
			foreach ( $this->stbar_value_options as $key => $option ) {
				$option['id_option'] = sanitize_key($option['id_option']);
				if ( esc_html( $option['id_option'] ) == $type) {
					foreach ($option as $key1 => $value1) {					
						if ( 'validate' == $key1 ){
							foreach ($value1 as $key2 => $value2) {
								if ($key2 == $key_value) return esc_html( $value2 );
							}
						}
					}
				}
			}
			return "";
		}

	    /**
	     * get atribute min max value
	     * @param $type for input
	     * @return value atribute min max
	     */ 
		private function stbar_get_min_max( string $type) :string {
			$min    = intval($this->stbar_get_attribute('check_min', $type));
			$max    = intval($this->stbar_get_attribute('check_max', $type));
			$input  = ($min) ? " min=" . $min : "";
			$input .= ($max) ? " max=" . $max : "";

			return (string) $input;
		}

	    /**
	     * get required atribute
	     * @param $type for input
	     * @return value required atribute
	     */ 
		private function stbar_get_required( string $type ) :string{
			return (string) (sanitize_text_field($this->stbar_get_attribute('required', $type))) ? " required " : ""; 
		}

	    /**
	     * get atribute class
	     * @param $type for input
	     * @return value atribute class
	     */ 
		private function stbar_get_class( string $type ) :string {
			$class  = sanitize_html_class($this->stbar_get_attribute('class', $type));

			return (string) ($class) ? " class='" . $class . "'" : "";
		}

		public function stbar_input_radio($val, $index){
			foreach ($this->stbar_value_options as $key => $option) {				
				if ($index == $option['id_option']) {
					$vals = $option['radio_options'];
				}
			}
			
			$vals = ($vals) ? $vals : [];
			$tmp = "<div style='display:flex; align-items: center;margin-bottom: 10px;'>";
			foreach ($vals as $value) {
				$selected = ($val[$index] == $value['id_radio']) ? "checked " : ''; 

				$tmp .= "<input type='radio' id='".esc_attr($value['id_radio']) . "' name='" . esc_attr($this->stbar_option_name) . "[$index]' value='" . esc_attr($value['id_radio'])."' ".$selected;
				$tmp .=$this->stbar_get_required( $index ) . " />";
				$tmp .= "<label style='margin-right:20px;padding-bottom: 6px;' for=".$value['id_radio'].">".$value['name_radio']."</label>";
				
			}
			return $tmp."</div>";
		}		
	     /**
	     * input for type TENCDRT (Text Email Number Checkbox Date Range Tel)
	     * @param $val array value
	     * @param $field array options
	     * @return void
	     * 
	     */ 

		private function stbar_input_TENCDRT(array $val, array $field) :string{
			$index = esc_attr( $field['name_field'] );
			$type  = esc_attr( $field['type_field'] );

			if( 'radio' == $type) {
				$txt_out = $this->stbar_input_radio($val, $index);
			}else{
				$txt_out = '<input type="' . $type . '" id="' . $index . '" name="' . $this->stbar_option_name . '[' . $index . ']" ';
				if ( 'checkbox' == $type ) {
					$txt_out .= 'value="1" ';
					if ( 1 == intval($val[$index] )) $txt_out .='checked="checked"';
				}else {
					$txt_out .= 'value="'. esc_attr($val[$index]) . '"';	
				}
				if (   ( 'number' ==  $type ) 
					|| ( 'date'   ==  $type )
					|| ( 'range'  ==  $type )
					|| ( 'tel'    ==  $type ) ) $txt_out .= $this->stbar_get_min_max( $index );

				$txt_out .=$this->stbar_get_required( $index );
			}

			
			$txt_out .=$this->stbar_get_class( $index );

			if( 'radio' == $type) {
				return (string) $txt_out;	
			}
			
			return (string) $txt_out . " />";

		}

	    /**
	     * display option for input
	     * @param $field array options
	     * @return void
	     * 
	     */ 

		public function stbar_display_input_options($field) :void{
			$data = get_option($this->stbar_option_name);
			$val  = ($data) ? $data : [];

			echo $this->stbar_input_TENCDRT( $val, $field );
		}

	    /**
	     * display form
	     * @return void
	     * 
	     */ 
		public function stbar_form_display() :void{
			?>
			<div class="wrap">
				<h1><?php esc_html_e( 'Simple top bar settings', 'simple-top-bar'  ) ?></h1>
				<form method="post" action="options.php">
					<?php
						settings_errors( $this->stbar_settings_errors, true );
						settings_fields( $this->stbar_option_group);
						do_settings_sections( $this->stbar_page_slug );
						submit_button(); 
					?>
				</form>
			</div>
			<?php
		}

	    /**
	     * display notice
	     * @return void
	     * 
	     */ 	
		public function stbar_display_notice() :void {

			if ( ! empty( get_settings_errors( $this->stbar_settings_errors ) ) ) return;
			
			if( isset( $_GET[ 'page' ] )
				&& $this->stbar_page_slug == sanitize_text_field( $_GET[ 'page' ] )
				&& isset( $_GET[ 'settings-updated' ] )
				&& true == sanitize_text_field( $_GET[ 'settings-updated' ] )

			) {
				?>
					<div class="notice notice-success is-dismissible">
						<p><?php esc_html_e( 'Settings updated', 'simple-top-bar'  )?></p>
					</div>
				<?php
			}
		}

	    /**
	     * Check valid HEX code.
	     * 
	     * @param  $color string HEX code
	     * @return bool true if $color is #000 or #000000
	     */

	    private function stbar_check_color( string $color ) :bool { 
	    	return ( ( preg_match( '/^#[a-f0-9]{6}$/i', $color )) || (preg_match( '/^#[a-f0-9]{3}$/i', $color ))  ) ? true : false;
	    }

	    /**
	     * validate input data
	     * @param $input array 
	     * @return array
	     */ 
		public function stbar_options_validate( array $input ) :array {
			foreach( $input as $name_option => & $val ){
				if( is_array( $this->stbar_value_options )) {
					foreach ( $this->stbar_value_options as $key => $option ) {	
						if (esc_html($name_option) == esc_html( $option['id_option'] ) ) {
							if ( 'stbar_text_option'  == esc_html( $option['id_option']) ) {
								$val = sanitize_text_field($val);
							}
							if ( $option['validate'] && is_array( $option['validate'])) {
								foreach ( $option['validate'] as $key_validate => $value ) {
									if ( 'check_color' == $key_validate) {
										if(!$this->stbar_check_color($val)) {
											$input[$option['id_option']] = $this->stbar_add_error( esc_html($name_option),esc_html($option['label_option'])  . ': '.
											sprintf(
												esc_html__('wrong color code %s ','simple-top-bar' ),
												esc_html( $val )
											) );
										}
									}
								}
							}
						}
					}
				}
			}
			
			return (array) $input;
		}

	    /**
	     * add eroor message and return field value
	     * @param $name_field string 
	     * @param $message string error message 
	     * @return 
	     */ 
		private function stbar_add_error( string $name_field, string $message ) {
			add_settings_error(
				$this->stbar_settings_errors,
				$name_field,
				$message,
				'error'
			);
			if (get_option($this->stbar_option_name)) {
				if ( is_array( get_option($this->stbar_option_name))) {
					foreach (get_option($this->stbar_option_name) as $key => $option) {
						if ($key == $name_field) return $option;
					}
				}
			}else {
				return "";
			}
		}
	}
}