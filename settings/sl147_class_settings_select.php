<?php

/**
 * 
 */
class Sl147_class_settings_select {

	private function sl147_get_select(){
		$args = array(
		    'taxonomy' => 'product_cat',
			'order'    => 'ASC'
		  );

		$cat = get_categories($args );
		$val = [];
		if ($cat) {
			foreach ($cat as  $value) {
						$item = [
							'id_select' => $value->term_id,
							'name_select' => $value->name
						];
						array_push($val, $item);				
			}
		}
		return $val;
	}

    /**
     * input for type select
     * @param $val array options
     * @param $index string name option, id for input
     * @return void
     * 
     */ 
	public function sl147_input_select($val, $index, $settings_bd, $value_options){
		foreach ($value_options as $key => $option) {
			if ( $index == $option['id_option']) {
				$vals = $this->sl147_get_select();
				//$vals = $option['select_options'];
				echo "<select id='$index' name='" . $settings_bd . "[$index]'>";
				foreach ($vals as $value) {
					$selected = ($val[$index] == $value['id_select']) ? "selected='selected'" : '';        
					echo "<option value = '".$value['id_select']."' $selected>".$value['name_select'] ."</option>";
				}
				echo "</select>";
			}
		}
	}
}