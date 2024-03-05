<?php
if( ! class_exists( 'STBAR_Deactivator' ) ) {
	
	class STBAR_Deactivator {

		public static function deactivate() {

			$val = get_option('stbar_option_name');

			if( $val['stbar_delete_option'] ) {
				delete_option('stbar_option_name');	
			}
		}
	}
}