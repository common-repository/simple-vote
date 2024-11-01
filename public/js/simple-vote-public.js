var simple_vote_app = {
    /**
     * declaring functions
     */

    init: function(){
        simple_vote_app.like();
        simple_vote_app.dislike();
    },

    /**
     * like function along with ajax call
     */

    like: function(){
        jQuery('.sv-like').on('click', function (){
            var post_id = jQuery('.sv-wrapper').data('pid');
            var ip_add = jQuery('#ip-add').val();
            jQuery.ajax({
                type: 'POST',
                url: the_ajax_script.ajaxurl,
                data: {"action": "sv_manage_votes", "pid": post_id, "vote_action": "like", "user_ip": ip_add },
                
                beforeSend: function(){
                    jQuery("#sv-like").hide();
                    jQuery("#sv-like-loader").show();
                },

                success: function(data){
                    var data_array = jQuery.parseJSON(data);
                    jQuery('#sv-num-like').text(data_array.likes);
                    if(data_array.message==true){
                        jQuery(".sv-success-message").show();
                        jQuery(".sv-success-message").fadeOut(10000);
                    }else{
                        jQuery(".sv-error-message").show();
                        jQuery(".sv-error-message").fadeOut(10000);
                    }
                },

                complete:function(){
                    jQuery("#sv-like-loader").hide();
                    jQuery("#sv-like").show();
                }

            });
            return false;
        });
    },

    /**
     * dislike function along with ajax call
     */

    dislike: function(){
        jQuery('.sv-dislike').on('click', function (){
            var post_id = jQuery('.sv-wrapper').data('pid');
            var ip_add = jQuery('#ip-add').val();
            jQuery.ajax({
                type: 'POST',
                url: the_ajax_script.ajaxurl,
                data: {"action": "sv_manage_votes", "pid": post_id, "vote_action": "dislike", "user_ip": ip_add  },

                beforeSend: function(){
                    jQuery("#sv-dislike").hide();
                    jQuery("#sv-dislike-loader").show();
                },

                success: function(data){
                    var data_array = jQuery.parseJSON(data);
                    jQuery('#sv-num-dislike').text(data_array.dislikes);
                    if(data_array.message==true){
                        jQuery(".sv-success-message").show();
                        jQuery(".sv-success-message").fadeOut(10000);
                    }else{
                        jQuery(".sv-error-message").show();
                        jQuery(".sv-error-message").fadeOut(10000);
                    }
                },

                complete: function(){
                    jQuery("#sv-dislike-loader").hide();
                    jQuery("#sv-dislike").show();
                }

            });
            return false;
        });
    },
};

(function() {

    jQuery(function() {
        simple_vote_app.init();
    });

})( jQuery );