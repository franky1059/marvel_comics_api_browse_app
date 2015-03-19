jQuery(document).ready(function() {           

            jQuery('.paginator_ajax_item').live('click', function () {
                jQuery('#comics_by_character_area').empty();
                ajax_url = $(this).attr('ajax_url');
                
                jQuery.ajax({
                    type: 'GET',
                    url: ajax_url,
                    success: function (results) {
                        if (!!results) {
                          jQuery('#comics_by_character_area').html(results);
                        } else {
                          //console.log('error');
                        }
                    }
                });                

           });

        });