<?php 

/**
 * This class is responsible for displaying admin menu item.
 *
 * @link       www.presstigers.com
 * @since      1.0.0
 *
 * @package    Simple_Vote
 * @subpackage Simple_Vote/admin/settings
 * @author     Presstigers <support@presstigers.com>
 */

class Simple_Vote_Settings_Admin {

    /**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

    /**
     * Constructor of the class.
     *
     * @since  1.0.0
     * @access public
     * @param {void}
     * @return {void}
     */

    public function __construct($plugin_name){
        $this->plugin_name = $plugin_name;
    }

    /**
     * Adding admin menu items
     *
     * @since  1.0.0
     * @access public
     * @param {void}
     * @return {void}
     */

    function sv_add_new_menu_items(){
        add_menu_page(
            esc_html__("Simple Vote", "simple-vote"),
            esc_html__("Simple Vote", "simple-vote"),
            "manage_options",
            "theme-options",
            array($this, "sv_admin_menu_item"),
            "dashicons-thumbs-up",
            100
        );
    }

    /**
     * Adding admin menu items callback function
     *
     * @since  1.0.0
     * @access public
     * @param {void}
     * @return {void}
     */
 
    function sv_admin_menu_item(){
        wp_enqueue_script( $this->plugin_name );
        $active_tab = isset($_GET['tab']) ? sanitize_key($_GET['tab']) : sanitize_key('sv_general');
        ?>
            <div class="wrap">
                <h2><?php esc_html_e('Simple Vote Settings', 'simple-vote');?></h2>
                <?php
                    //on click of submit_button displays success of error message
                    settings_errors();
                ?>
                <div class="wrap-nav-tab">
                    <h2 class="nav-tab-wrapper">
                        <a href="?page=theme-options&tab=sv_general" class="nav-tab <?php echo $active_tab == 'sv_general' ? esc_html_e('nav-tab-active') : '';?>"><?php esc_html_e('General', 'simple-vote');?><a>
                        <a href="?page=theme-options&tab=sv_views" class="nav-tab <?php echo $active_tab == 'sv_views' ? esc_html_e('nav-tab-active') : ''; ?>"><?php esc_html_e('Views', 'simple-vote');?></a>
                    </h2>
                    <form class="settings-form" method="post" action="options.php">
                        <?php

                            if ($active_tab == 'sv_general') {
                                settings_fields("general_header_section");
                                do_settings_sections("general-theme-options");
                            } else if ($active_tab == 'sv_views') {
                                settings_fields('views_header_section');
                                do_settings_sections('views-theme-options');
                            }
                            submit_button('Save Settings');

                        ?>
                    </form>
                </div>
            </div>
        <?php
    }

    /**
     * This function displays options on admin menu page
     *
     * @since  1.0.0
     * @access public
     * @param {void}
     * @return {void}  
     */

    function sv_menu_display_options(){

        /////////This is for General Settings page only
        add_settings_section("general_header_section", "", array($this, "sv_general_display_header_options_content"), "general-theme-options");

        add_settings_field("post_titles", "", array($this, "sv_general_display_posts_titles"), "general-theme-options", "general_header_section");

        register_setting("general_header_section", "post_titles");

        /////////This is for Views page only
        add_settings_section("views_header_section", "", array($this, "sv_views_display_header_options_content"), "views-theme-options");

        add_settings_field("section_alignment", "", array($this, "sv_views_section"), "views-theme-options", "views_header_section");
        add_settings_field("text_color", "", array($this, "sv_views_text"), "views-theme-options", "views_header_section");
        add_settings_field("like_bg_color", "", array($this, "sv_views_like"), "views-theme-options", "views_header_section");
        add_settings_field("dislike_bg_color", "", array($this, "sv_views_dislike"), "views-theme-options", "views_header_section");

        register_setting("views_header_section", "section_alignment");
        register_setting("views_header_section", "section_bg_color");
        register_setting("views_header_section", "text_color");
        register_setting("views_header_section", "success_text_color");
        register_setting("views_header_section", "error_text_color");
        register_setting("views_header_section", "alert_font_family");
        register_setting("views_header_section", "alert_font_style");
        register_setting("views_header_section", "alert_font_weight");
        register_setting("views_header_section", "like_bg_color");
        register_setting("views_header_section", "like_color");
        register_setting("views_header_section", "like_loader_color");
        register_setting("views_header_section", "like_loader_border_color");
        register_setting("views_header_section", "dislike_bg_color");
        register_setting("views_header_section", "dislike_color");
        register_setting("views_header_section", "dislike_loader_color");
        register_setting("views_header_section", "dislike_loader_border_color");
    }

