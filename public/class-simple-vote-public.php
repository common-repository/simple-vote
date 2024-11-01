<?php

/**
 * The public-facing functionality of the plugin.
 * 
 * @link       www.presstigers.com
 * @since      1.0.0
 * 
 * @package    Simple_Vote
 * @subpackage Simple_Vote/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Simple_Vote
 * @subpackage Simple_Vote/public
 * @author     Presstigers <support@presstigers.com>
 */
class Simple_Vote_Public {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */

    /**
     * This is the constructor of
     *
     * @since  1.0.0
     * @access public
     * @param {void}
     * @return {void}
     */
    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {

        wp_enqueue_style('simple-vote-icons', plugin_dir_url(__FILE__) . 'css/simple-vote-font-awesome.css', array(), '4.7.0', 'all');
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/simple-vote-public.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0 
     */
    public function enqueue_scripts() {

        wp_register_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/simple-vote-public.js', array('jquery'), $this->version, false);
        wp_localize_script($this->plugin_name, 'the_ajax_script', array('ajaxurl' => admin_url('admin-ajax.php')));
    }

    /**
     * This function displays like and dislike buttons under posts.
     *
     * @since  1.0.0
     * @access public
     * @param {void}
     * @return {void}
     */
    function sv_display_voting_section($content) {

        $vote_content = "";

        wp_enqueue_script($this->plugin_name);

        //getting current post ID
        $post_id = intval(get_the_ID());

        //declaring global variable
        global $post;

        //getting post meta data of likes and assigning it to likes variable
        $likes = intval(get_post_meta($post_id, 'like', true));

        //checking if likes contain null then assign zero otherwise let it remain unchanges
        $likes = ($likes == "") ? 0 : $likes;

        //getting post meta data of dislikes and assigning it to dislikes variable
        $dislikes = intval(get_post_meta($post_id, 'dislike', true));

        //checking if dislikes contain null then assign zero otherwise let it remain unchanges
        $dislikes = ($dislikes == "") ? 0 : $dislikes;

        //getting the current IP
        $ip = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP);

        //getting input fields name array and assigning it to variable
        $check_boxes_array = sanitize_option("post_titles", get_option("post_titles"));

        //checking if array is empty
        if (!empty($check_boxes_array)) {

            //checking if it is post and post type is present in checkbox array
            if ($post && in_array($post->post_type, $check_boxes_array, true)) {
                if (!is_home() && !is_front_page()) {

                    //Generating HTML
                    $vote_content = '<div class=sv-page>';
                    if (get_option('section_padding')) {
                        if (get_option('section_alignment') == "left") {
                            $vote_content .='		<section class="sv-section" style=" margin-right:auto !important ;">';
                        } else if (get_option('section_alignment') == "right") {
                            $vote_content .='		<section class="sv-section" style=" margin-left:auto !important ;">';
                        } else if (get_option('section_alignment') == "center") {
                            $vote_content .='		<section class="sv-section" style=" margin:auto !important ;">';
                        }
                    } else {
                        if (get_option('section_alignment') == "left") {
                            $vote_content .='		<section class="sv-section" style="  margin-right:auto !important ;">';
                        } else if (get_option('section_alignment') == "right") {
                            $vote_content .='		<section class="sv-section" style="  margin-left:auto !important ;">';
                        } else if (get_option('section_alignment') == "center") {
                            $vote_content .='		<section class="sv-section" style="  margin:auto !important ;">';
                        }
                    }

                    $vote_content .='		<div class="sv-wrapper" style="background-color:' . sanitize_option('section_bg_color', get_option('section_bg_color')) . ';" data-pid="' . $post_id . '";>';
                    $vote_content .='			<div class="sv-like" style="background-color: ' . sanitize_option('like_bg_color', get_option('like_bg_color')) . ' ">';
                    $vote_content .='				<i class="fa fa-thumbs-up" style="color:' . sanitize_option('like_color', get_option('like_color')) . ';" id="sv-like"></i>';
                    $vote_content .='				<div class="sv-like-loader" style="display:none; border-color:' . sanitize_option('like_loader_border_color', get_option('like_loader_border_color')) . ' ;border-top-color:' . sanitize_option('like_loader_color', get_option('like_loader_color')) . ';" id="sv-like-loader"></div>';
                    $vote_content .='			</div>';
                    $vote_content .='			<div class="sv-count-numbers" style="color:' . sanitize_option('text_color', get_option('text_color')) . '!important;">';
                    $vote_content .='				<span id="sv-num-like">' . $likes . '</span>';
                    $vote_content .='				<span id="print-mean" class="sv-mean">-</span>';
                    $vote_content .='				<span id="sv-num-dislike">' . $dislikes . '</span>';
                    $vote_content .='			</div>';
                    $vote_content .='			<div class="sv-dislike" style="background-color: ' . sanitize_option('dislike_bg_color', get_option('dislike_bg_color')) . ' ">';
                    $vote_content .='				<i class="fa fa-thumbs-down" style="color:' . sanitize_option('dislike_color', get_option('dislike_color')) . ';" aria-hidden="true" id="sv-dislike"></i>';
                    $vote_content .='				<div class="sv-dislike-loader" style="display:none; border-color:' . sanitize_option('dislike_loader_border_color', get_option('dislike_loader_border_color')) . ' ; border-top-color:' . sanitize_option('dislike_loader_color', get_option('dislike_loader_color')) . ';" id="sv-dislike-loader"></div>';
                    $vote_content .='			</div>';
                    $vote_content .='			<input type="hidden" id="ip-add" name="ip-add" value="' . $ip . '">';
                    $vote_content .='		</div>';
                    $vote_content .='	</section> ';
                    $vote_content .='		<div>';

                    if (get_option('alert_font_family') == 'Default') {
                        $vote_content .='			<p class="sv-success-message" style="text-align:' . sanitize_option('section_alignment', get_option('section_alignment')) . '; color:' . sanitize_option('success_text_color', get_option('success_text_color')) . '!important;  font-style:' . sanitize_option('alert_font_style', get_option('alert_font_style')) . '!important; font-weight:' . sanitize_option('alert_font_weight', get_option('alert_font_weight')) . '!important;">' . esc_html__('Thank You For Your Vote!', 'simple-vote') . '</p>';
                        $vote_content .='			<p class="sv-error-message" style="text-align:' . sanitize_option('section_alignment', get_option('section_alignment')) . '; color:' . sanitize_option('error_text_color', get_option('error_text_color')) . '!important;  font-style:' . sanitize_option('alert_font_style', get_option('alert_font_style')) . '!important; font-weight:' . sanitize_option('alert_font_weight', get_option('alert_font_weight')) . '!important; ">' . esc_html__('Sorry You have Already Voted!', 'simple-vote') . '</p>';
                    } else {
                        $vote_content .='			<p class="sv-success-message" style="text-align:' . sanitize_option('section_alignment', get_option('section_alignment')) . '; color:' . sanitize_option('success_text_color', get_option('success_text_color')) . '!important; font-family: ' . sanitize_option('alert_font_family', get_option('alert_font_family')) . '!important; font-style:' . sanitize_option('alert_font_style', get_option('alert_font_style')) . '!important; font-weight:' . sanitize_option('alert_font_weight', get_option('alert_font_weight')) . '!important;">' . esc_html__('Thank You For Your Vote!', 'simple-vote') . '</p>';
                        $vote_content .='			<p class="sv-error-message" style="text-align:' . sanitize_option('section_alignment', get_option('section_alignment')) . '; color:' . sanitize_option('error_text_color', get_option('error_text_color')) . '!important; font-family: ' . sanitize_option('alert_font_family', get_option('alert_font_family')) . '!important; font-style:' . sanitize_option('alert_font_style', get_option('alert_font_style')) . '!important; font-weight:' . sanitize_option('alert_font_weight', get_option('alert_font_weight')) . '!important; ">' . esc_html__('Sorry You have Already Voted!', 'simple-vote') . '</p>';
                    }
                    $vote_content .='		</div>';
                    $vote_content .='</div>';
                } else {
                    $vote_content = "";
                }
            }
        }
        //appending new vote content to original post content
        return $content . $vote_content;
    }

