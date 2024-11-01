<?php

/**
 * Fired during plugin activation
 *
 * @link       www.presstigers.com
 * @since      1.0.0
 *
 * @package    Simple_Vote
 * @subpackage Simple_Vote/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Simple_Vote
 * @subpackage Simple_Vote/includes
 * @author     Presstigers <support@presstigers.com>
 */

class Simple_Vote_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */

	public static function activate() {

		/**
		 * Gathering all post types in a single array.
		 */

		$get_default_post_types = array(
            'public'   => true,
            '_builtin' => true
		);

        $get_custom_post_types = array(
            'public'   => true,
            '_builtin' => false
        );

        $post_types = array();

        $default_post_types = get_post_types( $get_default_post_types, 'object' );
        foreach ( $default_post_types as $post_key => $post_val ){
            $post_types[$post_val->name] = $post_val->label;
        }

        $default_post_types = get_post_types( $get_custom_post_types, 'object' );
        foreach ( $default_post_types as $post_key => $post_val ){
            $post_types[$post_val->name] = $post_val->label;
        }

		$check_boxes_array = array();
		$i=0;
		foreach ( $post_types as $post_key => $post_val ){
			$check_boxes_array[$i]=$post_key;
			$i++;
		}

		// Setting default values for when plugin is avtivated user can have some view without going into settings.
		if(!sanitize_option("post_titles", update_option("post_titles", $check_boxes_array))){
			sanitize_option("post_titles", update_option("post_titles", $check_boxes_array));
		}

		sanitize_option("section_padding", update_option("section_padding","0"));
		sanitize_option("section_alignment", update_option("section_alignment","center"));
		sanitize_option("section_bg_color", update_option("section_bg_color","#ffffff"));
		sanitize_option("text_color", update_option("text_color","#000000"));
		sanitize_option('alert_font_family', update_option('alert_font_family','Default'));
		sanitize_option('alert_font_style', update_option('alert_font_style','normal'));
		sanitize_option('alert_font_weight', update_option('alert_font_weight','bold'));
		sanitize_option("like_bg_color", update_option("like_bg_color","#ffffff"));
		sanitize_option("like_color", update_option("like_color","#28a745"));
		sanitize_option("like_loader_color", update_option("like_loader_color","#28a745"));
		sanitize_option("like_loader_border_color", update_option("like_loader_border_color","#e0e0e0"));
		sanitize_option("dislike_bg_color", update_option("dislike_bg_color","#ffffff"));
		sanitize_option("dislike_color", update_option("dislike_color","#dc3545"));
		sanitize_option("dislike_loader_color", update_option("dislike_loader_color","#dc3545"));
		sanitize_option("dislike_loader_border_color", update_option("dislike_loader_border_color","#e0e0e0"));

	}
}