    /**
     * This function displays headings on Admin menu page
     *
     * @since  1.0.0
     * @access public
     * @param {void}
     * @return {void}
     */

    function sv_general_display_header_options_content(){
        ?>
        <h4><?php esc_html_e('Select from following post types on which you want to activate Simple Vote:', 'simple-vote');?></h4>
        <?php
    }

    /**
     * This function displays checkboxes
     *
     * @since  1.0.0
     * @access public
     * @param {void}
     * @return {void}
     */

    function sv_general_display_posts_titles(){

        //getting default post type names
        $get_default_post_types = array(
            'public'   => true,
            '_builtin' => true
        );

        //getting custom pot type names
        $get_custom_post_types = array(
            'public'   => true,
            '_builtin' => false
        );

        $post_types = array();          

        /**
         * merging both arrays of post type names into one.
         */

        $default_post_types = get_post_types( $get_default_post_types, 'object' );
        foreach ( $default_post_types as $post_key => $post_val ){
            $post_types[$post_val->name] = $post_val->label;
        }

        $default_post_types = get_post_types( $get_custom_post_types, 'object' );
        foreach ( $default_post_types as $post_key => $post_val ){
            $post_types[$post_val->name] = $post_val->label;
        }

        $check_boxes_array = sanitize_option("post_titles", get_option("post_titles"));

        //checking if returned array is empty or not.
        if(empty($check_boxes_array)){
            $check_boxes_array = array();
        }

        ?>
        <?php

        /**
         * displaying checkboxes
         */
        $ptcount=1;
        $id_chkb="post_titles";
        foreach ( $post_types as $post_key => $post_val ){

            //if post type is present in post_titles array i.e., if user has marked this post type in plugin settings page
            if(in_array($post_key, $check_boxes_array)){

                // displaying checked checkboxes
                ?>
                    <input type="checkbox" id="<?php esc_html_e($id_chkb.$ptcount);?>" name="post_titles[]" value="<?php esc_html_e($post_key) ?>"checked>
                    <label for="<?php esc_html_e($id_chkb.$ptcount);?>"><?php esc_html_e($post_val) ?></label>
                    <br>
                <?php
            }

            // displaying unchecked checkboxes
            else{
                ?>
                    <input type="checkbox" id="<?php esc_html_e($id_chkb.$ptcount);?>" name="post_titles[]" value="<?php esc_html_e($post_key) ?>">
                    <label for="<?php esc_html_e($id_chkb.$ptcount);?>"><?php esc_html_e($post_val) ?></label>
                    <br>
                <?php
            }
            $ptcount++;
        }
    }

    //////////////////////VIEWS

    /**
     * This function displays headings on Views page
     *
     * @since  1.0.0
     * @access public
     * @param {void}
     * @return {void}
     */

    function sv_views_display_header_options_content(){
        ?>
        <h4><?php esc_html_e('Select from following how you want to style Simple Vote:', 'simple-vote');?></h4>
        <?php
    }

    /**
     * This function displays section settings
     *
     * @since  1.0.0
     * @access public
     * @param {void}
     * @return {void}
     */

