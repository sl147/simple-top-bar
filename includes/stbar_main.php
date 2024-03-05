<?php

/**
 * main class Simple top bar plugin
 */
if( ! class_exists( 'STBAR_MAIN' ) ) {
    class STBAR_MAIN {

        public function stbar_set_shortcode() {

            $val = get_option('stbar_option_name');

            if( ! intval($val['stbar_active']) ) return;

            if( ( 'stbar_text_option' == sanitize_text_field( $_COOKIE["stbar_cookies"] ) ) && ( ! intval( $val['stbar_active_non_stop'])) ) return;

            $set_shortcode = '
                <div class="stbar_notice">
                <span class="stbar_span">'.
                    sanitize_text_field( $val['stbar_text_option'] ) .
                '</span>';

            $set_shortcode .= '
                <button title="'.esc_html__("Close top bar", 'simple-top-bar').'"
                    type="button" 
                    class="stbar_notice_dismiss" 
                    style="background-color:' . sanitize_text_field($val['stbar_background_color']) . '!important; border: 0!important;">
                    <span style="cursor: pointer; color:' . sanitize_text_field($val['stbar_font_color']) .';" class="dashicons dashicons-dismiss"></span>
                </button>
                </div>';
                
            $set_shortcode .= '
                <style>
                    .stbar_notice {
                        color:' . sanitize_text_field($val['stbar_font_color']) .';
                        font-size:' . intval($val['stbar_font_size']) . 'px;
                        background-color:' . sanitize_text_field($val['stbar_background_color']) .';
                        height:' . intval($val['stbar_block_height']) . 'px;
                    }
                    @media screen and (max-width: 576px) {
                        .stbar_notice {
                            font-size:' . intval($val['stbar_font_size_tel']) . 'px;
                            height:' . intval($val['stbar_block_height_tel']) . 'px;
                        }
                    }
                    .stbar_notice_dismiss:before {
                        color: ' . sanitize_text_field($val['stbar_font_color']) . ';
                    }
                </style>
                ';

            return $set_shortcode;
        }

        public function stbar_style(){
            wp_enqueue_style( 'stbar_css', plugins_url( 'public/css/stbar.css', dirname(__FILE__) ) , array(), '1.0.0');
            wp_enqueue_script( 'stbar_js', plugins_url( 'public/js/stbar.js', dirname(__FILE__) ), array(), '1.0.0', true );
        }

        public function stbar_run(){
            add_action( 'wp_enqueue_scripts',  array($this, 'stbar_style') );

            add_shortcode('stbar_output', array($this, 'stbar_set_shortcode'));

            add_action("wp_head", array ($this, "stbar_output_shortcode") );
        }
   
        public function stbar_output_shortcode()  {
            echo do_shortcode('[stbar_output]');
        }
    }
}