jQuery(document).ready(function($){

    /*
     * Bind click event for custom field 1
     * that set image url into a textfield
     */
    $('#upload_image_button_one').on("click", function() {
        formfield = $("#upload_initial").attr('name');

        tb_show( '', 'media-upload.php?type=file&amp;TB_iframe=true' );
        
        //store old send to editor function
        window.restore_send_to_editor = window.send_to_editor;
        
        // Display the Image link in TEXT Field
        window.send_to_editor = function(html) { 
            fileurl = $(html).attr('href');  

  
                 $('#upload_initial').val(fileurl);
           
            
            tb_remove(); 
            window.send_to_editor = window.restore_send_to_editor;
        } 
        
        return false;
    });



    /*
     * Bind click event for custom field 2
     * that set image url into a textfield
     */
    $('#upload_image_button_two').on("click", function() {
        formfield = $("#upload_invoice").attr('name');

        tb_show( '', 'media-upload.php?type=file&amp;TB_iframe=true' );
        
        //store old send to editor function
        window.restore_send_to_editor = window.send_to_editor;
        
        // Display the Image link in TEXT Field
        window.send_to_editor = function(html) { 
            fileurl = $(html).attr('href');  

  
                 $('#upload_invoice').val(fileurl);
           
            
            tb_remove(); 
            window.send_to_editor = window.restore_send_to_editor;
        } 
        
        return false;
    });

    /*
     * Bind click event for custom field 3
     * that set pdf url into a textfield
     */
    $('#upload_image_button_three').on("click", function() {
        formfield = $("#upload_discharge").attr('name');

        tb_show( '', 'media-upload.php?type=file&amp;TB_iframe=true' );
        
        //store old send to editor function
        window.restore_send_to_editor = window.send_to_editor;
        
        // Display the Image link in TEXT Field
        window.send_to_editor = function(html) { 
            fileurl = $(html).attr('href');  


                  $('#upload_discharge').val(fileurl);
       

            tb_remove(); 
            window.send_to_editor = window.restore_send_to_editor;
        } 
        
        return false;
    });
});

    /*
     * Auto populates the file url field which is blank in wordpress 4.5+ 
     * This is display none in img-stylesheet.css to avoid conflict
     */

jQuery('.savesend input[type=submit]').click(function(){  
         var url = jQuery(this).parents('.describe').find('.urlfile').data('link-url');
         var field = jQuery(this).parents('.describe').find('.urlfield');
         field.val(url);
     });