    function sv_views_section(){
    ?>
        <button type="button" class="sv_accordion"><?php esc_html_e('Section', 'simple-vote');?></button>
        <div class="sv_panel">
            <div class="sv_views">
                <label><?php esc_html_e('Section Alignment:', 'simple-vote');?></label>
                <span class="sv_radio">
                <?php if( get_option('section_alignment') == "left"){?>
                    <input type="radio" class="section_alignment" id="section-alignment-left" name="section_alignment" value="left" checked><?php esc_html_e('Left', 'simple-vote');?></input>
                    <input type="radio" class="section_alignment" id="section-alignment-center" name="section_alignment" value="center"><?php esc_html_e('Center', 'simple-vote');?></input>
                    <input type="radio" class="section_alignment" id="section-alignment-right" name="section_alignment" value="right"><?php esc_html_e('Right', 'simple-vote');?></input>
                <?php } else if( get_option('section_alignment') == "right"){?>
                    <input type="radio" class="section_alignment" id="section-alignment-left" name="section_alignment" value="left"><?php esc_html_e('Left', 'simple-vote');?></input>
                    <input type="radio" class="section_alignment" id="section-alignment-center" name="section_alignment" value="center"><?php esc_html_e('Center', 'simple-vote');?></input>
                    <input type="radio" class="section_alignment" id="section-alignment-right" name="section_alignment" value="right" checked><?php esc_html_e('Right', 'simple-vote');?></input>
                <?php } else if( get_option('section_alignment') == "center"){?>
                    <input type="radio" class="section_alignment" id="section-alignment-left" name="section_alignment" value="left"><?php esc_html_e('Left', 'simple-vote');?></input>
                    <input type="radio" class="section_alignment" id="section-alignment-center" name="section_alignment" value="center" checked><?php esc_html_e('Center', 'simple-vote');?></input>
                    <input type="radio" class="section_alignment" id="section-alignment-right" name="section_alignment" value="right"><?php esc_html_e('Right', 'simple-vote');?></input>
                <?php }?>
                </span>
            </div>
            <div class="sv_views">
                <label><?php esc_html_e('Section Background Color:', 'simple-vote');?></label>
                <input type="color" class="section_bg_color" id="section-bg-color" name="section_bg_color" value="<?php echo sanitize_option('section_bg_color', get_option('section_bg_color')); ?>">
            </div>
        </div>
    <?php
    }
   
    /**
     * This function displays text settings
     *
     * @since  1.0.0
     * @access public
     * @param {void}
     * @return {void}
     */

