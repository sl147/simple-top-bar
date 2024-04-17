<?php

if( ! class_exists( 'STBAR_option_settings' ) ) {
	class STBAR_option_settings {

	    /**
	     * @param $stbar_value_options array description each option element as 
	     *         array(id_option => id option, label_option =>label option,  type_option=> type option for input)
	     * 
	     */
	      	
		function __construct( array $stbar_value_options_in) {
			foreach ($stbar_value_options_in as $key => $value) {
				$this->stbar_value_options          = $value['value_options'];
				$this->stbar_value_options_position = $value['value_options_position'];
				$this->stbar_value_options_laptop   = $value['value_options_laptop'];
				$this->stbar_value_options_tel      = $value['value_options_tel'];
			}
			
			$this->stbar_page_slug        = 'stbar_page_slug';
			$this->stbar_page_slug_laptop = $this->stbar_page_slug.'laptop';
			$this->stbar_page_slug_tel    = $this->stbar_page_slug.'tel';

			$this->stbar_option_name      = 'stbar_option_name';

			$this->stbar_settings_bd        = 'stbar_bd';
			$this->stbar_settings_bd_laptop = 'stbar_bd_laptop';
			$this->stbar_settings_bd_tel    = 'stbar_bd_tel';

			$this->stbar_option_group        = 'stbar_option_group';
			$this->stbar_option_group_laptop = 'stbar_option_group_laptop';
			$this->stbar_option_group_tel    = 'stbar_option_group_tel';		
			$this->stbar_settings_errors     = 'stbar_settings_errors';

			add_action( 'admin_menu',            array( $this,'stbar_register_menu') );
			add_action( 'admin_init',            array( $this, 'stbar_register_options' ) );
			add_action( 'admin_init',            array( $this, 'stbar_register_options_position' ) );
			add_action( 'admin_init',            array( $this, 'stbar_register_options_laptop' ) );
			add_action( 'admin_init',            array( $this, 'stbar_register_options_tel' ) );
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
		public function stbar_display_section( string $title) :void{
			echo "<div class='stbar_section'>$title</div>";
		}

	   /**
	     * display option section general
	     * 
	     * @return void
	     */ 
		public function stbar_display_section_general() :void{
			$this->stbar_display_section( esc_html__( 'General', 'simple-top-bar' ) );
		}

	    /**
	     * display option section position
	     * 
	     * @return void
	     */ 
		public function stbar_display_section_position() :void{
			$this->stbar_display_section( esc_html__( 'Bar position', 'simple-top-bar' ) );
		}

	    /**
	     * display option section on laptop
	     * 
	     * @return void
	     */ 
		public function stbar_display_section_laptop() :void{
			$this->stbar_display_section( esc_html__( 'Screen width > 576px', 'simple-top-bar' ) );
		}
		
	    /**
	     * display option section on phone
	     * 
	     * @return void
	     */ 
		public function stbar_display_section_tel() :void{
			$this->stbar_display_section( esc_html__( 'Screen width < 576px', 'simple-top-bar' ) );
		}

	    /**
	     * register options
	     * 
	     * @return void
	     */ 
		private function stbar_register_settings(string $option_group, string $settings_bd, string $section_id, string $display_section, string $page_slug,  $value_options, string $display_input_options) :void{

			register_setting( $option_group, $settings_bd, 	array($this,'stbar_options_validate') );

			add_settings_section( $section_id, '', array($this, $display_section), $page_slug );

			foreach ($value_options as $option) {
				$this->stbar_add_field($page_slug, $section_id, $display_input_options, $option['id_option'], $option['label_option'], $option['type_option']);
			}		
		}

		/**
	     * add setting field
	     * @param $page_slug string page slug
		 * @param $section_id string section id
		 * @param $callback string function callback
		 * @param $name_field string name field
	     * @param $label string label for input
	     * @param $type  string type for input
	     * @return void
	     * 
	     */ 
		private function stbar_add_field(string $page_slug, string $section_id, string $callback, string $name_field, string $label, string $type, string $vals = "") :void {
			add_settings_field(
				$name_field,
				$label,
				array($this, $callback),
				$page_slug,
				$section_id,
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
	     * register options
	     * 
	     * @return void
	     */ 
		public function stbar_register_options_tel() :void{
			$this->stbar_register_settings($this->stbar_option_group_tel, $this->stbar_settings_bd_tel, 'stbar_section_id_tel', 'stbar_display_section_tel', $this->stbar_page_slug_tel, $this->stbar_value_options_tel, 'stbar_display_input_options_tel');
		}

	    /**
	     * register options
	     * 
	     * @return void
	     */ 
		public function stbar_register_options_laptop() :void{
			$this->stbar_register_settings($this->stbar_option_group_laptop, $this->stbar_settings_bd_laptop, 'stbar_section_id_laptop', 'stbar_display_section_laptop', $this->stbar_page_slug_laptop, $this->stbar_value_options_laptop, 'stbar_display_input_options_laptop');
		}
	 
	    /**
	     * register options
	     * 
	     * @return void
	     */ 
		public function stbar_register_options() :void{
			$this->stbar_register_settings($this->stbar_option_group, $this->stbar_settings_bd, 'stbar_section_id', 'stbar_display_section_general', $this->stbar_page_slug, $this->stbar_value_options, 'stbar_display_input_options');
		}
	    
		/**
	     * register options
	     * 
	     * @return void
	     */ 
		public function stbar_register_options_position() :void{
			$this->stbar_register_settings($this->stbar_option_group, $this->stbar_settings_bd, 'stbar_section_id_position', 'stbar_display_section_position', $this->stbar_page_slug, $this->stbar_value_options_position, 'stbar_display_input_options_position');	
		}


		private function get_data(array $field, string $settings_bd, array $value_options) {
			$index = esc_attr( $field['name_field'] );
			$type  = esc_attr( $field['type_field'] );
			$val   = get_option($settings_bd);
			$val   = ($val) ? $val : [];
			if( 'radio' == $type ) {
				require_once STBAR_PLUGIN_DIR_PATH . 'settings/stbar_class_settings_radio.php';
				$tmp = new Stbar_class_settings_radio( $value_options );
				echo $tmp->stbar_input_radio( $val, $index, esc_attr( $settings_bd ) );
			}else{
				require_once STBAR_PLUGIN_DIR_PATH . 'settings/stbar_class_settings_TENCDRT.php';
				$tmp = new Stbar_class_settings_TENCDRT( $value_options );
				echo $tmp->stbar_input_TENCDRT($val, $index, $type, esc_attr($settings_bd));
			}
		}


	    /**
	     * display option for input options for screen > 576px
	     * @param $field array options
	     * @return void
	     * 
	     */ 

		public function stbar_display_input_options_laptop(array $field) :void{
			$this->get_data($field, $this->stbar_settings_bd_laptop, $this->stbar_value_options_laptop);
		}
		    /**
	     * display option for input options for screen < 576px
	     * @param $field array options
	     * @return void
	     * 
	     */ 

		public function stbar_display_input_options_tel(array $field) :void{
			$this->get_data($field, $this->stbar_settings_bd_tel, $this->stbar_value_options_tel);
		}


	    /**
	     * display option for input options general
	     * @param $field array options
	     * @return void
	     * 
	     */ 

		public function stbar_display_input_options(array $field) :void{
			$this->get_data($field, $this->stbar_settings_bd, $this->stbar_value_options);
		}
		
	    /**
	     * display option for input options_position
	     * @param $field array options
	     * @return void
	     * 
	     */ 

		public function stbar_display_input_options_position(array $field) :void{
			$this->get_data($field, $this->stbar_settings_bd, $this->stbar_value_options_position);
		}


	public function display_tab($option_group, $page_slug, $title) {
		?>
		<div class="wrap">		
			<form method="post" action="options.php">
				<div style="background-color: #ffffff;padding-left: 10px;">
				<?php			
					settings_errors( $this->stbar_settings_errors );
					settings_fields( $option_group);
					do_settings_sections( $page_slug );
					submit_button(); 
				?>
			</form>
		</div>
		<?php
	}

	    /**
	     * display form
	     * @return void
	     * 
	     */ 
		public function stbar_form_display() :void{
		$tab_general   = __( 'General',   'simple-top-bar' ); 
	    $tab_on_laptop = __( 'Screen width > 576px', 'simple-top-bar' );
	    $tab_on_phone  = __( 'Screen width < 576px', 'simple-top-bar' );
			
		$tabs = array(
	        'general'   => $tab_general, 
	        'on_laptop' => $tab_on_laptop,
	        'on_phone'  => $tab_on_phone
	    );
		echo "<h2>" . __( 'Bar settings',   'simple-top-bar' ) . "</h2>";
	    $html = '<h3 class="nav-tab-wrapper">';
	    foreach( $tabs as $tab => $name ){
	        $class = ( $tab == $current ) ? 'nav-tab-active' : '';
	        $html .= '<a class="nav-tab ' . $class . '" href="?page='.$this->stbar_page_slug.'&tab=' . $tab . '">' . $name . '</a>';
	    }
	    echo $html .'</h3>';

		$tab = ( ! empty( $_GET['tab'] ) ) ? esc_attr( $_GET['tab'] ) : 'general';

		if (    $tab == 'general' )  $this->display_tab($this->stbar_option_group,        $this->stbar_page_slug,        $tab_general);
		elseif( $tab == 'on_laptop') $this->display_tab($this->stbar_option_group_laptop, $this->stbar_page_slug_laptop, $tab_on_laptop);
		else                         $this->display_tab($this->stbar_option_group_tel,    $this->stbar_page_slug_tel,    $tab_on_phone);
		//echo "<h2>" . __( 'Code after the tabs Simple Top Bar',   'simple-top-bar' ) . "</h2>";	
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