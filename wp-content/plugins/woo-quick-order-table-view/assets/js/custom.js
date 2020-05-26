// JavaScript Document
jQuery(function ($) { 
    if ($("#example").length > 0){
    $('#example').DataTable();
    }
    
    $('.single_add_to_cart_button').click(function(event){
        
        event.preventDefault();
            var ids = [];
            var values = [];

            row = $(this).closest("tr");
            ids.push($(this).val());
            values.push({ 
                checkbox_id : $(row).find("input[name=product_id]").val() ,
                quantity  : $(row).find("input[name=quantity]").val()      
            });
            
            var ids_string = ids.toString();  // array to string conversion 
            var valuesJson = JSON.stringify(values);
            console.log(valuesJson);
            $.ajax({
                type : 'post',
                url : postlove.ajax_url,
                data : {
                    action : 'cartajax',
                    data_ids:valuesJson,
                    dataType: 'json'
                },
                success: function(response) {
                    if( response.error != 'undefined' && response.error ){
                    return false;
                  } else {
                    
                    $(row).find('.checkout-button').css("display","block");
                    $(row).find('.single_add_to_cart_button').css("display","none");
                  }
                },
                async:false
            });
    }); 
} );
