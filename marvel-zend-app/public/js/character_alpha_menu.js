jQuery(document).ready(function() {           

            jQuery('.alpha_menu_item').click(function () {
                jQuery('#results_area').empty();
                selected_letter = $(this).attr('char_letter');

                ajax_url = $(this).attr('ajax_url');
                marvel_comics_by_character_url = $(this).attr('marvel_comics_by_character_url');
                //console.log(ajax_url);                

                
                jQuery.ajax({
                    type: 'POST',
                    url: ajax_url,
                    data: 'ajax_method=ajax_browse_characters_with_starting_letter&data={"starting_letter":"'+selected_letter+'"}',
                    success: function (results) {
                        if (!!results) {
                          //console.log(results);
                          results_obj = jQuery.parseJSON(results);
                          jQuery.each(results_obj.data.results, function(i,item){
                            //console.log(item);
                            new_link = jQuery("<a/>");
                            new_link.attr("href", marvel_comics_by_character_url+'/'+item.id+'/page/1');
                            new_link.html(item.title);
                            new_link.appendTo("#results_area");
                            jQuery("<br/>").appendTo("#results_area");
                          });
                        } else {
                          //console.log('error');
                        }
                    }
                });                

           });

        });