    function sv_views_text(){
        ?>
        <button type="button" class="sv_accordion"><?php esc_html_e('Text', 'simple-vote');?></button>
            <div class="sv_panel">
                <div class="sv_views">
                    <label><?php esc_html_e('Text Color:', 'simple-vote');?></label>
                    <input type="color" class="text_color" id="text-color" name="text_color" value="<?php echo sanitize_option('text_color', get_option('text_color')); ?>">
                </div>
                <div class="sv_views">
                    <label><?php esc_html_e('Alert Font Family:', 'simple-vote');?></label>
                    <select class="alert_font_family" id="alert-font-family" name="alert_font_family">
                        <?php if( get_option('alert_font_family')=='Default'){?>
                            <option class="alert_font_family" id="alert-font-family" name="alert_font_family" value="Default" selected><?php esc_html_e('Default', 'simple-vote');?></option>
                            <option class="alert_font_family" id="alert-font-family" name="alert_font_family" value="Arial"><?php esc_html_e('Arial', 'simple-vote');?></option>
                            <option class="alert_font_family" id="alert-font-family" name="alert_font_family" value="Helvetica"><?php esc_html_e('Helvetica', 'simple-vote');?></option>
                            <option class="alert_font_family" id="alert-font-family" name="alert_font_family" value="Lucida Console"><?php esc_html_e('Lucida Console', 'simple-vote');?></option>
                            <option class="alert_font_family" id="alert-font-family" name="alert_font_family" value="Times New Roman"><?php esc_html_e('Times New Roman', 'simple-vote');?></option>
                        <?php
                        }else if ( get_option('alert_font_family')=='Arial'){    
                        ?>
                            <option class="alert_font_family" id="alert-font-family" name="alert_font_family" value="Default"><?php esc_html_e('Default', 'simple-vote');?></option>
                            <option class="alert_font_family" id="alert-font-family" name="alert_font_family" value="Arial" selected><?php esc_html_e('Arial', 'simple-vote');?></option>
                            <option class="alert_font_family" id="alert-font-family" name="alert_font_family" value="Helvetica"><?php esc_html_e('Helvetica', 'simple-vote');?></option>
                            <option class="alert_font_family" id="alert-font-family" name="alert_font_family" value="Lucida Console"><?php esc_html_e('Lucida Console', 'simple-vote');?></option>
                            <option class="alert_font_family" id="alert-font-family" name="alert_font_family" value="Times New Roman"><?php esc_html_e('Times New Roman', 'simple-vote');?></option>
                     
                        <?php
                        }else if ( get_option('alert_font_family')=='Helvetica'){    
                        ?>
                            <option class="alert_font_family" id="alert-font-family" name="alert_font_family" value="Default"><?php esc_html_e('Default', 'simple-vote');?></option>
                            <option class="alert_font_family" id="alert-font-family" name="alert_font_family" value="Arial" ><?php esc_html_e('Arial', 'simple-vote');?></option>
                            <option class="alert_font_family" id="alert-font-family" name="alert_font_family" value="Helvetica" selected><?php esc_html_e('Helvetica', 'simple-vote');?></option>
                            <option class="alert_font_family" id="alert-font-family" name="alert_font_family" value="Lucida Console"><?php esc_html_e('Lucida Console', 'simple-vote');?></option>
                            <option class="alert_font_family" id="alert-font-family" name="alert_font_family" value="Times New Roman"><?php esc_html_e('Times New Roman', 'simple-vote');?></option>
                   
                        <?php
                        }else if ( get_option('alert_font_family')=='Lucida Console'){    
                        ?>
                            <option class="alert_font_family" id="alert-font-family" name="alert_font_family" value="Default"><?php esc_html_e('Default', 'simple-vote');?></option>
                            <option class="alert_font_family" id="alert-font-family" name="alert_font_family" value="Arial" ><?php esc_html_e('Arial', 'simple-vote');?></option>
                            <option class="alert_font_family" id="alert-font-family" name="alert_font_family" value="Helvetica"><?php esc_html_e('Helvetica', 'simple-vote');?></option>
                            <option class="alert_font_family" id="alert-font-family" name="alert_font_family" value="Lucida Console" selected><?php esc_html_e('Lucida Console', 'simple-vote');?></option>
                            <option class="alert_font_family" id="alert-font-family" name="alert_font_family" value="Times New Roman"><?php esc_html_e('Times New Roman', 'simple-vote');?></option>
                        <?php
                        }else if ( get_option('alert_font_family')=='Times New Roman'){    
                        ?>
                            <option class="alert_font_family" id="alert-font-family" name="alert_font_family" value="Default"><?php esc_html_e('Default', 'simple-vote');?></option>
                            <option class="alert_font_family" id="alert-font-family" name="alert_font_family" value="Arial" ><?php esc_html_e('Arial', 'simple-vote');?></option>
                            <option class="alert_font_family" id="alert-font-family" name="alert_font_family" value="Helvetica"><?php esc_html_e('Helvetica', 'simple-vote');?></option>
                            <option class="alert_font_family" id="alert-font-family" name="alert_font_family" value="Lucida Console"><?php esc_html_e('Lucida Console', 'simple-vote');?></option>
                            <option class="alert_font_family" id="alert-font-family" name="alert_font_family" value="Times New Roman" selected><?php esc_html_e('Times New Roman', 'simple-vote');?></option>
                        <?php
                        } 
                        ?>
                    </select>
                </div>
                <div class="sv_views">
                    <label><?php esc_html_e('Alert Font Style:', 'simple-vote');?></label>
                    <span class="sv_radio">
                        <?php if( get_option('alert_font_style')=='normal'){?>
                            <input type="radio" class="alert_font_style" id="alert-font-style" name="alert_font_style" value="normal" checked><?php esc_html_e('Normal', 'simple-vote');?></input>
                            <input type="radio" class="alert_font_style" id="alert-font-style" name="alert_font_style" value="italic"><?php esc_html_e('Italic', 'simple-vote');?></input>
                            <input type="radio" class="alert_font_style" id="alert-font-style" name="alert_font_style" value="oblique"><?php esc_html_e('Oblique', 'simple-vote');?></input>
                        <?php }else if( get_option('alert_font_style')=='italic'){?>
                            <input type="radio" class="alert_font_style" id="alert-font-style" name="alert_font_style" value="normal" ><?php esc_html_e('Normal', 'simple-vote');?></input>
                            <input type="radio" class="alert_font_style" id="alert-font-style" name="alert_font_style" value="italic" checked><?php esc_html_e('Italic', 'simple-vote');?></input>
                            <input type="radio" class="alert_font_style" id="alert-font-style" name="alert_font_style" value="oblique"><?php esc_html_e('Oblique', 'simple-vote');?></input>
                        <?php }else if( get_option('alert_font_style')=='oblique'){?>
                            <input type="radio" class="alert_font_style" id="alert-font-style" name="alert_font_style" value="normal" ><?php esc_html_e('Normal', 'simple-vote');?></input>
                            <input type="radio" class="alert_font_style" id="alert-font-style" name="alert_font_style" value="italic"><?php esc_html_e('Italic', 'simple-vote');?></input>
                            <input type="radio" class="alert_font_style" id="alert-font-style" name="alert_font_style" value="oblique" checked><?php esc_html_e('Oblique', 'simple-vote');?></input>
                        <?php }?>
                    </span>
                </div>
                <div class="sv_views">
                    <label><?php esc_html_e('Alert Font Bold:', 'simple-vote');?></label>
                    <?php if(! get_option('alert_font_weight')){?>
                        <input type="checkbox" class="alert_font_weight" id="alert-font-weight" name="alert_font_weight" value="Bold">
                    <?php }else{?>
                        <input type="checkbox" class="alert_font_weight" id="alert-font-weight" name="alert_font_weight" value="Bold" checked>
                    <?php }?>
                </div>
                <div class="sv_views">
                    <label><?php esc_html_e('Success Alert Text Color:', 'simple-vote');?></label>
                    <input type="color" class="success_text_color" id="success-text-color" name="success_text_color" value="<?php echo sanitize_option('success_text_color', get_option('success_text_color')); ?>">
                </div>
                <div class="sv_views">
                    <label><?php esc_html_e('Error Alert Text Color:', 'simple-vote');?></label>
                    <input type="color" class="error_text_color" id="error-text-color" name="error_text_color" value="<?php echo sanitize_option('error_text_color', get_option('error_text_color')); ?>">
                </div>
            </div>
	    <?php
    }


