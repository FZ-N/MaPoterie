    var fm_currentDate = new Date();
    var FormCurrency_3 = '$';
    var FormPaypalTax_3 = '0';
    var check_submit3 = 0;
    var check_before_submit3 = {};
    var required_fields3 = [];
    var labels_and_ids3 = {"2":"type_text","3":"type_text","4":"type_textarea","1":"type_submit_reset"};
    var check_regExp_all3 = [];
    var check_paypal_price_min_max3 = [];
    var file_upload_check3 = [];
    var spinner_check3 = [];
    var scrollbox_trigger_point3 = '20';
    var header_image_animation3 = 'none';
    var scrollbox_loading_delay3 = '0';
    var scrollbox_auto_hide3 = '1';
    var inputIds3 = '[]';
	var form_view_count3 = 0;
     function before_load3() {	
}	
 function before_submit3() {
	 }	
 function before_reset3() {	
}
 function after_submit3() {
  
}
    function onload_js3() {    }

    function condition_js3() {    }

    function check_js3(id, form_id) {
		if (id != 0) {
			x = jQuery("#" + form_id + "form_view"+id);
		}
		else {
		x = jQuery("#form"+form_id);
		}
		    }

    function onsubmit_js3() {
		
    var disabled_fields = "";
    jQuery("#form3 div[wdid]").each(function() {
      if(jQuery(this).css("display") == "none") {
        disabled_fields += jQuery(this).attr("wdid");
        disabled_fields += ",";
      }
    })
    if(disabled_fields) {
      jQuery("<input type=\"hidden\" name=\"disabled_fields3\" value =\""+disabled_fields+"\" />").appendTo("#form3");
    };    }

	function unset_fields3( values, id, i ) {
		rid = 0;
		if ( i > 0 ) {
			jQuery.each( values, function( k, v ) {
				if ( id == k.split('|')[2] ) {
					rid = k.split('|')[0];
					values[k] = '';
				}
			});
			return unset_fields3(values, rid, i - 1);
		} else {
			return values;
		}
	}
	function ajax_similarity3( obj, changing_field_id ) {
		jQuery.ajax({
			type: "POST",
			url: 'http://localhost/mp/wp-admin/admin-ajax.php?action=fm_reload_input&page=form_maker&nonce=62b8be3c54',
			dataType: "json",
			data: {
				form_id: 3,
				inputs: obj.inputs
			},
			beforeSend: function() {
				if ( !jQuery.isEmptyObject(obj.inputs) ) {
					jQuery.each( obj.inputs, function( key, val ) {
						wdid = key.split('|')[0];
						if ( val != '' && parseInt(wdid) == parseInt(changing_field_id) ) {
							jQuery("#form3 div[wdid='"+ wdid +"']").append( '<div class="fm-loading"></div>' );
						}
					});
				}
			},
			success: function (res) {
				if ( !jQuery.isEmptyObject(obj.inputs) ) {
					jQuery.each( obj.inputs, function( key, val ) {
						wdid = key.split('|')[0];
						jQuery("#form3 div[wdid='"+ wdid +"'] .fm-loading").remove();
						if ( !jQuery.isEmptyObject(res[wdid]) && ( !val || parseInt(wdid) == parseInt(changing_field_id) ) ) {
							jQuery("#form3 div[wdid='"+ wdid +"']").html( res[wdid].html );
						}
					});
				}
			},
			complete: function() {
			}
		});
	}

    jQuery(document).ready(function () {
		if (jQuery('#form3 .wdform_section').length > 0) {
			fm_document_ready(3);
		}
		else {
			jQuery("#form3").closest(".fm-form-container").removeAttr("style")
		}
		if (jQuery('#form3 .wdform_section').length > 0) {
			formOnload(3);
		}

		var ajaxObj3 = {};
		var value_ids3 = {};

		jQuery.each( jQuery.parseJSON( inputIds3 ), function( key, values ) {
			jQuery.each( values, function( index, input_id ) {
				tagName =  jQuery('#form3 [id^="wdform_'+ input_id +'_elemen"]').prop("tagName");
				type =  jQuery('#form3 [id^="wdform_'+ input_id +'_elemen"]').prop("type");
				if ( tagName == 'INPUT' ) {
					input_value = jQuery('#form3 [id^="wdform_'+ input_id +'_elemen"]').val();
					if ( jQuery('#form3 [id^="wdform_'+ input_id +'_elemen"]').is(':checked') ) { 
						if ( input_value ) {
							value_ids3[key + '|' + input_id] = input_value;
						}
					}
					else if ( type == 'text' ) {
						if ( input_value ) {
							value_ids3[key + '|' + input_id] = input_value;
						}
					}
				}
				else if ( tagName == 'SELECT' ) {
					select_value = jQuery('#form3 [id^="wdform_'+ input_id +'_elemen"] option:selected').val();
					if ( select_value ) {
						value_ids3[key + '|' + input_id] = select_value;
					}
				}
				ajaxObj3.inputs = value_ids3;

				jQuery(document).on('change', '#form3 [id^="wdform_'+ input_id +'_elemen"]', function() {
					var id = '';
					var changing_field_id = '';
					if( jQuery(this).prop("tagName") == 'INPUT' ) {
						if( jQuery(this).is(':checked') ) {
							id = jQuery(this).val();
						}
						if( jQuery(this).attr('type') == 'text' ) {
							id = jQuery(this).val();
						}
					}
					else {
						id = jQuery(this).val();
					}
					value_ids3[key + '|' + input_id] = id;

					jQuery.each( value_ids3, function( k, v ) {
						key_arr = k.split('|');
						if ( input_id == key_arr[2] ) {
							changing_field_id = key_arr[0];
							count = Object.keys(value_ids3).length;
							value_ids3 = unset_fields3( value_ids3, changing_field_id, count );
						}
					});

					ajaxObj3.inputs = value_ids3;
					ajax_similarity3( ajaxObj3, changing_field_id );
				});
			});
		});
		ajax_similarity3( ajaxObj3, null );
    });
    