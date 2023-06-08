jQuery(document).ready((e=>{function t(){if(e(".taxonomy-locations").length>0){var t=e("#tag-name").val(),o=e("#postal_code").val(),i=e("#country").val();""!=o&&""!=i&&""!=t&&null!=t?(e("#submit").removeAttr("disabled"),e(".alert-text").hide()):(e("#submit").attr("disabled",!0),e(".alert-text").text("Please fill all mandatory fields.").show())}}let o;"on"==locationWidget.keys&&function(){function t(){var t=[];e.each(e("input[name='tax_input[locations][]']:not(:checked)"),(function(){t.push(e(this).val())}));for(let o=0;o<t.length;o++)e("#locationID_"+t[o]).hide(),e(".locationID_"+t[o]).hide()}t(),jQuery("body").on("click",".woocommerce_variation",(function(){t()})),jQuery("#taxonomy-locations").on("click",".selectit",(function(){var t=jQuery(this).children("input").val(),o=jQuery(this).children("input").prop("checked");$_value=e("#wcmlim_draft_stock_at_"+t).val(),!0===o&&(e("#locationID_"+t).children("p").children("input").val($_value),e("#locationID_"+t).show(),e(".locationID_"+t).children("p").children("input").val($_value),e(".locationID_"+t).show()),!1===o&&(e("#locationID_"+t).children("p").children("input").val(""),e("#locationID_"+t).hide(),e(".locationID_"+t).children("p").children("input").val(""),e(".locationID_"+t).hide())}))}(),t(),jQuery("#postal_code, #tag-name,  #country").on("input",(function(e){t()})),jQuery("#lcpriority").on("keyup",(function(){var t=jQuery("#lcpriority").val(),o=window.location.href,i=(o=new URL(o)).searchParams.get("tag_ID");""!=t&&e.ajax({url:multi_inventory.ajaxurl,type:"POST",dataType:"json",data:{action:"wcmlim_get_lcpriority",lcpriority:t,skip_location:i},success(e){1==e&&(alertify.set("notifier","position","bottom-right"),alertify.error("This priority has been already asigned to other location"),jQuery("#lcpriority").val(""))}})}));const i={street_number:"short_name",route:"long_name",locality:"long_name",administrative_area_level_1:"long_name",country:"long_name",postal_code:"short_name"},a=document.getElementById("wcmlim_autocomplete_address");if(a){function r(){const a=o.getPlace();if(a.geometry){for(const e in i)document.getElementById(e).value="",document.getElementById(e).disabled=!1;for(let e=0;e<a.address_components.length;e++){const t=a.address_components[e].types[0];if(i[t]){const o=a.address_components[e][i[t]];document.getElementById(t).value=o}}var r=e("#wcmlim_autocomplete_address").val();e.ajax({url:multi_inventory.ajaxurl,type:"POST",dataType:"json",data:{action:"wcmlim_get_lat_lng",wcmlim_autocomplete_address:r,security:multi_inventory.check_nonce},success(t){var o=JSON.parse(JSON.stringify(t));let i=o.latitude,a=o.longitude;e("#wcmlim_lat").length&&e("#wcmlim_lat").length&&(e("#wcmlim_lat").val(i),e("#wcmlim_lng").val(a))}}),t()}else window.alert("Autocomplete's returned place contains no geometry")}a.addEventListener("focus",(e=>{o=new google.maps.places.Autocomplete(document.getElementById("wcmlim_autocomplete_address"),{}),o.addListener("place_changed",r)}))}-1!=e(".locationsParent").val()?e(".term-address-wrap, .term-streetNumber-wrap, .term-route-wrap, .term-city-wrap, .term-state-wrap, .term-postcode-wrap, .term-country-wrap, .term-email-wrap, .term-shippingZone-wrap, .term-shopManager-wrap, .term-paymentMethods-wrap, .term-pos-wrap, .term-shippingMethod-wrap").hide():e(".term-address-wrap, .term-streetNumber-wrap, .term-route-wrap, .term-city-wrap, .term-state-wrap, .term-postcode-wrap, .term-country-wrap, .term-email-wrap, .term-shippingZone-wrap, .term-shopManager-wrap, .term-paymentMethods-wrap, .term-pos-wrap, .term-shippingMethod-wrap").show(),e(".locationsParent").on("change",(function(t){-1!=this.value?e(".term-address-wrap, .term-streetNumber-wrap, .term-route-wrap, .term-city-wrap, .term-state-wrap, .term-postcode-wrap, .term-country-wrap, .term-email-wrap, .term-shopManager-wrap, .term-paymentMethods-wrap, .term-pos-wrap, .term-shippingMethod-wrap").hide():e(".term-address-wrap, .term-streetNumber-wrap, .term-route-wrap, .term-city-wrap, .term-state-wrap, .term-postcode-wrap, .term-country-wrap, .term-email-wrap, .term-shopManager-wrap, .term-paymentMethods-wrap, .term-pos-wrap, .term-shippingMethod-wrap").show()}));e("#locationList");if(e("#_manage_stock").change((function(){e(".wc_input_stock").prop("disabled",!0),this.checked?e("#inventory_product_data > #locationList").show():e("#inventory_product_data > #locationList").hide()})),e("#_manage_stock").prop("checked")){e("#locationList").show(),e("#inventory_product_data > #locationList").show(),e(".wc_input_stock").prop("disabled",!0);const n=e("#locationList > .locationInner > p > input[type='number']");let s=0;n.each(((e,t)=>{s+=parseInt(t.value||0)}));const m=parseInt(e(".wc_input_stock").val());s!=m&&e("._stock_field").append("<p style='color:red;'>The total stock doesn't match the sum of the locations stock. Please update location stock.</p>")}else{"simple"==e("#product-type :selected").val()&&(e("#locationList").hide(),e("#inventory_product_data > #locationList").hide(),e("._manage_stock_field").append("<p style='color:red;'>To be able to manage stocks in Locations, please activate the <b>Stock Management</b> option.</p>"))}e("#woocommerce-product-data").on("woocommerce_variations_loaded",(()=>{e(".woocommerce_variation").each(((t,o)=>{const i=e(`input[name$="variable_manage_stock[${t}]"]`);0==i.prop("checked")&&i.closest("p.options").append("<p style='color:red;'>To be able to manage stocks in Locations, please activate the <b>Stock Management</b> option.</p>")}));const t=e("input.variable_manage_stock");t.each(((o,i)=>{if(i.checked)for(let o=0;o<t.length;o++)e(`input#variable_stock${o}`).prop("disabled",!0)}))})),e("#wcmlim_shipping_zone,#wcmlim_payment_methods,#wcmlim_shipping_method,#wcmlim_tax_locations").chosen({width:"95%"}),e("#wcmlim_shop_manager").chosen({width:"95%"}),e("#wcmlim_shop_regmanager").chosen({width:"95%",max_selected_options:1});var l=passedData.keys;e("#wcmlim_exclude_locations_from_frontend").chosen({max_selected_options:l,width:"30%"}),e("#wcmlim_exclude_locations_from_frontend").bind("chosen:maxselected",(function(){jQuery(".exclude_prod_onfront").html('<p class="exclude_prod_onfront1"> You can\'t add all locations to exclude</p>')}));var c=passedData_group.keys;(e("#wcmlim_exclude_locations_group_frontend").chosen({max_selected_options:c,width:"30%"}),e("#wcmlim_exclude_locations_group_frontend").bind("chosen:maxselected",(function(){jQuery(".exclude_prodg_onfront").html('<p class="exclude_prodg_onfront1"> You can\'t add all location groups to exclude</p>')})),e("#wcmlim_exclude_locations_group_frontend").chosen({width:"30%"}),e("#woocommerce-order-items").find("tr.item").each(((e,t)=>{t.classList.add("with-wcmlim")})),e("#wcmlim_shipping_zone").on("change",(()=>{var t=e("#wcmlim_shipping_zone").val();e.ajax({url:multi_inventory.ajaxurl,type:"POST",dataType:"json",data:{action:"populate_shipping_methods",shippingMethods:t,security:multi_inventory.check_nonce},success(t){var o=JSON.parse(JSON.stringify(t));console.log(o),e("#wcmlim_shipping_method").empty(),e.each(o,(function(t,o){e("#wcmlim_shipping_method").append(e("<option></option>").attr("value",o.key).text(o.value))})),e("#wcmlim_shipping_method").trigger("chosen:updated")}})})),e("#woocommerce-order-items").on("aftertablesort",".woocommerce_order_items",((t,o)=>{const i=e(t.currentTarget);i.find("tr.order-item-wcml-panel").each(((t,o)=>{e(o).insertAfter(i.find("tr.item.with-wcmlim").filter(`[data-order_item_id="${e(o).data("order_item_id")}"]`))}))})),e(".keyEye").on("click",(function(t){t.preventDefault(),e(".keyEye i").toggleClass("fa-eye fa-eye-slash"),"text"==e("#wcmlim_google_api_key").attr("type")?e("#wcmlim_google_api_key").attr("type","password"):"password"==e("#wcmlim_google_api_key").attr("type")&&e("#wcmlim_google_api_key").attr("type","text")})),e(".wcmlimvalidateGMAPI").on("click",(function(t){var o=e("#wcmlim_google_api_key").val();if(null!=o&&""!=o){e(".wcmlimvalidateGMAPI").html('<i class="fa fa-cog fa-spin"></i> Connecting'),e.ajax({url:multi_inventory.ajaxurl,type:"POST",data:{action:"distance_matrix_validate_api",api:o},success:function(e){"valid"==(e=(e=e.toString()).trim())?(alertify.set("notifier","position","bottom-right"),alertify.success("Google Map API is valid with Distance Matrix Service")):"You must enable Billing on the Google Cloud Project at https://console.cloud.google.com/project/_/billing/enable Learn more at https://developers.google.com/maps/gmp-get-started"==e?(alertify.set("notifier","position","bottom-right"),alertify.error("You must enable Billing on the Google Cloud Project at https://console.cloud.google.com/project/_/billing/enable Learn more at https://developers.google.com/maps/gmp-get-started")):(alertify.set("notifier","position","bottom-right"),alertify.error("Google Map API is invalid with Distance Matrix Service, Please enable Distance Matrix Service"))}}),e.ajax({url:multi_inventory.ajaxurl,type:"POST",data:{action:"place_validate_api",api:o},success:function(e){"valid"==(e=(e=e.toString()).trim())?(alertify.set("notifier","position","bottom-right"),alertify.set("notifier","delay",8),alertify.success("Google Map API is valid with Place API Service")):"You must enable Billing on the Google Cloud Project at https://console.cloud.google.com/project/_/billing/enable Learn more at https://developers.google.com/maps/gmp-get-started"==e?(alertify.set("notifier","position","bottom-right"),alertify.set("notifier","delay",8),alertify.error("You must enable Billing on the Google Cloud Project at https://console.cloud.google.com/project/_/billing/enable Learn more at https://developers.google.com/maps/gmp-get-started")):(alertify.set("notifier","position","bottom-right"),alertify.set("notifier","delay",8),alertify.error("Google Map API is invalid with Place API Service, Please enable Place API Service"))}}),e.ajax({url:multi_inventory.ajaxurl,type:"POST",data:{action:"geocode_validate_api",api:o},success:function(e){"valid"==(e=(e=e.toString()).trim())?(alertify.set("notifier","position","bottom-right"),alertify.set("notifier","delay",8),alertify.success("Google Map API is valid with Geocode Service")):(alertify.set("notifier","position","bottom-right"),alertify.set("notifier","delay",8),alertify.error("Google Map API is invalid with Geocode Service, Please enable Geocode Service"))}});let t=document.createElement("script");var i="https:"==window.location.protocol?"https:":"http:";t.setAttribute("src",`${i}//maps.googleapis.com/maps/api/js?libraries=geometry&sensor=false&key=${o}&callback`),document.body.appendChild(t),window.console={error:function(){errorText=arguments[0],errorText.includes("Google Maps JavaScript API error")?(alertify.set("notifier","position","bottom-right"),alertify.set("notifier","delay",8),alertify.error("Google Map API is invalid with Map Javascript Service, Please enable Map Javascript Service")):(alertify.set("notifier","position","bottom-right"),alertify.set("notifier","delay",8),alertify.success("Google Map API is valid with Map Javascript Service"))}},e(".wcmlimvalidateGMAPI").html("Validate")}else alertify.set("notifier","position","bottom-right"),alertify.set("notifier","delay",8),alertify.error("Please enter Google API Key and try again"),e(".wcmlimvalidateGMAPI").html("Validate")})),e("#wcmlim_phone_validation").length>0&&e("#wcmlim_phone_validation").on("input",(function(){var t=this.value;t.length>12||t.length<5?(e(".button").prop("disabled",!0),e("#phonevalmsg").show(),e("#phonevalmsg").css("color","red"),e("#phonevalmsg").html('<p style="color: #9c1d1d;margin: 4px 4px;font-weight: 400;text-align: left;"> Invalid Phone number, please enter digit beetween 5-12')):(e(".button").prop("disabled",!1),e("#phonevalmsg").hide())})),e(".locationsParent").length>0)&&("-1"!=e("select.locationsParent").children("option:selected").val()&&(e("#start_time").prop("disabled",!0),e("#end_time").prop("disabled",!0),e("#wcmlim_phone_validation").prop("disabled",!0),e(".term-time-wrap").hide(),e(".term-phone-wrap").hide()),e("select.locationsParent").change((function(){e(".button").prop("disabled",!0),e(".button").html("Fetching Details",!0);var t=e(this).children("option:selected").val();"-1"!=t?e.ajax({url:multi_inventory.ajaxurl,type:"post",data:{action:"show_parent_location_time",loc_id:t},success(t){var o=JSON.parse(t);""!=o.start&&""!=o.end&&(e("#start_time").val(o.start),e("#end_time").val(o.end),e("#wcmlim_phone_validation").val(o.phone)),e("#start_time").prop("disabled",!0),e("#end_time").prop("disabled",!0),e("#wcmlim_phone_validation").prop("disabled",!0),e(".term-time-wrap").hide(),e(".term-phone-wrap").hide(),e(".button").prop("disabled",!1),e(".button").html("Update",!0)}}):(e("#start_time").prop("disabled",!1),e("#end_time").prop("disabled",!1),e("#wcmlim_phone_validation").prop("disabled",!1),e(".term-time-wrap").show(),e(".term-phone-wrap").show(),e(".button").prop("disabled",!1),e(".button").html("Update",!0))})));jQuery("#wcmlim_allow_only_backend").on("change",(function(){jQuery(this).is(":checked")?(switchStatus=jQuery(this).is(":checked"),jQuery("#wcmlim_next_closest_location").prop("checked",!1),jQuery("#wcmlim_hide_out_of_stock_location").prop("checked",!1),jQuery("#wcmlim_clear_cart").prop("checked",!1),jQuery("#wcmlim_enable_userspecific_location").prop("checked",!1),jQuery("#wcmlim_preferred_location").prop("checked",!1),jQuery("#wcmlim_enable_autodetect_location").prop("checked",!1),jQuery("#wcmlim_geo_location").prop("checked",!1),jQuery("#wcmlim_enable_price").prop("checked",!1),jQuery("#wcmlim_hide_show_location_dropdown").prop("checked",!1),jQuery("#wcmlim_enable_location_onshop").prop("checked",!1),jQuery("#wcmlim_enable_location_price_onshop").prop("checked",!1),jQuery("#wcmlim_sort_shop_asper_glocation").prop("checked",!1),jQuery("#wcmlim_use_location_widget").prop("checked",!1),jQuery("#wcmlim_enable_shipping_zones").prop("checked",!1),jQuery("#wcmlim_enable_shipping_methods").prop("checked",!1),jQuery("#wcmlim_assign_payment_methods_to_locations").prop("checked",!1),jQuery("#wcmlim_order_fulfil_edit").prop("checked",!0),jQuery("#wcmlim_order_fulfil_automatically").prop("checked",!0),jQuery("#wcmlim_allow_local_pickup").prop("checked",!0)):jQuery("#wcmlim_order_fulfil_edit").prop("checked",!1)})),jQuery("#wcmlim_allow_local_pickup").on("change",(function(){jQuery(this).is(":checked")&&(switchStatus=jQuery(this).is(":checked"),jQuery("#wcmlim_next_closest_location").prop("checked",!1),jQuery("#wcmlim_hide_out_of_stock_location").prop("checked",!1),jQuery("#wcmlim_clear_cart").prop("checked",!1),jQuery("#wcmlim_enable_userspecific_location").prop("checked",!1),jQuery("#wcmlim_preferred_location").prop("checked",!1),jQuery("#wcmlim_enable_autodetect_location").prop("checked",!1),jQuery("#wcmlim_geo_location").prop("checked",!1),jQuery("#wcmlim_enable_price").prop("checked",!1),jQuery("#wcmlim_hide_show_location_dropdown").prop("checked",!1),jQuery("#wcmlim_enable_location_onshop").prop("checked",!1),jQuery("#wcmlim_enable_location_price_onshop").prop("checked",!1),jQuery("#wcmlim_sort_shop_asper_glocation").prop("checked",!1),jQuery("#wcmlim_use_location_widget").prop("checked",!1),jQuery("#wcmlim_enable_shipping_zones").prop("checked",!1),jQuery("#wcmlim_enable_shipping_methods").prop("checked",!1),jQuery("#wcmlim_assign_payment_methods_to_locations").prop("checked",!1),jQuery("#wcmlim_order_fulfil_edit").prop("checked",!0),jQuery("#wcmlim_allow_only_backend").prop("checked",!0),jQuery("#wcmlim_allow_local_pickup").prop("checked",!0))})),e(".wcmlim_update_inline_stock").on("click",(t=>{e(".wcmlim_update_inline_stock_msg").css("visibility","unset"),e(".wcmlim_update_inline_stock_msg").html('<i class="fas fa-spinner fa-spin"></i> Loading');var o=e(".wcmlim_stock_modal_location_stock").val(),i=e(".wcmlim_stock_modal_product_id").val(),a=e(".wcmlim_stock_modal_location_id").val();e("#stock_data_attr_change_"+i+"_"+a).attr("data-stock",o),e(".change_"+i+"_"+a).html("("+o+")"),e.ajax({url:multi_inventory.ajaxurl,type:"post",data:{action:"update_stock_inline",location_stock:o,product_id:i,location_id:a},success(t){t&&(e(".wcmlim_update_inline_stock_msg").html("Updated Stock Successfully!").delay(5e3).fadeIn(),setTimeout((function(){e(".wcmlim_update_inline_stock_msg").css("visibility","hidden")}),3e3)),document.getElementById("stockModal").style.display="none",location.reload()}})})),e(".wcmlim_update_inline_price").on("click",(t=>{e(".wcmlim_update_inline_stock_msg").css("visibility","unset"),e(".wcmlim_update_inline_stock_msg").html('<i class="fas fa-spinner fa-spin"></i> Loading');var o=e(".wcmlim_stock_modal_location_regular_price").val(),i=e(".wcmlim_stock_modal_location_sale_price").val(),a=e(".wcmlim_stock_modal_product_id").val(),r=e(".wcmlim_stock_modal_location_id").val(),l=e(".wcmlim_stock_modal_currency").val(),c="";"NaN"===parseFloat(o)?(e(".wcmlim_update_inline_stock_msg").html('<span class="wcmlim_modal_validation">Entered Regular Price is Invalid</span>').delay(1e3).fadeIn(),setTimeout((function(){e(".wcmlim_update_inline_stock_msg").css("visibility","hidden")}),1e6)):"NaN"===parseFloat(i)&&null!=o?(e(".wcmlim_update_inline_stock_msg").html('<span class="wcmlim_modal_validation">Entered Sale Price is Invalid</span>').delay(1e3).fadeIn(),setTimeout((function(){e(".wcmlim_update_inline_stock_msg").css("visibility","hidden")}),1e6)):""==o&&""!=i?(e(".wcmlim_update_inline_stock_msg").html('<span class="wcmlim_modal_validation">Regular Price is missing !</span>').delay(1e3).fadeIn(),setTimeout((function(){e(".wcmlim_update_inline_stock_msg").css("visibility","hidden")}),1e6)):i>o?(e(".wcmlim_update_inline_stock_msg").html('<span class="wcmlim_modal_validation">Sales Price can not be greater than Regular Price !</span>').delay(1e3).fadeIn(),setTimeout((function(){e(".wcmlim_update_inline_stock_msg").css("visibility","hidden")}),1e6)):(c=""!=i&&null!=i&&"NaN"!=i?'<del aria-hidden="true"><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">'+l+"</span>"+(o=parseFloat(o).toFixed(2))+'</span></del> <ins><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">'+l+"</span>"+(i=parseFloat(i).toFixed(2))+"</span></ins>":'<ins><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">'+l+"</span>"+(o=parseFloat(o).toFixed(2))+"</span></ins>",e("#price_data_attr_change_"+a+"_"+r).attr("data-saleprice",i),e("#price_data_attr_change_"+a+"_"+r).attr("data-regularprice",o),e(".price_change_"+a+"_"+r).html("("+c+")"),e.ajax({url:multi_inventory.ajaxurl,type:"post",data:{action:"update_price_inline",sale_price:i,regular_price:o,product_id:a,location_id:r},success(t){t&&(e(".wcmlim_update_inline_stock_msg").html("Updated Price Successfully!").delay(5e3).fadeIn(),setTimeout((function(){e(".wcmlim_update_inline_stock_msg").css("visibility","hidden")}),3e3)),document.getElementById("priceModal").style.display="none"}}))})),e(".wcmlim_edit_stock_pro_list").on("click",(t=>{var o=t.target.getAttribute("data-id"),i=t.target.getAttribute("data-location"),a=t.target.getAttribute("data-stock"),r=t.target.getAttribute("data-productname"),l=t.target.getAttribute("data-locationname");e(".wcmlim_stock_modal_product_name").text(r),e(".wcmlim_stock_modal_location_name").text("Stock At "+l),e(".wcmlim_stock_modal_location_stock").val(a),e(".wcmlim_stock_modal_product_id").val(o),e(".wcmlim_stock_modal_location_id").val(i);var c=document.getElementById("stockModal"),n=document.getElementsByClassName("wcmlim-close")[0];c.style.display="block",n.onclick=function(){c.style.display="none"},window.onclick=function(e){e.target==c&&(c.style.display="none")}})),e(".wcmlim_edit_price_pro_list").on("click",(t=>{e("#priceModal").css("padding-top","13%");var o=t.target.getAttribute("data-id"),i=t.target.getAttribute("data-location"),a=t.target.getAttribute("data-regularprice"),r=t.target.getAttribute("data-saleprice"),l=t.target.getAttribute("data-currency"),c=t.target.getAttribute("data-productname"),n=t.target.getAttribute("data-locationname");e(".wcmlim_stock_modal_product_name").text(c),e(".wcmlim_stock_modal_location_name").text("Selected Location - "+n),e(".wcmlim_stock_modal_location_sale_price").val(r),e(".wcmlim_stock_modal_location_regular_price").val(a),e(".wcmlim_stock_modal_product_id").val(o),e(".wcmlim_stock_modal_location_id").val(i),e(".wcmlim_stock_modal_currency").val(l),e(".wcmlim_price_currency").text(l);var s=document.getElementById("priceModal"),m=document.getElementsByClassName("wcmlim-price-modal-close")[0];s.style.display="block",m.onclick=function(){s.style.display="none"},window.onclick=function(e){e.target==s&&(s.style.display="none")}}))})),document.addEventListener("wheel",(function(e){"number"===document.activeElement.type&&document.activeElement.classList.contains("noscroll")&&document.activeElement.blur()})),jQuery(document).ready((e=>{e("#wcmlim_use_location_widget").prop("checked")?e("#wcmlim_option_for_selection").show():e("#wcmlim_option_for_selection").hide(),e("#wcmlim_use_location_widget").click((function(){e("#wcmlim_use_location_widget").prop("checked")?e("#wcmlim_option_for_selection").show():e("#wcmlim_option_for_selection").hide()})),jQuery("#wcmlim_allow_only_backend").on("change",(function(){jQuery(this).is(":checked")?(switchStatus=jQuery(this).is(":checked"),jQuery("label[for='tab1']").css({cursor:"not-allowed",filter:"blur(1px)"}),jQuery("label[for='tab3']").css({cursor:"not-allowed",filter:"blur(1px)"}),jQuery("label[for='tab4']").css({cursor:"not-allowed",filter:"blur(1px)"}),jQuery("label[for='tab5']").css({cursor:"not-allowed",filter:"blur(1px)"}),jQuery("label[for='tab6']").css({cursor:"not-allowed",filter:"blur(1px)"}),jQuery("#wcmlim_enable_userspecific_location").parents("tr").hide(),jQuery("#wcmlim_exclude_locations_from_frontend").parents("tr").hide(),jQuery("#wcmlim_next_closest_location").parents("tr").hide(),jQuery("#wcmlim_distance_calculator_by_coordinates").parents("tr").hide(),jQuery("#wcmlim_hide_out_of_stock_location").parents("tr").hide(),jQuery("#wcmlim_clear_cart").parents("tr").hide(),jQuery("#wcmlim_pos_compatiblity").parents("tr").hide(),jQuery("#wcmlim_wc_pos_compatiblity").parents("tr").hide(),jQuery("#general_setting_form").children("h2").hide(),jQuery("#tab1").attr("disabled","true"),jQuery("#tab3").attr("disabled","true"),jQuery("#tab4").attr("disabled","true"),jQuery("#tab5").attr("disabled","true"),jQuery("#tab6").attr("disabled","true"),jQuery("#wcmlim_next_closest_location").prop("checked",!1),jQuery("#wcmlim_hide_out_of_stock_location").prop("checked",!1),jQuery("#wcmlim_clear_cart").prop("checked",!1),jQuery("#wcmlim_enable_userspecific_location").prop("checked",!1),jQuery("#wcmlim_preferred_location").prop("checked",!1),jQuery("#wcmlim_enable_autodetect_location").prop("checked",!1),jQuery("#wcmlim_geo_location").prop("checked",!1),jQuery("#wcmlim_enable_price").prop("checked",!1),jQuery("#wcmlim_hide_show_location_dropdown").prop("checked",!1),jQuery("#wcmlim_enable_location_onshop").prop("checked",!1),jQuery("#wcmlim_enable_location_price_onshop").prop("checked",!1),jQuery("#wcmlim_sort_shop_asper_glocation").prop("checked",!1),jQuery("#wcmlim_use_location_widget").prop("checked",!1),jQuery("#wcmlim_enable_shipping_zones").prop("checked",!1),jQuery("#wcmlim_enable_shipping_methods").prop("checked",!1),jQuery("#wcmlim_assign_payment_methods_to_locations").prop("checked",!1),jQuery("#wcmlim_order_fulfil_edit").prop("checked",!0),jQuery("#wcmlim_order_fulfil_automatically").prop("checked",!0),jQuery("#wcmlim_allow_local_pickup").prop("checked",!0)):(jQuery("#wcmlim_enable_userspecific_location").parents("tr").show(),jQuery("#wcmlim_exclude_locations_from_frontend").parents("tr").show(),jQuery("#wcmlim_next_closest_location").parents("tr").show(),jQuery("#wcmlim_distance_calculator_by_coordinates").parents("tr").show(),jQuery("#wcmlim_hide_out_of_stock_location").parents("tr").show(),jQuery("#wcmlim_clear_cart").parents("tr").show(),jQuery("#wcmlim_pos_compatiblity").parents("tr").show(),jQuery("#wcmlim_wc_pos_compatiblity").parents("tr").show(),jQuery("#general_setting_form").children("h2").show(),jQuery("label[for='tab1']").css({cursor:"",filter:""}),jQuery("label[for='tab3']").css({cursor:"",filter:""}),jQuery("label[for='tab4']").css({cursor:"",filter:""}),jQuery("label[for='tab5']").css({cursor:"",filter:""}),jQuery("label[for='tab6']").css({cursor:"",filter:""}),jQuery("#tab1").removeAttr("disabled"),jQuery("#tab3").removeAttr("disabled"),jQuery("#tab4").removeAttr("disabled"),jQuery("#tab5").removeAttr("disabled"),jQuery("#tab6").removeAttr("disabled"),jQuery("#wcmlim_order_fulfil_edit").prop("checked",!1))})),jQuery("#wcmlim_allow_only_backend").is(":checked")?(jQuery("#wcmlim_enable_userspecific_location").parents("tr").hide(),jQuery("#wcmlim_exclude_locations_from_frontend").parents("tr").hide(),jQuery("#wcmlim_next_closest_location").parents("tr").hide(),jQuery("#wcmlim_distance_calculator_by_coordinates").parents("tr").hide(),jQuery("#wcmlim_hide_out_of_stock_location").parents("tr").hide(),jQuery("#wcmlim_clear_cart").parents("tr").hide(),jQuery("#wcmlim_pos_compatiblity").parents("tr").hide(),jQuery("#wcmlim_wc_pos_compatiblity").parents("tr").hide(),jQuery("#general_setting_form").children("h2").hide(),jQuery("label[for='tab1']").css({cursor:"not-allowed",filter:"blur(1px)"}),jQuery("label[for='tab3']").css({cursor:"not-allowed",filter:"blur(1px)"}),jQuery("label[for='tab4']").css({cursor:"not-allowed",filter:"blur(1px)"}),jQuery("label[for='tab5']").css({cursor:"not-allowed",filter:"blur(1px)"}),jQuery("label[for='tab6']").css({cursor:"not-allowed",filter:"blur(1px)"}),jQuery("#tab1").attr("disabled","true"),jQuery("#tab3").attr("disabled","true"),jQuery("#tab4").attr("disabled","true"),jQuery("#tab5").attr("disabled","true"),jQuery("#tab6").attr("disabled","true")):(jQuery("#wcmlim_enable_userspecific_location").parents("tr").show(),jQuery("#wcmlim_exclude_locations_from_frontend").parents("tr").show(),jQuery("#wcmlim_next_closest_location").parents("tr").show(),jQuery("#wcmlim_distance_calculator_by_coordinates").parents("tr").show(),jQuery("#wcmlim_hide_out_of_stock_location").parents("tr").show(),jQuery("#wcmlim_clear_cart").parents("tr").show(),jQuery("#wcmlim_pos_compatiblity").parents("tr").show(),jQuery("#wcmlim_wc_pos_compatiblity").parents("tr").show(),jQuery("#general_setting_form").children("h2").show(),jQuery("label[for='tab1']").css({cursor:"",filter:""}),jQuery("label[for='tab3']").css({cursor:"",filter:""}),jQuery("label[for='tab4']").css({cursor:"",filter:""}),jQuery("label[for='tab5']").css({cursor:"",filter:""}),jQuery("label[for='tab6']").css({cursor:"",filter:""}),jQuery("#tab1").removeAttr("disabled"),jQuery("#tab3").removeAttr("disabled"),jQuery("#tab4").removeAttr("disabled"),jQuery("#tab5").removeAttr("disabled"),jQuery("#tab6").removeAttr("disabled"))}));