<?php

/**
 * This class is responsible for displaying meta box under every post.
 *
 * @link       www.presstigers.com
 * @since      1.0.0
 *
 * @package    Simple_Vote
 * @subpackage Simple_Vote/admin/settings
 * @author     Presstigers <support@presstigers.com>
 */

class simple_vote_add_meta_box_admin{

    /**
     * Function for handling and rendering event meta
     *
     * @since  1.0.0
     * @access public
     * @param {void}
     * @return {void}
     */

    public function __construct(){
        
    }

    /**
     * Meta box setup function.
     *
     * @since  1.0.0
     * @access public
     * @param {void}
     * @return {void}
     */

    function sv_meta_boxes_setup() {
        /* Add meta boxes on the 'add_meta_boxes' hook. */
        add_action( 'add_meta_boxes', array($this, 'sv_add_post_meta_boxes' ));
    }

    /**
     * Create one or more meta boxes to be displayed on the post editor screen.
     *
     * @since  1.0.0
     * @access public
     * @param {void}
     * @return {void}
     */


    function sv_add_post_meta_boxes() {

        $check_boxes_array = sanitize_option("post_titles", get_option("post_titles"));

        add_meta_box(
        'sv-post-class',
        esc_html__( 'Simple Vote Stats', 'simple-vote' ),
        array($this, 'sv_class_meta_box'),
        $check_boxes_array,
        'side',
        'default'
        );
    }

    /**
     * Display the post meta box.
     *
     * @since  1.0.0
     * @access public
     * @param {void}
     * @return {void}
     */
    
    function sv_class_meta_box( $post ) { ?>
        <?php wp_nonce_field( basename( __FILE__ ), 'sv_class_nonce' );
            $post = intval(get_the_ID());

            //getting post meta data of likes and assigning it to likes variable
            $likes = intval(get_post_meta( $post, 'like', true ));

            //checking if likes contain null then assign zero otherwise let it remain unchanges
            $likes = ($likes == "")? 0 : $likes;

            //getting post meta data of dislikes and assigning it to dislikes variable
            $dislikes = intval(get_post_meta( $post, 'dislike', true ));
            $dislikes = ($dislikes == "")? 0 : $dislikes;
            $total = $likes + $dislikes;
            if($total !== 0){
                $likes_percentage = ($likes/$total)*100;
                $dislikes_percentage = ($dislikes/$total)*100;
            }else{
                $likes_percentage=0;
                $dislikes_percentage=0;
            }
        ?>

        <label> <?php esc_html_e('LIKES', 'simple-vote');?> </label>
        <p><?php echo $likes; ?></p>
        <label><?php esc_html_e('DISLIKES', 'simple-vote');?>  </label>
        <p><?php echo $dislikes; ?></p>
        <label> <?php esc_html_e('LIKES PERCENTAGE', 'simple-vote');?> </label>

        <!-- Rounding off to two decimal places !-->
        <p><?php echo number_format((float)$likes_percentage, 2, '.', '')."%"; ?></p>
        <label> <?php esc_html_e('DISLIKES PERCENTAGE', 'simple-vote');?></label>

        <!-- Rounding off to two decimal places !-->
        <p><?php echo number_format((float)$dislikes_percentage, 2, '.', '')."%"; ?></p>

    <?php 
    }
}