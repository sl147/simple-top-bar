<?php

/**
 * 
 */
class Sl147_TB extends Sl147_TB_main{

    /**
     * shortcode. Place [sl147_TB_display] in header.php after <body>
     * 
     */ 
    public function sl147_TB_output_shortcode() {
        $val        = get_option($this->option_name);
        $val_tel    = get_option($this->option_name_tel);
        $val_laptop = get_option($this->option_name_laptop);
        $button     = '';
        if($val[$this->tb_active]) {
				if( !(htmlspecialchars($_COOKIE["sl147_tb"])) || ($val[$this->tb_active_non_stop]) ) {
                $button = '
                <div class="sl147_TB_block">
                <div class="sl147_tb_notice">
                <span class="sl147_span">'.
                $val[$this->tb_text_option].
                '</span>';
                $button .= '
                <button title="'.__("Close top bar", 'simple-top-bar').'" type="button" class="sl147_notice_dismiss" style="background-color:' . $val[$this->tb_background_color] . '!important; border: 0!important;">
                    <i style="cursor: pointer; color:'.$val[$this->tb_font_color].';" class="fa fa-times-circle" aria-hidden="true"></i>
                </button>
                </div></div>';
                
                $button .= '
                    <style> 
                        .sl147_tb_notice {
                            color:'.$val[$this->tb_font_color].';
                            font-size:'.$val_laptop[$this->tb_font_size_laptop].'px;
                            background-color:'.$val[$this->tb_background_color].';
                            height:'.$val_laptop[$this->tb_block_height_laptop].'px;
                            display: flex;
                            display: -webkit-flex;
                            align-items: center;
                            justify-content: center;                           
                            z-index:99999;
                            width:' . $val_laptop[$this->tb_block_width_laptop] . '%;
							border-radius:' . $val[$this->tb_border_radius] . 'px;
                            position:' . $val[$this->tb_position] . ';';
                if ($val[$this->tb_updown] == 'up') {
                    $button .= 'top:0;';
					if( is_admin_bar_showing() ) $button .= 'margin-top:32px;';
                }else{
                    $button .= 'bottom:0;';
                }			
				              
				$button .= '}';   
                $button .= '@media screen and (max-width: 576px) {
                            .sl147_tb_notice {
                                font-size:'.$val_tel[$this->tb_font_size_tel].'px;
                                height:'.$val_tel[$this->tb_block_height_tel].'px;
                                width:' . $val_tel[$this->tb_block_width_tel] . '%;
                                padding-left: 10px;
                                padding-right: 10px;';
				if ($val[$this->tb_updown] == 'up') {
                    $button .= 'top:0;';
					if( is_admin_bar_showing() ) $button .= 'margin-top:46px;';
                } 
                $button .= '
                            }                           
                        }                       
                        .sl147_notice_dismiss:before {
                            background: 0 0;
                            color: '.$val[$this->tb_font_color].';
                            display: block;
                            font: normal 16px/20px dashicons;
                            height: 20px;
                            text-align: center;
                            width: 20px;
                            -webkit-font-smoothing: antialiased;
                            -moz-osx-font-smoothing: grayscale
                        }
                    </style>
                    ';
            $button .= '
                <script>
                    function sl147_setCookie() {
                        document.cookie = "sl147_tb=1; path=/;"
                        return true;
                    }
                    jQuery(".sl147_notice_dismiss").click(function() {
                        jQuery(".sl147_tb_notice").remove();
                        sl147_setCookie();
                        })
                </script>
                ';
            }
        }
        
        ?>
        <?php
        echo $button;
        return $button;
    }

    public function sl147_TB_display(){
        echo do_shortcode( '[sl147_TB_display]' );
    }
    /**
     * Start class
     * 
     * @return void
     */

    public function run(){
        add_action("wp_head", array ($this, "sl147_TB_output_shortcode")); 

           
    }
}