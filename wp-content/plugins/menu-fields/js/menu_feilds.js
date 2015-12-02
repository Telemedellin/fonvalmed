jQuery(document).ready(function($){
 
    var custom_uploader;
    var input_id;
 
    $('.upload_image_button').live('click', function(e) {
 
        e.preventDefault();
        
        input_id = $(this).attr('field_attr');
 
        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }
 
        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });
 
        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
            attachment = custom_uploader.state().get('selection').first().toJSON();
            $('#ad_image_'+input_id).val(attachment.id);
             
            var data = {
                    action: 'menu_fields_image',
                    image_id: attachment.id
            };
    
            // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
            $.post(ajaxurl, data, function(image_url) {
                    $('#ad_image_tag_'+input_id).attr("src", image_url);
            });
             
        });
        custom_uploader.open();
    });    
    
    $('.remove_image_button').click(function(e) {
        input_id = $(this).attr('field_attr');
        default_img = $(this).attr('field_attr_img');
        $('#ad_image_'+input_id).val('');
        $('#ad_image_tag_'+input_id).attr("src", default_img);
        return false;
    });    

    $(".checkbox-input").find("input[type='checkbox']").change(function() {
        var locationId = $(this).attr('id');
        if ( $(this).prop("checked") ) {
          $( '.field-custom.'+locationId ).show();
        }else{          

            $( '.field-custom.'+locationId ).each(function( index ) {
                var hideFlag = true;
                var classList = $( this ).attr('class').split(/\s+/);                
                $.each( classList, function(index, item){
                    if ( $( '#' + item ).prop("checked") ) {
                       hideFlag = false;
                    }                
                });
                if (hideFlag) {
                    $( this ).hide();
                }
            });
 
        }
    });    
});

