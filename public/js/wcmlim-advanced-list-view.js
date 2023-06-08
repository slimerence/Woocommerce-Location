jQuery( document ).ready( ( $ ) =>
{

  $.noConflict();
  let lat;
  let lng;
  const { ajaxurl } = multi_inventory;
  const { wc_currency } = multi_inventory;
  const autoDetect = multi_inventory.autodetect;
  const { enable_price } = multi_inventory;
  const restricted = multi_inventory.user_specific_location;
  const showLocationInRestricted = multi_inventory.show_location_selection;
  const { instock } = multi_inventory;
  const { soldout } = multi_inventory;
  const stock_format = multi_inventory.stock_format;
  const { widget_select_type } = multi_inventory;
  const nextloc = multi_inventory.nxtloc;
  var store_on_map_arr = multi_inventory.store_on_map_arr;
  var default_zoom = multi_inventory.default_zoom;
  var setting_loc_dis_unit = multi_inventory.setting_loc_dis_unit;
  var listmode = multi_inventory.optiontype_loc;
  var sc_listmode = multi_inventory.scoptiontype_loc;
  var detailadd = multi_inventory.fulladd;
  var listformat = multi_inventory.viewformat;
  var wchideoosproduct = multi_inventory.wchideoosproduct;
  var NextClosestinStock = multi_inventory.NextClosestinStock;
  var isdefault = multi_inventory.isdefault;
  const { isClearCart } = multi_inventory;
  const { isLocationsGroup } = multi_inventory;
  const extractMoney = function ( string )
  {
    const amount = string.match( /[0-9]+([,.][0-9]+)?/ );
    const unit = string.replace( /[0-9]+([,.][0-9]+)?/, "" );
    if ( amount && unit )
    {
      return {
        amount: +amount[ 0 ].replace( ",", "." ),
        currency: unit,
      };
    }
    return null;
  };

  // This code is responsible for hide out of stock product from all site as per locations qty


  advanced_listOrdering();
  $( ".variation_id" ).change( () =>
    {
      advanced_listOrdering();
    });
  function advanced_listOrdering ()
  {
    
    if ( listmode == "on" )
    {
      if ( listformat == 'advanced_list_view' )
      {
        
        $( ".rselect_location" ).removeClass( "wclimscroll" );
        $( ".rselect_location" ).removeClass( "wclimhalf" );
        $( ".rselect_location" ).removeClass( "wclimthird" );
        $( ".rselect_location" ).removeClass( "wclimfull" );
        $( ".loc_dd.Wcmlim_prefloc_sel .wc_scrolldown" ).hide();
        $( ".rselect_location" ).addClass( "wclimadvlist" );         
       
        
        //get locations price and stock information
        if ( $( '.variation_id' ).length )
        {
          var product_id = $( "input.variation_id" ).val();
        }
        else
        {
          var product_id = $( ".single_add_to_cart_button" ).val();
        }
        if(product_id != 0)
        {

          $.ajax( {
            type: "POST",
            url: ajaxurl,
            data: {
              action: "wcmlim_prepare_advanced_view_information",
              product_id: product_id,
            },
            dataType: "json",
            success ( response )
            {
              // Hide add to cart button if advance list view is enabled
              jQuery('.single_add_to_cart_button').hide();
              jQuery('.quantity').hide();
              jQuery(' #globMsg').hide();
              
              // var obj = jQuery.parseJSON(response);
              $.each(response, function(key,value) {
                var indexing = value.indexing;
                var location_id = value.location_id;
                var loc_stock_pid = value.loc_stock_pid;
                var loc_each_backorder = value.loc_each_backorder;

                var stock_price = value.stock_price;
                var shipping_cost = value.shipping_cost;
                var start_time = value.location_start_time;
                var end_time = value.location_end_time;
                var html = "<div class='wcmlim-advanced-detailed'>";
                html += "<span class='wcmlim_list_view_price'> "+ wc_currency+ stock_price +"</span><br>";
                html += "</div>";
                var html3 = "<div class='wcmlim-advanced-detailed1'>";
                html3 += "<span class='wcmlim_list_view_shippingprice'><span class='wcmlim-adv-li-icon fa fa-truck'></span>: "+ shipping_cost +"</span>";
                html3 += "</div>";
                if (start_time != undefined && end_time != undefined) {
                 var html1 = "<p>Open By: " + start_time +"</p>";
                 html1 += " <p>Closed By: " + end_time + "</p>";
                }

                if(loc_stock_pid <= 0 && loc_each_backorder != 'Yes'){ button_class = ' pointer-events: none! important;'}else {  button_class = ' pointer-events: auto! important;'}

                html2 ="<div class='wcmlim_addtocart '><input type='number' class='input-text qty text wcmlim_list_view_custom_input ' step='1' min='1' max='"+loc_stock_pid+"' title='Qty' size='4' placeholder='1' inputmode='numeric' autocomplete='off' >";
                html2 +="<button type='submit' data-lc-term-id='"+location_id+"' name='add-to-cart' id='list_view' value='"+product_id+"' class='single_add_to_cart_button single_add_to_cart_button1 button alt' style='"+button_class+"'><span class='fa fa-shopping-cart'></span></button>";
                html2 +="</div>";
  
                $(".wclimrw_"+indexing+" .wclimcol2").wrap('<div class="wcmlim_wrapper_adv_list_view"></div>');
                jQuery(html3).insertAfter(".wclimrw_"+indexing+" .wclimcol2 .stockupp"); 

                jQuery(html).insertAfter(".wclimrw_"+indexing+" .wclimcol2"); 
                jQuery(html1).insertAfter(" .wcmlim_optadd"+indexing); 
                jQuery(html2).insertAfter(".wclimrw_"+indexing+" .wcmlim_wrapper_adv_list_view");  
              }); 
              
              var indexing  = response.length;
              indexing = indexing+1;
              $('.wclimrw_'+indexing).remove();  
              
            }
            
          });
          
          
        }
        
      }
    }
    $(document).on('mouseover', '.wcmlradio_box .wclimrow', function()
    {
      $(this).children('input').prop('checked', true);
      
      $('.wclimcol1').removeClass('selected');
      $(this).toggleClass('selected');
      $(this).find('input').trigger('click');
      var qty_input = $(this).children('input');
      var qty_button = $(this).children('button');
      var qty_input = $(this).children('.wcmlim_addtocart').children('input');
      var qty_button = $(this).children('.wcmlim_addtocart').children('button');
      $(qty_input, qty_button).hover(function() {
       var quantity1 = $(this).val();
       $("div.quantity").children('input').val(quantity1);
     });
    });
}  /**End listOrdering */

} );