    /**
     * This function displays like button settings
     *
     * @since  1.0.0
     * @access public
     * @param {void}
     * @return {void}
     */

    function sv_views_like(){
        ?>
        <button type="button" class="sv_accordion"><?php esc_html_e('Like', 'simple-vote');?></button>
            <div class="sv_panel">
                <div class="sv_views">
                    <label><?php esc_html_e('Like Background Color:', 'simple-vote');?></label>
                    <input type="color" class="like_bg_color" id="like-bg-color" name="like_bg_color" value="<?php echo sanitize_option('like_bg_color', get_option('like_bg_color')); ?>">
                </div>
                <div class="sv_views">
                    <label><?php esc_html_e('Like Color:', 'simple-vote');?></label>
                    <input type="color" class="like_color" id="like-color" name="like_color" value="<?php echo sanitize_option('like_color', get_option('like_color')); ?>">
                </div>
                <div class="sv_views">
                    <label><?php esc_html_e('Like Loader Color:', 'simple-vote');?></label>
                    <input type="color" class="like_loader_color" id="like-loader-color" name="like_loader_color" value="<?php echo sanitize_option('like_loader_color', get_option('like_loader_color')); ?>">
                </div>
                <div class="sv_views">
                    <label><?php esc_html_e('Like Loader Border Color:', 'simple-vote');?></label>
                    <input type="color" class="like_loader_border_color" id="like-loader-border-color" name="like_loader_border_color" value="<?php echo sanitize_option('like_loader_border_color', get_option('like_loader_border_color')); ?>">
                </div>
            </div>
	    <?php
    }

    /**
     * This function displays dislike button settings
     *
     * @since  1.0.0
     * @access public
     * @param {void}
     * @return {void}
     */

    function sv_views_dislike(){
        ?>
        <button type="button" class="sv_accordion"><?php esc_html_e('Dislike', 'simple-vote');?></button>
            <div class="sv_panel">
                <div class="sv_views">
                    <label><?php esc_html_e('Dislike Background Color:', 'simple-vote');?></label>
                    <input type="color" class="dislike_bg_color" id="dislike-bg-color" name="dislike_bg_color" value="<?php echo sanitize_option('dislike_bg_color', get_option('dislike_bg_color')); ?>">
                </div>
                <div class="sv_views">
                    <label><?php esc_html_e('Dislike Color:', 'simple-vote');?></label>
                    <input type="color" class="dislike_color" id="dislike-color" name="dislike_color" value="<?php echo sanitize_option('dislike_color', get_option('dislike_color')); ?>">
                </div>
                <div class="sv_views">
                    <label><?php esc_html_e('Dislike Loader Color:', 'simple-vote');?></label>
                    <input type="color" class="dislike_loader_color" id="dislike-loader-color" name="dislike_loader_color" value="<?php echo sanitize_option('dislike_loader_color', get_option('dislike_loader_color')); ?>">
                </div>
                <div class="sv_views">
                    <label><?php esc_html_e('Dislike Loader Border Color:', 'simple-vote');?></label>
                    <input type="color" class="dislike_loader_border_color" id="dislike-loader-border-color" name="dislike_loader_border_color" value="<?php echo sanitize_option('dislike_loader_border_color', get_option('dislike_loader_border_color')); ?>">
                </div>
            </div>
        <?php
    }
}