    /**
     * This function displays vote count, along with fetching from post meta and updating number of likes and dislikes.
     *
     * @since  1.0.0
     * @access public
     * @param {void}
     * @return {void}
     */
    public function sv_manage_votes() {

        //Requesting Post ID
        $pid = intval($_REQUEST['pid']);

        //Requesting action i.e. which button like or dislike is clicked by user
        $vote_action = sanitize_text_field($_REQUEST['vote_action']);

        //Requesting IP address of user to check if user has voted already or not
        $ip_check = filter_var($_REQUEST['user_ip'], FILTER_VALIDATE_IP);

        //Checking if array is serialized or not, if serialized then unserialize it
        $db_ip_array = maybe_unserialize(get_post_meta($pid, 'userips', true));

        //checking if array is empty or not
        if (is_array($db_ip_array) && isset($db_ip_array)) {

            //if ip address array from database is set and is array then assign it to old ip array
            $old_ip_array = $db_ip_array;
        } else {
            //if empty initialize randomly
            $old_ip_array = array();
        }

        //if user clicked like button
        if ($vote_action == "like") {
            if (!in_array($ip_check, $old_ip_array)) {

                //getting post meta of likes
                $likes = intval(get_post_meta($pid, 'like', true));

                //incrementing likes
                $likes++;

                //updating post meta data
                update_post_meta($pid, 'like', $likes);

                //pushing IP address in array
                array_push($old_ip_array, $ip_check);

                //serializing array if not already
                $old_ip_array = maybe_serialize($old_ip_array);

                //updating user IP post meta
                update_post_meta($pid, 'userips', $old_ip_array);

                //sending back AJAX response
                echo json_encode(array("likes" => $likes, "message" => TRUE));
            } else {

                //getting post meta of likes
                $likes = intval(get_post_meta($pid, 'like', true));

                //updating post meta data of likes
                update_post_meta($pid, 'like', $likes);

                //checking if array of IPs is empty or not
                if (is_array($old_ip_array) && empty($old_ip_array)) {

                    //initializing new array
                    $new_ip_array = array();

                    //pushing IP address in new array
                    array_push($new_ip_array, $ip_check);

                    //serializing new array and assiging it to old array
                    $old_ip_array = maybe_serialize($new_ip_array);

                    //adding post meta
                    add_post_meta($pid, 'userips', $old_ip_array);
                }

                //sending back AJAX response
                echo json_encode(array("likes" => $likes, "message" => FALSE));
            }

            //if user clicked dislike button
        } else if ($vote_action == "dislike") {
            if (!in_array($ip_check, $old_ip_array)) {

                //getting post meta of dislikes
                $dislikes = intval(get_post_meta($pid, 'dislike', true));

                //incrementing dislikes
                $dislikes++;

                //updating post meta data
                update_post_meta($pid, 'dislike', $dislikes);

                //pushing IP address in array
                array_push($old_ip_array, $ip_check);

                //serializing array if not already	
                $old_ip_array = maybe_serialize($old_ip_array);

                //updating user IP post meta
                update_post_meta($pid, 'userips', $old_ip_array);

                //sending back AJAX response
                echo json_encode(array("dislikes" => $dislikes, "message" => TRUE));
            } else {

                //getting post meta of dislikes
                $dislikes = intval(get_post_meta($pid, 'dislike', true));

                //updating post meta data
                update_post_meta($pid, 'dislike', $dislikes);

                //checking if array of IPs is empty or not
                if (is_array($old_ip_array) && empty($old_ip_array)) {

                    //initializing new array
                    $new_ip_array = array();

                    //pushing IP address in new array
                    array_push($new_ip_array, $ip_check);

                    //serializing new array and assiging it to old array
                    $old_ip_array = maybe_serialize($new_ip_array);

                    //adding post meta
                    add_post_meta($pid, 'userips', $old_ip_array);
                }

                //sending back AJAX response
                echo json_encode(array("dislikes" => $dislikes, "message" => FALSE));
            }
        }
        exit();
    }
}