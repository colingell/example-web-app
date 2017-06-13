jQuery(document).ready(function() {


 
 jQuery('#upload_image_button_one').click(function() {
 jQuery('html').addClass('Image');
 formfield = jQuery('#upload_initial').attr('name');
 tb_show('Upload File', 'media-upload.php?type=file&amp;TB_iframe=true');

 return false;
});
        window.original_send_to_editor = window.send_to_editor;
        window.send_to_editor = function(html) {
        initial_url = $(html).attr('href');
        tb_remove();
        jQuery('#upload_initial').val(initial_url);
}




 jQuery('#upload_image_button_two').click(function() {
 formfield = jQuery('#upload_invoice').attr('name');
 tb_show('Upload File', 'media-upload.php?type=file&amp;TB_iframe=true');
 return false;
});

        window.original_send_to_editor = window.send_to_editor; 
        window.send_to_editor = function(html) {
        invoice_url = jQuery('img',html).attr('src');
        jQuery('#upload_invoice').val(invoice_url);
        tb_remove();
}


 jQuery('#upload_image_button_three').click(function() {
 formfield = jQuery('#upload_discharge').attr('name');
 tb_show('Upload File', 'media-upload.php?type=file&amp;TB_iframe=true');
 return false;
});
         window.original_send_to_editor = window.send_to_editor;
         window.send_to_editor = function(html) {
         discharge_url = jQuery('img',html).attr('src');
         jQuery('#upload_discharge').val(discharge_url);
         tb_remove();
}


 
});