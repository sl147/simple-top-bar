<?php
class Sl147_TB_Deactivator {

	public static function deactivate() {
		delete_option('sl147_bd_sl147_Top_Bar');
		delete_option('sl147_bd_tel_sl147_Top_Bar');
		delete_option('sl147_bd_laptop_sl147_Top_Bar');
	}
}