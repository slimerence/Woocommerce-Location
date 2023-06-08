jQuery( document ).ready( ( $ ) =>
{
  $.noConflict();
  let lat;
  let lng;
  const { ajaxurl } = multi_inventory;
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
  var hideDropdown = multi_inventory.hideDropdown;

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
  if ( wchideoosproduct == "yes" )
  {
    const ThemesArray = [ "theme-astra", "theme-flatsome", "theme-woodmart", "theme-xstore", "theme-kuteshop-elementor", "theme-kuteshop" ];
    ThemesArray.forEach( ( entry ) =>
    {
      if ( $( "body.home" ).hasClass( entry ) && entry == "theme-flatsome" || $( "body.home" ).hasClass( entry ) && entry == "theme-xstore" )
      {
        $( "body.home" ).find( ".locsoldout" ).parent().parent().parent().parent().remove();
      }
      if ( $( "body.single-product" ).hasClass( entry ) && entry == "theme-flatsome" || $( "body.single-product" ).hasClass( entry ) && entry == "theme-xstore" )
      {
        $( "body.single-product" ).find( ".locsoldout" ).parent().parent().parent().parent().remove();
      }
      if ( $( "body.home" ).hasClass( entry ) && entry == "theme-astra" || $( "body.home" ).hasClass( entry ) && entry == "theme-kuteshop-elementor" || $( "body.home" ).hasClass( entry ) && entry == "theme-kuteshop" )
      {
        $( "body.home" ).find( ".locsoldout" ).parent().parent().parent().remove();
      }
      if ( $( "body.single-product" ).hasClass( entry ) && entry == "theme-astra" || $( "body.single-product" ).hasClass( entry ) && entry == "theme-kuteshop-elementor" )
      {
        $( "body.single-product" ).find( ".locsoldout" ).parent().parent().parent().remove();
      }
    } );
  }

  var gnl = document.cookie;
  if ( autoDetect == "on" )
  {
    if ( gnl.search( "wcmlim_nearby_location" ) == -1 )
    {
      var dialogShown = localStorage.getItem( 'dialogShown' );
      if ( !dialogShown )
      {
        showPosition();
      }
    };
  }
  listOrdering();
  function listOrdering ()
  {    
    
    if ( listmode == "on" )
    {
      unlistmode = {};
      $( ".loc_dd.Wcmlim_prefloc_sel #select_location" ).hide();
      $( ".loc_dd.Wcmlim_prefloc_sel .wc_locmap" ).hide();
      $( "#losm" ).hide();
      $( "#globMsg" ).hide();
      const locationCookie = getCookie( "wcmlim_selected_location" );
      $( "#select_location option" ).each( function ( i, e )
      {
        var locvalue = $( this ).val();
        if ( !( locvalue in unlistmode ) )
        {

          unlistmode[ locvalue ] = "";
          var wclimrw_ = '.wclimrw_' + i;
          var locclass = $( this ).attr( 'class' );
          var stockupp = $( this ).attr( 'data-lc-qty' );  
          var backorderl = $( this ).attr( 'data-backorder' ); 
          var style = $( this ).attr( 'style' );
         
          if(stockupp != undefined  && stockupp != null){
            $( '<div class="wclimrow wclimrw_' + i + '"></div>' ).html( "" ).attr( "style",style).appendTo( ".rselect_location" );
          }
          if(locvalue == locationCookie) { var wclimcheck = true; } else { var wclimcheck = false; }
          $( "<input class='wclimcol1 wclim_inp" + i + "' type='radio' name='select_location' />" )
            .attr( "value", $( this ).val() )
            .attr( "checked", wclimcheck )
            .attr( "data-lc-qty", $( this ).attr( 'data-lc-qty' ) )
            .attr( "data-lc-address", $( this ).attr( 'data-lc-address' ) )
            .attr( "data-lc-backorder", $( this ).attr( 'data-lc-backorder' ) )
            .attr( "data-lc-stockstatus", $( this ).attr( 'data-lc-stockstatus' ) )         
            .addClass( locclass )
            .click( function ()
            {
              $( "#select_location" ).val( $( this ).val() ).trigger( 'change' );
              if ( isClearCart != "on" )
              {
                setcookie( "wcmlim_selected_location", $( this ).val() );
              }
            } ).appendTo( wclimrw_ );
          var labelText1 = $( this ).text();
          var labelText2 = labelText1.split( "-" );
          var labelText3 = labelText2[ 0 ].split( ":" );
          var labelText4 = $( this ).attr( 'data-lc-address' );
          var backorder_allow = $( this ).attr( 'data-lc-backorder' );
          var simple_product_backorder  = $( "#backorderAllowed" ).val();
          var location_stock_status = $( this ).attr( 'data-lc-stockstatus' );
          var currentItem = $( "input[class='wclimcol1 wclim_inp" + i + " " + locclass + "'][value='" + $( this ).val() + "']" );
          $( "<div class='wclimcol2'>" ).html( "<p class='wcmlim_optloc" + i + " " + locclass + "'>" + labelText3 + "</p>" ).insertAfter( currentItem );
          var pItem = '.wcmlim_optloc' + i;
          if ( labelText4 == undefined )
          {
            $( "<p class='wcmlim_detadd wcmlim_optadd" + i + "'>" ).text( "" ).insertAfter( pItem );
          } else
          {
            var labelText5 = String( labelText4 );
            var decodedString = decodeURIComponent( escape( atob( labelText5 ) ) );
            $( "<p class='wcmlim_detadd wcmlim_optadd" + i + "'>" ).text( decodedString ).insertAfter( pItem );
          }
          var paddress = '.wcmlim_optadd' + i;
          var stockupp = $( this ).attr( 'data-lc-qty' );
          var onbackorder = passedbackorderbtn.keys;
          var instockbtntxt = passedinstockbtn.keys;
          if(location_stock_status == 'instock'){
            $( "<p class='stockupp'>" ).text( instockbtntxt ).insertAfter( paddress );
           }
           
          if (backorder_allow == 'yes' || simple_product_backorder == 1){
            var soldoutbtntxt = "On Backorder";
            
            $( "<p class='outof_stockupp'>" ).text( soldoutbtntxt ).insertAfter( paddress );
          }else {
          if ( stockupp == 0 )
          {
            if(location_stock_status == 'instock'){
              
            // $( "<p class='stockupp'>" ).text( "In Stock" ).insertAfter( paddress );
          }else {
            if (backorder_allow == 'yes' || simple_product_backorder == 1){
          
              var soldoutbtntxt = "On Backorder";
            }else {
              var soldoutbtntxt = passedSoldbtn.keys;
            }
            //allow backorder
            if( backorderl == "Yes" && multi_inventory.isBackorderOn == "on"){
              $( "<p class='outof_stockupp'>" ).text( "Backorder").insertAfter( paddress );            
            }else{
              
              $( "<p class='outof_stockupp'>" ).text( soldoutbtntxt ).insertAfter( paddress );
            }
              
          }

          } else if ( stockupp == "undefined" || stockupp == null )
          {
            $( "<p class='stockupp'>" ).text( "" ).insertAfter( paddress );
          } else
          {
            if( backorderl == "Yes" && multi_inventory.isBackorderOn == "on"){
              $( "<p class='outof_stockupp'>" ).text( "Backorder").insertAfter( paddress );            
            }else{
              if ( stock_format == "no_amount" )
              {
                $( "<p class='stockupp'>" ).text( instockbtntxt ).insertAfter( paddress );
              } else {
                $( "<p class='stockupp'>" ).text( instockbtntxt+' '+':' + stockupp ).insertAfter( paddress );             
              }    
            }
                     
          }

        
        }  
          if ( detailadd == "on" )
          {
            $( ".wcmlim_detadd" ).show();
          } else
          {
            $( ".wcmlim_detadd" ).hide();
          }
        } else
        {
          $( this ).remove();
        }
      } );
      if (( listformat == 'full' || listformat == null || listformat == '' ) && (listformat != 'advanced_list_view' ))
      {
        $( ".rselect_location" ).removeClass( "wclimscroll" );
        $( ".rselect_location" ).removeClass( "wclimhalf" );
        $( ".rselect_location" ).removeClass( "wclimthird" );
        $( ".rselect_location" ).removeClass( "wclimadvlist" );
        $( ".loc_dd.Wcmlim_prefloc_sel .wc_scrolldown" ).hide();
        $( ".rselect_location" ).addClass( "wclimfull" );
      } else if ( listformat == 'half' )
      {
        $( ".rselect_location" ).removeClass( "wclimfull" );
        $( ".rselect_location" ).removeClass( "wclimthird" );
        $( ".rselect_location" ).removeClass( "wclimscroll" );
        $( ".rselect_location" ).removeClass( "wclimadvlist" );
        $( ".loc_dd.Wcmlim_prefloc_sel .wc_scrolldown" ).hide();
        $( ".rselect_location" ).addClass( "wclimhalf" );
      } else if ( listformat == 'third' )
      {
        $( ".rselect_location" ).removeClass( "wclimfull" );
        $( ".rselect_location" ).removeClass( "wclimhalf" );
        $( ".rselect_location" ).removeClass( "wclimscroll" );
        $( ".rselect_location" ).removeClass( "wclimadvlist" );
        $( ".loc_dd.Wcmlim_prefloc_sel .wc_scrolldown" ).hide();
        $( ".rselect_location" ).addClass( "wclimthird" );
      } else if ( listformat == 'scroll' )
      {
        $( ".rselect_location" ).removeClass( "wclimfull" );
        $( ".rselect_location" ).removeClass( "wclimhalf" );
        $( ".rselect_location" ).removeClass( "wclimthird" );
        $( ".rselect_location" ).removeClass( "wclimadvlist" );
        $( ".rselect_location" ).addClass( "wclimscroll" );
        $( ".loc_dd.Wcmlim_prefloc_sel .wc_scrolldown" ).show();
        $( ".rselect_location.wclimscroll" ).css( "height", "200px" );
      } else
      {
        $( ".rselect_location" ).removeClass( "wclimscroll" );
        $( ".rselect_location" ).removeClass( "wclimhalf" );
        $( ".rselect_location" ).removeClass( "wclimthird" );
        $( ".rselect_location" ).removeClass( "wclimadvlist" );
        $( ".loc_dd.Wcmlim_prefloc_sel .wc_scrolldown" ).hide();
        $( ".rselect_location" ).addClass( "wclimfull" );
      }
    } else
    {        
      $( ".loc_dd.Wcmlim_prefloc_sel #select_location" ).show();
      $( ".loc_dd.Wcmlim_prefloc_sel .wc_locmap" ).show();
      $( "#losm" ).show();
      $( "#globMsg" ).show();
      $( ".loc_dd.Wcmlim_prefloc_sel .wc_scrolldown" ).hide();
      $( ".rselect_location.wclimscroll" ).css( "height", "0" );
    }
  }  /**End listOrdering */
  sc_listOrdering();
  function sc_listOrdering ()
  {
    if ( sc_listmode == "on" )
    {

      $( ".wcmlim_sel_location #wcmlim-change-lc-select" ).hide();
      uniqueLi = {};
      $( "#wcmlim-change-lc-select option" ).each( function ( i, e )
      {
        var thisVal = $( this ).text();
        if ( !( thisVal in uniqueLi ) )
        {
          uniqueLi[ thisVal ] = "";
          var scwclimrw_ = '.scwclimrw_' + i;
          $( '<div class="scwclimrow scwclimrw_' + i + '"></div>' ).html( "" ).appendTo( ".rlist_location" );
          $( "<input class='scwclimcol1 scwclim_inp" + i + "' type='radio' name='wcmlim_change_lc_to' />" )
            .attr( "value", $( this ).val() )
            .click( function ()
            {
              $( "#wcmlim-change-lc-select" ).val( $( this ).val() ).trigger( 'change' );
              setcookie( "wcmlim_selected_location", $( this ).val() );
            } ).appendTo( scwclimrw_ );
          var label1 = $( this ).text();
          var label2 = label1.split( "-" );
          var label3 = label2[ 0 ].split( ":" );
          var currentclass = $( "input[class='scwclimcol1 scwclim_inp" + i + "'][value='" + $( this ).val() + "']" );
          $( "<div class='scwclimcol2'>" ).html( "<p class='scwcmlim_optloc" + i + "'>" + label3 + "</p>" ).insertAfter( currentclass );
        } else
        {
          $( this ).remove();
        }
      } );
    }
    else
    {
      $( ".wcmlim_sel_location #wcmlim-change-lc-select" ).show();
    }
  } /**End sc_listOrdering */

  if ( $( ".wcmlim-map-widgets" ).length != 0 )
  {
    if ( $( ".map-view-locations" ).length != 0 )
    {
      $( "#wcmlim_map_prodct_filter" ).chosen( { width: "60%" } );
      $( "#wcmlim_map_prodct_category_filter" ).chosen( { width: "60%" } );
      $( ".map-view-locations" ).hide();
      $( ".map-view-locations" ).after(
        '<div class="wcmlim-map-loader"><i class="fa fa-spinner fa-spin" style="font-size:24px"></i><br> Loading</div>'
      );
      $( ".wcmlim-map-loader" ).hide( 2000 );
      $( ".map-view-locations" ).delay( 2000 ).fadeIn( 500 );
    }
    if ( $( ".list-view-locations" ).length != 0 )
    {
      $( "#wcmlim_map_prodct_filter" ).chosen( { width: "60%" } );
      $( "#wcmlim_map_prodct_category_filter" ).chosen( { width: "60%" } );
      $( ".list-view-locations" ).hide();
      $( ".list-view-locations" ).after(
        '<div class="wcmlim-map-loader"><i class="fa fa-spinner fa-spin" style="font-size:24px"></i><br> Loading</div>'
      );
      $( ".wcmlim-map-loader" ).hide( 2000 );
      $( ".list-view-locations" ).delay( 2000 ).fadeIn( 500 );
    }
    if ( default_zoom == "" || default_zoom == "undefined" )
    {
      default_zoom = 10;
    }
    var default_origin_center = multi_inventory.default_origin_center;
    var def_search_lng = 0;
    var def_search_lat = 0;
    var icon = {
      path: "M172.268 501.67C26.97 291.031 0 269.413 0 192 0 85.961 85.961 0 192 0s192 85.961 192 192c0 77.413-26.97 99.031-172.268 309.67-9.535 13.774-29.93 13.773-39.464 0z", //SVG path of awesomefont marker
      fillColor: "#045590", //color of the marker
      fillOpacity: 1,
      strokeWeight: 0,
      anchor: new google.maps.Point( 200, 510 ), //position of the icon, careful! this is affected by scale
      labelOrigin: new google.maps.Point( 205, 190 ), //position of the label, careful! this is affected by scale
      scale: 0.06, //size of the marker, careful! this scale also affects anchor and labelOrigin
    };
    $( ".distance-bar" ).hide( 100 );
    if (
      $( ".list-view-locations" ).length != 0 &&
      $( ".map-view-locations" ).length != 0
    )
    {
      $( ".list-view-locations .search-filter-toggle_parameter_cat" ).hide();
      $( ".list-view-locations .search-filter-toggle_parameter" ).hide();
      $( ".list-view-locations .search-filter-toggle_parameter_prod" ).hide();
      $( ".list-view-locations" ).css( "margin", "8rem 0" );
    }
    $( ".search-filter-toggle_parameter_cat" ).hide( 100 );
    $( "#btn-filter-toggle_parameter2" ).click( function ()
    {
      $( ".search-filter-toggle_parameter_prod" ).hide( 100 );
      $( ".search-filter-toggle_parameter_cat" ).show( 100 );
    } );
    $( "#btn-filter-toggle_parameter1" ).click( function ()
    {
      $( ".search-filter-toggle_parameter_cat" ).hide( 100 );
      $( ".search-filter-toggle_parameter_prod" ).show( 100 );
    } );
    //   var store_on_map_arr_inpt = [JSON.parse(store_on_map_arr)];
    var store_on_map_arr_inpt = { origin: [] };

    var geocoder = new google.maps.Geocoder();

    if (
      default_origin_center != "" &&
      default_origin_center != null &&
      default_origin_center != "undefined"
    )
    {
      geocoder.geocode(
        { address: default_origin_center },
        function ( results, status )
        {
          if ( status == google.maps.GeocoderStatus.OK )
          {
            def_search_lat = results[ 0 ].geometry.location.lat();
            def_search_lng = results[ 0 ].geometry.location.lng();
            mapcontent =
              "<div class='locator-store-block origin-location-marker'><h4>" +
              default_origin_center +
              "</h4></div>";
            dataindex = store_on_map_arr.length + 1;
            type = "origin";
            store_on_map_arr_inpt[ "origin" ].push( {
              mapcontent,
              def_search_lat,
              def_search_lng,
              dataindex,
              type,
            } );
            calculate_distance_search( def_search_lat, def_search_lng );
          }
        }
      );
    } else
    {
      def_search_lat = 0;
      def_search_lng = 0;
      mapcontent =
        "<div class='locator-store-block origin-location-marker'><h4>Map Center</h4></div>";
      if ( store_on_map_arr == "undefined" )
      {
        dataindex = 1;
      } else
      {
        dataindex = store_on_map_arr.length + 1;
      }
      type = "origin";
      store_on_map_arr_inpt[ "origin" ].push( {
        mapcontent,
        def_search_lat,
        def_search_lng,
        dataindex,
        type,
      } );
      calculate_distance_search( def_search_lat, def_search_lng );
    }
    //nearby map location marker code starts here
    if ( autoDetect == "on" )
    {
      $( "#showMe" ).click( () =>
      {
        showPosition();
      } );
      $( ".elementIdGlobal, #elementIdGlobal" ).on( "click", function ()
      {
       
        $( ".wclimlocsearch" ).show();
      } );
      $( ".elementIdGlobal, #elementIdGlobal" ).on( "change", function ()
      {
        $( ".wclimlocsearch" ).hide();
      } );
      $( ".elementIdGlobal, #elementIdGlobal" ).on( "input", function ()
      {
        $( ".wclimlocsearch" ).hide();
      } );
      $( ".currentLoc" ).click( () =>
      {
        showPosition();
      } );
    }
    function calculate_distance_search ( search_lat, search_lng )
    {
      var i,
        x = "";
      $.ajax( {
        type: "POST",
        url: ajaxurl,
        data: {
          action: "wcmlim_calculate_distance_search",
          search_lat: search_lat,
          search_lng: search_lng,
        },
        dataType: "json",
        success ( res )
        {
          var maxdistance = 0;
          var xhtml = '';
          var comp_xhtml = '';
          for ( i = 0; i < res.length; i++ )
          {
            if ( maxdistance < res[ i ][ "distance" ] )
            {
              maxdistance = res[ i ][ "distance" ];
            }
            x = res[ i ][ "id" ];
            $( ".wcmlim-map-sidebar-widgets #" + x + " .miles" ).remove();
            if ( setting_loc_dis_unit == 'kms' )
            {
              $( ".wcmlim-map-sidebar-widgets #" + x ).append(
                '<p class="miles" data-id="' +
                x +
                '" data-value="' +
                ( res[ i ][ "distance" ].toFixed( 2 ) * 1.60934 ).toFixed( 2 ) +
                '"><span class="fa fa-paper-plane" aria-hidden="true"></span>' +
                ( res[ i ][ "distance" ].toFixed( 2 ) * 1.60934 ).toFixed( 2 ) +
                " " + setting_loc_dis_unit + " " +
                multi_inventory.away +
                "</p>"
              );
            }
            else
            {
              $( ".wcmlim-map-sidebar-widgets #" + x ).append(
                '<p class="miles" data-id="' +
                x +
                '" data-value="' +
                res[ i ][ "distance" ].toFixed( 2 ) +
                '"><span class="fa fa-paper-plane" aria-hidden="true"></span>' +
                res[ i ][ "distance" ].toFixed( 2 ) +
                " " + setting_loc_dis_unit + " " +
                multi_inventory.away +
                "</p>"
              );
            }
            xhtml = $( '#' + x ).html();
            comp_xhtml = comp_xhtml + '<div class="wcmlim-map-sidebar-list" id="' + x + '">' + xhtml + '</div>';
          }
          if ( setting_loc_dis_unit == 'kms' )
          {
            maxdistance = maxdistance * 1.60934;
          }
          maxdistance = maxdistance.toFixed( 2 );
          $( '.block-2' ).html( comp_xhtml );
          if ( $( "#rangeInput" ).length != 0 )
          {
            $( "#rangeInput" ).attr( "max", maxdistance );
            document.getElementById( "rangeInput" ).value =
              Math.round( maxdistance );
            document.getElementById( "rangedisplay" ).innerHTML =
              Math.round( maxdistance ) + " " + setting_loc_dis_unit;
            $( ".distance-bar" ).show();
          }
        },
      } );
    }
    if ( store_on_map_arr !== undefined )
    {
      try
      {
        var locations = JSON.parse( store_on_map_arr );
        var map;
        var marker;
        for ( i = 0; i < locations.length; i++ )
        {
          if ( locations[ i ][ 4 ] == "origin" )
          {
            map = new google.maps.Map( document.getElementById( "map" ), {
              zoom: parseInt( default_zoom ),
              center: new google.maps.LatLng( locations[ i ][ 1 ], locations[ i ][ 2 ] ),
              mapTypeId: google.maps.MapTypeId.ROADMAP,
            } );
            marker = new google.maps.Marker( {
              position: new google.maps.LatLng( locations[ i ][ 1 ], locations[ i ][ 2 ] ),
              map: map,
              label: {
                fontFamily: "'Font Awesome 5 Free'",
                fontWeight: "900", //careful! some icons in FA5 only exist for specific font weights
                color: "#FFFFFF", //color of the text inside marker
              },
            } );

            google.maps.event.addListener(
              marker,
              "click",
              ( function ( marker, i )
              {
                return function ()
                {
                  infowindow.setContent(
                    "<div class='locator-store-block'><h4>" +
                    locations[ i ][ 0 ] +
                    "</h4></div>"
                  );
                  infowindow.open( map, marker );
                };
              } )
            );
          } else
          {
            var markers = locations.map( function ( location, i )
            {
              var infowindow = new google.maps.InfoWindow( {
                maxWidth: 250,
              } );
              var marker = new google.maps.Marker( {
                position: new google.maps.LatLng(
                  locations[ i ][ 1 ],
                  locations[ i ][ 2 ]
                ),
                map: map,
              } );
              google.maps.event.addListener(
                marker,
                "click",
                ( function ( marker, i )
                {
                  return function ()
                  {
                    infowindow.setContent( locations[ i ][ 0 ] );
                    infowindow.open( map, marker );
                  };
                } )( marker, i )
              );
              return marker;
            } );
            // // Add a marker clusterer to manage the markers.
            new MarkerClusterer( map, markers, {
              imagePath:
                "https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m",
            } );
          }
        }
        const elmapgrid = document.getElementById( "elementIdGlobalMap" );

        var search_lat, search_lng;
        var infowindow = new google.maps.InfoWindow();
        var marker, i;
        if ( elmapgrid )
        {
          elmapgrid.addEventListener( "focus", ( e ) =>
          {
            const input = document.getElementById( "elementIdGlobalMap" );

            const options = {};
            const autocomplete = new google.maps.places.Autocomplete(
              input,
              options
            );
            google.maps.event.addListener( autocomplete, "place_changed", () =>
            {
              const place = autocomplete.getPlace();
              var searchedaddress = $( "#elementIdGlobalMap" ).val();

              search_lat = place.geometry.location.lat();
              search_lng = place.geometry.location.lng();
              for ( i = 0; i < locations.length; i++ )
              {
                if ( locations[ i ][ 4 ] == "origin" )
                {
                  map = new google.maps.Map( document.getElementById( "map" ), {
                    zoom: parseInt( default_zoom ),
                    center: new google.maps.LatLng( search_lat, search_lng ),
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                  } );
                  marker = new google.maps.Marker( {
                    position: new google.maps.LatLng( search_lat, search_lng ),
                    map: map,
                    icon: icon,
                    label: {
                      fontFamily: "'Font Awesome 5 Free'",
                      fontWeight: "900", //careful! some icons in FA5 only exist for specific font weights
                      color: "#FFFFFF", //color of the text inside marker
                    },
                  } );

                  google.maps.event.addListener(
                    marker,
                    "click",
                    ( function ( marker, i )
                    {
                      return function ()
                      {
                        infowindow.setContent(
                          "<div class='locator-store-block'><h4>" +
                          searchedaddress +
                          "</h4></div>"
                        );
                        infowindow.open( map, marker );
                      };
                    } )( marker )
                  );
                } else
                {
                  var markers = locations.map( function ( location, i )
                  {
                    var infowindow = new google.maps.InfoWindow( {
                      maxWidth: 250,
                    } );
                    var marker = new google.maps.Marker( {
                      position: new google.maps.LatLng(
                        locations[ i ][ 1 ],
                        locations[ i ][ 2 ]
                      ),
                      map: map,
                    } );
                    google.maps.event.addListener(
                      marker,
                      "click",
                      ( function ( marker, i )
                      {
                        return function ()
                        {
                          infowindow.setContent( locations[ i ][ 0 ] );
                          infowindow.open( map, marker );
                        };
                      } )( marker, i )
                    );
                    return marker;
                  } );
                  // // Add a marker clusterer to manage the markers.
                  new MarkerClusterer( map, markers, {
                    imagePath:
                      "https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m",
                  } );
                }
              }
              calculate_distance_search( search_lat, search_lng );
            } );
          } );
        }

        const my_current_location = document.getElementById(
          "my_current_location"
        );
        var current_search_lat, current_search_lng;
        my_current_location.addEventListener( "click", ( e ) =>
        {
          infoWindow = new google.maps.InfoWindow();
          var marker, i;
          if ( navigator.geolocation )
          {
            navigator.geolocation.getCurrentPosition( ( position ) =>
            {
              current_search_lat = position.coords.latitude;
              current_search_lng = position.coords.longitude;
              for ( i = 0; i < locations.length; i++ )
              {
                if ( locations[ i ][ 4 ] != "origin" )
                {
                  var markers = locations.map( function ( location, i )
                  {
                    var infowindow = new google.maps.InfoWindow( {
                      maxWidth: 250,
                    } );
                    var marker = new google.maps.Marker( {
                      position: new google.maps.LatLng(
                        locations[ i ][ 1 ],
                        locations[ i ][ 2 ]
                      ),
                      map: map,
                    } );
                    google.maps.event.addListener(
                      marker,
                      "click",
                      ( function ( marker, i )
                      {
                        return function ()
                        {
                          infowindow.setContent( locations[ i ][ 0 ] );
                          infowindow.open( map, marker );
                        };
                      } )( marker, i )
                    );
                    return marker;
                  } );
                  // // Add a marker clusterer to manage the markers.
                  new MarkerClusterer( map, markers, {
                    imagePath:
                      "https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m",
                  } );
                }
                else
                {
                  map = new google.maps.Map( document.getElementById( "map" ), {
                    zoom: parseInt( default_zoom ),
                    center: new google.maps.LatLng( current_search_lat, current_search_lng ),
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                  } );
                  marker = new google.maps.Marker( {
                    position: new google.maps.LatLng( current_search_lat, current_search_lng ),
                    map: map,
                    icon: icon,
                    label: {
                      fontFamily: "'Font Awesome 5 Free'",
                      fontWeight: "900", //careful! some icons in FA5 only exist for specific font weights
                      color: "#FFFFFF", //color of the text inside marker
                    },
                  } );

                  google.maps.event.addListener(
                    marker,
                    "click",
                    ( function ( marker, i )
                    {
                      return function ()
                      {
                        infowindow.setContent(
                          "<div class='locator-store-block'><h4>" +
                          searchedaddress +
                          "</h4></div>"
                        );
                        infowindow.open( map, marker );
                      };
                    } )( marker )
                  );
                }
              }
              calculate_distance_search( current_search_lat, current_search_lng );
            } );
          }
         
        } );
        $( "#search-parametered-btn-pro, #search-parametered-btn-cat" ).click(
          function ()
          {
            $( "#map" ).hide();
            $( ".wcmlim-map-loader" ).remove();
            $( "#map" ).after(
              '<div class="wcmlim-map-loader"><i class="fa fa-spinner fa-spin" style="font-size:24px"></i><br> Loading</div>'
            );
            var searchtype = $( this ).data( "type" );
            var selectedProduct = [];
            if ( searchtype == "product" )
            {
              $.each(
                $( "#wcmlim_map_prodct_filter option:selected" ),
                function ()
                {
                  selectedProduct.push( $( this ).val() );
                }
              );
            } else
            {
              $.each(
                $( "#wcmlim_map_prodct_category_filter option:selected" ),
                function ()
                {
                  selectedProduct.push( $( this ).val() );
                }
              );
            }
            $.ajax( {
              type: "POST",
              url: ajaxurl,
              data: {
                action: "wcmlim_filter_map_product_wise",
                parameter_id: selectedProduct,
                searchtype: searchtype,
              },
              dataType: "json",
              success ( res )
              {
                // console.log( res );
                var locations = JSON.parse( JSON.stringify( res ) );
                for ( i = 0; i < locations.length; i++ )
                {
                  if ( locations[ i ][ 4 ] != "origin" )
                  {
                    marker = new google.maps.Marker( {
                      position: new google.maps.LatLng(
                        locations[ i ][ 1 ],
                        locations[ i ][ 2 ]
                      ),
                      map: map,
                    } );
                    google.maps.event.addListener(
                      marker,
                      "click",
                      ( function ( marker, i )
                      {
                        return function ()
                        {
                          infowindow.setContent( locations[ i ][ 0 ] );
                          infowindow.open( map, marker );
                        };
                      } )( marker, i )
                    );
                    if ( $( ".wcmlim-map-widgets" ).length != 0 )
                    {
                      x = locations[ i ][ 4 ];
                      $(
                        ".wcmlim-map-widgets #" +
                        x +
                        " .location-address .search-prod-details"
                      ).remove();
                      $(
                        ".wcmlim-map-widgets #" + x + " .location-address"
                      ).append(
                        '<div class="search-prod-details" data-id="' +
                        x +
                        '">' +
                        locations[ i ][ 0 ] +
                        " </div>"
                      );
                    }
                    $( "#map" ).show();
                    $( ".wcmlim-map-loader" ).remove();
                  }
                }
              },
            } );
            $( "#map" ).show();
            $( ".wcmlim-map-loader" ).remove();
          }
        );
        document
          .getElementById( "rangeInput" )
          .addEventListener( "change", myFunction );
        function myFunction ()
        {
          var rangeInput = document.getElementById( "rangeInput" ).value;
          $( ".miles" ).each( function ()
          {
            if ( Math.round( rangeInput ) < Math.round( $( this ).data( "value" ) ) )
            {
              var divid = $( this ).data( "id" );
              $( "#" + divid ).hide( 350 );
            } else
            {
              var divid = $( this ).data( "id" );
              $( "#" + divid ).show( 350 );
            }
          } );
          document.getElementById( "rangedisplay" ).innerHTML =
            Math.round( rangeInput ) + setting_loc_dis_unit;
        }
      } catch ( errror ) { }
    }
  }
  if ( $( "#elementIdGlobalMaplist" ).length > 0 )
  {

    var elmap = document.getElementById( "elementIdGlobalMaplist" );

    var search_lat, search_lng;
    var infowindow = new google.maps.InfoWindow();
    var marker, i;
    if ( elmap )
    {

      elmap.addEventListener( "focus", ( e ) =>
      {
        const input = document.getElementById( "elementIdGlobalMaplist" );

        const options = {};
        const autocomplete = new google.maps.places.Autocomplete(
          input,
          options
        );
        google.maps.event.addListener( autocomplete, "place_changed", () =>
        {
          const place = autocomplete.getPlace();
          var searchedaddress = $( "#elementIdGlobalMaplist" ).val();
          search_lat = place.geometry.location.lat();
          search_lng = place.geometry.location.lng();
          for ( i = 0; i < locations.length; i++ )
          {
            if ( locations[ i ][ 4 ] == "origin" )
            {
              map = new google.maps.Map( document.getElementById( "map" ), {
                zoom: parseInt( default_zoom ),
                center: new google.maps.LatLng( search_lat, search_lng ),
                mapTypeId: google.maps.MapTypeId.ROADMAP,
              } );
              marker = new google.maps.Marker( {
                position: new google.maps.LatLng( search_lat, search_lng ),
                map: map,
                icon: icon,
                label: {
                  fontFamily: "'Font Awesome 5 Free'",
                  fontWeight: "900", //careful! some icons in FA5 only exist for specific font weights
                  color: "#FFFFFF", //color of the text inside marker
                },
              } );

              google.maps.event.addListener(
                marker,
                "click",
                ( function ( marker, i )
                {
                  return function ()
                  {
                    infowindow.setContent(
                      "<div class='locator-store-block'><h4>" +
                      searchedaddress +
                      "</h4></div>"
                    );
                    infowindow.open( map, marker );
                  };
                } )( marker )
              );
            } else
            {
              var markers = locations.map( function ( location, i )
              {
                var infowindow = new google.maps.InfoWindow( {
                  maxWidth: 250,
                } );
                var marker = new google.maps.Marker( {
                  position: new google.maps.LatLng(
                    locations[ i ][ 1 ],
                    locations[ i ][ 2 ]
                  ),
                  map: map,
                } );
                google.maps.event.addListener(
                  marker,
                  "click",
                  ( function ( marker, i )
                  {
                    return function ()
                    {
                      infowindow.setContent( locations[ i ][ 0 ] );
                      infowindow.open( map, marker );
                    };
                  } )( marker, i )
                );
                return marker;
              } );
              // // Add a marker clusterer to manage the markers.
              new MarkerClusterer( map, markers, {
                imagePath:
                  "https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m",
              } );
            }
          }
          calculate_distance_search( search_lat, search_lng );
        } );
      } );
    }
    document
      .getElementById( "rangeInput" )
      .addEventListener( "change", myFunction );
    function myFunction ()
    {
      var rangeInput = document.getElementById( "rangeInput" ).value;
      $( ".miles" ).each( function ()
      {
        if ( Math.round( rangeInput ) < Math.round( $( this ).data( "value" ) ) )
        {
          var divid = $( this ).data( "id" );
          $( "#" + divid ).hide( 350 );
        } else
        {
          var divid = $( this ).data( "id" );
          $( "#" + divid ).show( 350 );
        }
      } );

      document.getElementById( "rangedisplay" ).innerHTML =
        Math.round( rangeInput ) + setting_loc_dis_unit;
    }
  }

  //nearby map location marker code ends here
  function current_showPosition ()
  {
    // If geolocation is available, try to get the visitor's position
    if ( navigator.geolocation )
    {
      navigator.permissions
        .query( { name: "geolocation" } )
        .then( ( permissionStatus ) =>
        {
          // Don't popup error notice every time a page is visited if user has already denied location request
          if ( permissionStatus.state === "denied" )
          {
            return;
          }
          navigator.geolocation.getCurrentPosition( current_successCallback );
        } );
    }
  }

  // Define callback function for successful attempt
  function current_successCallback ( position )
  {
    /* Current Coordinate */
    const lat = position.coords.latitude;
    const lng = position.coords.longitude;
    const google_map_pos = new google.maps.LatLng( lat, lng );
    /* Use Geocoder to get address */
    const google_maps_geocoder = new google.maps.Geocoder();
    google_maps_geocoder.geocode(
      { latLng: google_map_pos },
      ( results, status ) =>
      {
        if ( status == google.maps.GeocoderStatus.OK && results[ 0 ] )
        {
          const pos_form_add = results[ 0 ].formatted_address;
          current_setLocation( pos_form_add );
        }
      }
    );
  }

  if ( autoDetect == "on" )
  {
    $( "#showMe" ).click( () =>
    {
      showPosition();
    } );
    $( ".elementIdGlobal, #elementIdGlobal" ).on( "click", function ()
    {
      $( ".wclimlocsearch" ).show();
    } );
    $( ".elementIdGlobal, #elementIdGlobal" ).on( "change", function ()
    {
      $( ".wclimlocsearch" ).hide();
    } );
    $( ".elementIdGlobal, #elementIdGlobal" ).on( "input", function ()
    {
      $( ".wclimlocsearch" ).hide();
    } );
    $( ".currentLoc" ).click( () =>
    {
      showPosition();
    } );
  }

  if ( restricted == "on" )
  {

    // $( "#select_location option:selected" ).removeAttr( 'selected' );
    if ( showLocationInRestricted == "on" )
    {
      $( ".select_location-wrapper" ).show();
      $( ".Wcmlim_container" ).show();
    } else
    {
      $( ".select_location-wrapper" ).hide();
      $( ".Wcmlim_container" ).hide();
    }
    if ( $( "body" ).hasClass( "logged-in" ) )
    {
      if ( $( "body" ).hasClass( "product-template-default" ) )
      {
        if ( sessionStorage.getItem( 'rsula' ) )
        {
          $( ".select_location-wrapper" ).show();
          $( ".Wcmlim_container" ).show();
        } else
        {
          var sll = $( "#select_location" ).val();
          var slt = $( "#select_location option:selected" ).text();
          var sltlna = slt.split( "-" );
          if ( sltlna.length > 1 )
          {
            var sltlN = sltlna[ 0 ].trim();
            var sltlS = sltlna[ 1 ].trim();
          }
          var sc = getCookie( "wcmlim_selected_location" );
          if ( sll == -1 || sll == sc )
          {
            $( `#select_location  option[value="${ sc }"]` ).prop( 'selected', true );
            var onBackOrder = $( ".stock" ).hasClass( "available-on-backorder" );
            if ( onBackOrder ) { return; }
            if ( sltlS == multi_inventory.soldout || sltlna.length == 1 )
            {
              $( ".stock" ).removeClass( "in-stock" ).addClass( "out-of-stock" );
              var lsText = `Out of stock from ${ sltlN } location`;
              if ( typeof sltlN == "undefined" )
              {
                $( ".site-content .woocommerce" ).append( `<ul class="woocommerce-error" role="alert"><li>Out of stock from ${ sltlna } location</li></ul>` );
                $( "#nm-shop-notices-wrap" ).append( `<ul class="nm-shop-notice woocommerce-error" role="alert"><li>Out of stock from ${ sltlna } location</li></ul>` );
              } else
              {
                $( ".site-content .woocommerce" ).append( `<ul class="woocommerce-error" role="alert"><li>${ lsText }</li></ul>` );
              }
              $( ".actions-button, .qty, .quantity, .single_add_to_cart_button, .add_to_cart_button, .compare, .stock" ).remove();
            }
          }
        }
      }
    } else
    {
      if ( $( "body" ).hasClass( "product-template-default" ) )
      {
        var msgForUser = sessionStorage.getItem( 'rsnlc' );
        if ( msgForUser )
        {
          $(
            ".actions-button, .qty, .quantity, .single_add_to_cart_button, .add_to_cart_button, .stock, .compare, .variations_form"
          ).remove();
          $( ".product-main" ).find( ".product-summary" ).append( msgForUser );
          $( "#nm-shop-notices-wrap" ).append( msgForUser );
          $( "#nm-shop-notices-wrap .notice" ).css( { "text-align": "center", "padding-top": "25px" } );
        }
      }
    }
  }

  function showPosition ()
  {        
    if ( navigator.userAgent.indexOf( "Safari" ) != -1 )
    {       
      if ( navigator.geolocation )
      {
        navigator.geolocation.getCurrentPosition(
          successCallback,
          showSafariBrowser
        );
      }
    } else
    {       
      // If geolocation is available, try to get the visitor's position
      if ( navigator.geolocation )
      {
        navigator.permissions
          .query( { name: "geolocation" } )
          .then( ( permissionStatus ) =>
          {
            // Don't popup error notice every time a page is visited if user has already denied location request
            if ( permissionStatus.state === "denied" )
            {
              return;
            }
            navigator.geolocation.getCurrentPosition(
              successCallback,
              errorCallback
            );
          } );
      }
    }
  }

  // Define callback function for successful attempt
  function successCallback ( position )
  {
    /* Current Coordinate */
    const lat = position.coords.latitude;
    const lng = position.coords.longitude;
    const google_map_pos = new google.maps.LatLng( lat, lng );
    /* Use Geocoder to get address */
    const google_maps_geocoder = new google.maps.Geocoder();
    google_maps_geocoder.geocode(
      { latLng: google_map_pos },
      ( results, status ) =>
      {
        if ( status == google.maps.GeocoderStatus.OK && results[ 0 ] )
        {
          const pos_form_add = results[ 0 ].formatted_address;
          setLocation( pos_form_add );
        }
      }
    );
  }

  // Show error log
  function showSafariBrowser ( error )
  {
    switch ( error.code )
    {
      case error.PERMISSION_DENIED:
        Swal.fire( {
          icon: "error",
          text: "You've decided not to share your position, but it's OK. We won't ask you again.",
        } );
        setcookie( "wcmlim_nearby_location", ' ' );
        break;
      case error.POSITION_UNAVAILABLE:
        Swal.fire( {
          icon: "error",
          text: "Location information is unavailable.",
        } );
        break;
      case error.TIMEOUT:
        Swal.fire( {
          icon: "error",
          text: "The request to get user location timed out.",
        } );
        break;
      case error.UNKNOWN_ERROR:
        Swal.fire( {
          icon: "error",
          text: "An unknown error occurred.",
        } );
        break;
    }
  }

  // Define callback function for failed attempt
  function errorCallback ( error )
  {
    if ( error.code == 1 )
    {
      Swal.fire( {
        icon: "error",
        text: "You've decided not to share your position, but it's OK. We won't ask you again.",
      } );
      setcookie( "wcmlim_nearby_location", ' ' );
      return;
    } else if ( error.code == 2 )
    {
      Swal.fire( {
        icon: "error",
        text: "The network is down or the positioning service can't be reached.You've decided not to share your position, but it's OK. We won't ask you again.",
      } );
      return;
    } else if ( error.code == 3 )
    {
      Swal.fire( {
        icon: "error",
        text: "The attempt timed out before it could get the location data.",
      } );
      return;
    } else
    {
      Swal.fire( {
        icon: "error",
        text: "Geolocation failed due to unknown error.",
      } );
      return;
    }
    localStorage.setItem( 'dialogShown', 1 );
  }

  const el = document.getElementById( "elementIdGlobal" );

  if ( el )
  {
    el.addEventListener( "focus", ( e ) =>
    {
      const input = document.getElementById( "elementIdGlobal" );
      const options = {};
      const autocomplete = new google.maps.places.Autocomplete( input, options );
      google.maps.event.addListener( autocomplete, "place_changed", () =>
      {
        const place = autocomplete.getPlace();
        lat = place.geometry.location.lat();
        lng = place.geometry.location.lng();
      } );
    } );
  }

  const le = document.getElementById( "elementId" );
  if ( le )
  {
    le.addEventListener( "focus", ( e ) =>
    {
      const input = document.getElementById( "elementId" );
      const options = {};
      const autocomplete = new google.maps.places.Autocomplete( input, options );
      google.maps.event.addListener( autocomplete, "place_changed", () =>
      {
        const place = autocomplete.getPlace();
        lat = place.geometry.location.lat();
        lng = place.geometry.location.lng();
      } );
    } );
  }
  if ( isLocationsGroup == "on" )
  {      
    const regidExists = Cookies.get( "wcmlim_selected_location_regid" );
    const termidExists = Cookies.get( "wcmlim_selected_location_termid" );
    if ( regidExists && termidExists )
    {
      $( '#wcmlim-change-sl-select' ).prop( 'disabled', true );
      $( '#wcmlim-change-lc-select' ).prop( 'disabled', true );

      $( '#wcmlim-change-sl-select option[value=' + regidExists + ']' ).prop( "selected", true );
      $.ajax( {
        type: "POST",
        url: ajaxurl,
        data: {
          selectedstoreValue: regidExists,
          action: "wcmlim_drop2_location",
        },
        dataType: "json",
        success ( data )
        {
        var location_group = '';
          $( ".wcmlim-lc-select" ).empty();
          $( ".wcmlim_lcselect" ).empty();
          var locatdata = JSON.parse( JSON.stringify( data ) );
          if ( locatdata )
          {
            $( ".wcmlim-lc-select" ).prepend(
              `<option value="-1"  >Please Select</option>`
            );
            $( ".wcmlim_lcselect" ).prepend(
              `<option value="-1"  >Please Select</option>`
            );
            $.each( data, function ( i, value )
            {
              var name = value.wcmlim_areaname;
              location_group = value.location_storeid
              if ( name == null || name == "" )
              {
                name = value.location_name;
              }
              var seled = value.selected;
              if ( seled == value.vkey )
              {
                $( "<option></option>" )
                  .attr( "value", value.vkey )
                  .text( name )
                  .attr( "class", value.classname )
                  .attr( "selected", "selected" )
                  .attr( "data-lc-storeid", value.location_storeid )
                  .attr( "data-lc-name", name )
                  .attr( "data-lc-loc", value.location_slug )
                  .attr( "data-lc-term", value.term_id )
                  .appendTo( ".wcmlim-lc-select" );
                $( "<option></option>" )
                  .attr( "value", value.vkey )
                  .text( name )
                  .attr( "class", value.classname )
                  .attr( "selected", "selected" )
                  .attr( "data-lc-storeid", value.location_storeid )
                  .attr( "data-lc-name", name )
                  .attr( "data-lc-loc", value.location_slug )
                  .attr( "data-lc-term", value.term_id )
                  .appendTo( ".wcmlim_lcselect" );
              } else
              {
                $( "<option></option>" )
                  .attr( "value", value.vkey )
                  .text( name )
                  .attr( "class", value.classname )
                  .attr( "data-lc-storeid", value.location_storeid )
                  .attr( "data-lc-name", name )
                  .attr( "data-lc-loc", value.location_slug )
                  .attr( "data-lc-term", value.term_id )
                  .appendTo( ".wcmlim-lc-select" );
                $( "<option></option>" )
                  .attr( "value", value.vkey )
                  .text( name )
                  .attr( "class", value.classname )
                  .attr( "data-lc-storeid", value.location_storeid )
                  .attr( "data-lc-name", name )
                  .attr( "data-lc-loc", value.location_slug )
                  .attr( "data-lc-term", value.term_id )
                  .appendTo( ".wcmlim_lcselect" );
              }

            } );
            $('select[name="wcmlim_change_sl_to"] option[value="'+location_group+'"]').attr("selected","selected");
            $( '#wcmlim-change-sl-select' ).removeAttr( "disabled" );
            $( '#wcmlim-change-lc-select' ).removeAttr( "disabled" );
            $( '#wcmlim-change-lcselect' ).removeAttr( "disabled" );
          }
        },
        error ( res )
        {
        // console.log( res );
        },
      } );
    }
  }

  const cookieExists = getCookie( "wcmlim_selected_location" );
  if ( cookieExists )
  {
    const cookiregid = getCookie( "wcmlim_selected_location_regid" );         
    $('select[name="wcmlim_change_sl_to"] option[value="'+cookiregid+'"]').attr("selected","selected");
    $('select[name="wcmlim_change_sl_to"]').trigger('change');
    const selectedLQ = $( "#select_location" )
      .find( "option:selected" )
      .attr( "data-lc-qty" );
    const BoS = $( "#backorderAllowed" ).val();
    if ( $( ".variation_id" ).length == 0 )
    {
      if ( BoS == 0 )
      {
        if ( selectedLQ )
        {
          document.getElementById( "lc_qty" ).value = selectedLQ;
        }
      }
    }
    const regularPrice = $( "#select_location" )
      .find( "option:selected" )
      .attr( "data-lc-regular-price" );
    const salePrice = $( "#select_location" )
      .find( "option:selected" )
      .attr( "data-lc-sale-price" );
    const svalue = $( "#select_location" ).find( "option:selected" ).text();
    const sLValue = $( "#select_location" ).find( "option:selected" ).val();
    const stockDisplay = $( "#wcstdis_format" ).val();
    $( document.body ).trigger( 'wc_fragments_refreshed' );
    const clasname = $( "#wcmlim-change-lc-select" ).find( "option:selected" ).attr( 'class' );
    $( 'body' ).removeClass( function ( index, css )
    {
      return ( css.match( /\bwclimloc_\S+/g ) || [] ).join( ' ' );
    } )
    var body = document.body;
    body.classList.add( clasname );
    let undefinedclass = $( 'body' ).hasClass( 'undefined' );
    if ( undefinedclass == true )
    {
      $( body ).removeClass( 'undefined' )
      $( body ).addClass( 'wclimloc_none' )
    }
    if ( $( "#globMsg, #losm, #seloc,#locsoldImg, #locstockImg" ).length > 0 )
    {
      $( "#globMsg, #losm, #seloc,#locsoldImg, #locstockImg" ).remove();
    }
    /**Radio option */
    if ( sLValue )
    {
      $( ".rselect_location input[name=select_location][value=" + sLValue + "]" ).prop( 'checked', true );
      $( ".rlist_location input[name=wcmlim_change_lc_to][value=" + sLValue + "]" ).prop( 'checked', true );
    }
    if ( svalue )
    {
      const selA = svalue.split( "-" );
      if ( 1 in selA )
      {
        const selS = selA[ 1 ].split( ":" );
        const stockStatus = selS[ 0 ].trim();

        if (
          !stockDisplay ||
          stockDisplay == "no_amount" ||
          stockDisplay == "low_amount"
        )
        {
          if ( stockStatus == "Out of Stock" || selectedLQ <= 1 )
          { 
          if(sLValue != '') {
            $(
              '<div id="load" style="display:none"><img src="//s.svgbox.net/loaders.svg?fill=maroon&ic=tail-spin" style="width:33px"></div>'
            ).appendTo( ".Wcmlim_nextloc_label" );
            $( "#load" ).show();
            $.ajax( {
              type: "POST",
              url: ajaxurl,
              data: {
                action: "wcmlim_closest_location",
                selectedLocationId: sLValue,
              },
              dataType: "json",
              success ( res )
              {       
                
        console.log(res); 
                
                if ( $.trim( res.status ) == "true" )
                {
                  if ( nextloc == "on" )
                  {
                    $( ".next_closest_location_detail" ).html( "" );
                    $( ".next_closest_location_detail" ).show();
                    $( "#load" ).hide();
                    $(
                      `<button id="" class="Wcmlim_accept_btn"><i class="fa fa-check"></i>Accept</button><input type="hidden" class="nextAcceptLoc" value="${ res.secNearLocKey }" />`
                    ).appendTo( ".Wcmlim_nextloc_label" );
                    $(
                      `<div id="seloc" class="selected_location_name"><i class="fa fa-dot-circle"></i>${ selA[ 0 ].trim() } <br />
                      <span class="next_km">( ` + res.fetch_origin_distance + `)</span>
                      </div>`
                    ).appendTo( ".selected_location_detail" );
                    $(
                      `<strong>` + NextClosestinStock +
                      `: <br/> ` + res.secNearLocAddress + ` <span class="next_km">( ` + res.secNearStoreDisUnit + `)</span></strong>`
                    ).appendTo( ".next_closest_location_detail" );

                    if ( $( ".Wcmlim_accept_btn" ).length )
                    {
                      $( ".Wcmlim_accept_btn" ).click( () =>
                      {
                        $( "#select_location" )
                          .val( res.secNearLocKey )
                          .trigger( "change" );
                        $( ".Wcmlim_accept_btn" ).remove();
                      } );
                    }

                    if ( $( ".postcode-location-distance" ).length )
                    {
                      $( ".postcode-location-distance" ).hide();
                    }
                  }
                }
                $( ".wclimlocsearch" ).hide();
              },
              error ( res )
              {
                $( "#load" ).hide();
              //  console.log( res );
              },
            } );
          }  
            if (
              $( "#globMsg, #losm, #seloc, #locsoldImg, #locstockImg" ).length > 0
            )
            {
              $( "#globMsg, #losm, #seloc, #locsoldImg, #locstockImg" ).remove();
            }
            // $( "<p id='losm'>" + multi_inventory.soldout + "</p>" ).insertAfter(
            //   ".Wcmlim_prefloc_sel"
            // );
            $(
              `<div id="locsoldImg" class="Wcmlim_over_stock"><i class="fa fa-times"></i>${ soldout }</div>`
            ).appendTo( ".Wcmlim_locstock" );
            $(
              ".actions-button, .qty, .quantity, .single_add_to_cart_button, .add_to_cart_button, .stock, .compare"
            ).hide();
            
            
          } else
          {
            if (
              $( "#globMsg, #losm, #seloc, #locsoldImg, #locstockImg" ).length > 0
            )
            {
              $( "#globMsg, #losm, #seloc, #locsoldImg, #locstockImg" ).remove();
            }

            if ( stockDisplay == "no_amount" )
            {
              if ( listmode != "on" || listmode == null )
              {
                $(
                  "<p id='globMsg'> " + multi_inventory.instock + "</p>"
                ).insertAfter( ".Wcmlim_prefloc_sel" );
              }
              $(
                `<div id="seloc" class="selected_location_name"><i class="fa fa-dot-circle"></i>${ selA[ 0 ].trim() }</div>`
              ).appendTo( ".selected_location_detail" );
              var kmval = $( "#product-location-distance" ).val();
              if ( kmval || kmval != '' )
              {
                $( ".postcode-location-distance" ).html(
                  `<i class="fa fa-map-marker-alt"></i> ${ kmval } ` +
                  multi_inventory.away
                );
              }
            } else
            {
              if ( $( "#locsoldImg, #locstockImg" ).length > 0 )
              {
                $( "#locsoldImg, #locstockImg" ).remove();
              }
              if ( selectedLQ )
              {
                if ( listmode != "on" || listmode == null )
                {
                  $(
                    `<p id='globMsg'><b>${ selectedLQ } </b> ` +
                    multi_inventory.instock +
                    `</p>`
                  ).insertAfter( ".Wcmlim_prefloc_sel" );
                }
                $(
                  `<div id="seloc" class="selected_location_name"><i class="fa fa-dot-circle"></i>${ selA[ 0 ].trim() }</div>`
                ).appendTo( ".selected_location_detail" );
                var kmval = $( "#product-location-distance" ).val();
                if ( kmval || kmval != '' )
                {
                  $( ".postcode-location-distance" ).html(
                    `<i class="fa fa-map-marker-alt"></i> ${ kmval } away`
                  );
                }
                $(
                  `<div id="locstockImg" class="Wcmlim_have_stock 33"><i class="fa fa-check"></i>${ instock }</div>`
                ).appendTo( ".Wcmlim_locstock" );
              }
            }
          }
        }
        if ( BoS == 0 )
        {
          if ( selectedLQ )
          {
            $( ".qty" ).attr( { max: selectedLQ } );
            document.getElementById( "lc_qty" ).value = selectedLQ;
          }
        }
      }
    }

    if ( enable_price == "on" )
    {
      if ( typeof regularPrice !== "undefined" && regularPrice.length > 9 )
      {
        const grp = extractMoney( regularPrice );
        var gpp = grp.amount;
      }
      if ( ( regularPrice || salePrice ) && gpp > 0 )
      {
        if ( salePrice.length > 9 )
        {
          $( ".price.wcmlim_product_price" ).html( `<del>${ regularPrice }</del><ins>${ salePrice }</ins>` );
        } else if ( salePrice.length == 9 )
        {
          $( ".price.wcmlim_product_price" ).html( regularPrice );
        }
        else
        {
          $( ".price.wcmlim_product_price" ).html( regularPrice );
        }
        document.getElementById( "lc_regular_price" ).value = regularPrice;
        document.getElementById( "lc_sale_price" ).value = salePrice;

      }
    }
  } else
  {
    $( 'body' ).removeClass( function ( index, css )
    {
      return ( css.match( /\bwclimloc_\S+/g ) || [] ).join( ' ' );
    }
    );
    var body = document.body;
    body.classList.add( 'wclimloc_none' );
  }
  if ( $( ".variation_id" ).length )
  {
    $( ".variation_id" ).change( () =>
    {
      $(".wcmlim_product").hide();
      if ( $( "#globMsg, #losm, #seloc, #locsoldImg, #locstockImg" ).length > 0 )
      {
        $( "#globMsg, #losm, #seloc, #locsoldImg, #locstockImg" ).remove();
      
      }
      if ( $( ".variation_id" ).val() != "" )
      {
        $( ".quantity" ).show();
        const product_id = $( "input.variation_id" ).val();
        $.ajax( {
          type: "POST",
          url: ajaxurl,
          data: {
            product_id,
            action: "wcmlim_display_location",
          },
          success ( output )
          {       
            $( "#locations_time" ).hide();
            $( ".sel_location.Wcmlim_sel_loc" ).hide();
            $( ".wcmlim-lcswitch" ).show();
            $( ".rselect_location" ).empty();
            const select = JSON.parse( output );
            if (select.show_wcmlim_product == 'hide') {
              $(".wcmlim_product").hide();
            }else{
              $(".wcmlim_product").show();
            }
            var sel_stock_status = String(select.stock_status);
            if( sel_stock_status == "outofstock")
            {
            $(".woocommerce-variation-add-to-cart.variations_button.woocommerce-variation-add-to-cart-disabled ").hide();
            }
            else
            {
              $(".woocommerce-variation-add-to-cart-enabled").show();
            }
            var size = Object.keys( select ).length;
            const pop = $( "#productOrgPrice" ).val();
            $( ".select_location" ).empty();
            var slv = jQuery( "#select_location" ).val();
            if ( !slv )
            {
              if ( $( '#losm' ).length > 0 )
              {
                $( '#losm' ).hide();
              }
              if(hideDropdown != "on"){
              $( '.qty, .single_add_to_cart_button' ).show();
              }
            }
            var locationCookie = getCookie( "wcmlim_selected_location" );
            if (locationCookie == '-1' || locationCookie == null || locationCookie == "undefined") {
              $( '.qty, .single_add_to_cart_button' ).hide();
             }
            if ( size == 1 )
            {
              $( ".select_location" ).append(
                `<option value="">- Choose an option -</option>`
              );
            }
            $( ".select_location" ).prepend(
              `<option data-lc-qty="" data-lc-sale-price="" data-lc-regular-price='${ pop }' value="-1"> - Select Location - </option>`
            );
        
            $.each( select, ( key, value ) =>
            {
              var defl = value.default_location;
              var location_name = value.text;
              var location_start_time = value.start_time;
              var location_end_time = value.end_time;
              var allow_specific_location = value.allow_specific_location;
              if (allow_specific_location == 'No') {
                var allow = 'none';
              }else{
                var allow = '';
              }
              if ( key !== "backorder" )
              { 
                $( "<option></option>" )
                  .attr( "value", key )
                  .attr( "class", value.location_class )
                  .text( value.text )
                  .attr( "data-lc-qty", value.location_qty )
                  .attr( "data-lc-address", value.location_address )
                  .attr( "data-lc-regular-price", value.regular_price )
                  .attr( "data-lc-sale-price", value.sale_price )
                  .attr( "data-lc-backorder", value.variation_backorder )
                  .attr( "data-lc-stockstatus", value.location_stock_status )
                  .attr( "location_start_time", value.start_time )
                  .attr( "location_end_time", value.end_time )
                  .css("display",allow)
                  .appendTo( ".select_location" );
              
                if ( isdefault == "on")
                {
                  if ( key == defl )
                  {
                    $( `.select_location  option[value="${ defl }"]` ).prop( 'selected', true );
                  } else
                  {
                    $( `.select_location  option[value="${ defl }"]` ).prop( 'selected', false );
                  }
                }
              }
              if ( key == "backorder" )
              {
                $( "#backorderAllowed" ).val( value );
              }
            } );
            $( ".select_location" )
              .find( "option" )
              .each( function ()
              {
                const $this = $( this );
                const cookieArr = document.cookie.split( ";" );
                // Loop through the array elements
                const locTxt = $this.text().split( "-" );
                const loc = $this.val();

                for ( let i = 0; i < cookieArr.length; i++ )
                {
                  const cookiePair = cookieArr[ i ].split( "=" );
                  /* Removing whitespace at the beginning of the cookie name
            and compare it with the given string */
                  if ( cookiePair[ 0 ].trim() == "wcmlim_selected_location" )
                  {
                    if ( decodeURIComponent( cookiePair[ 1 ].trim() ) == loc )
                    {
                      if ( isdefault != "on" && decodeURIComponent( cookiePair[ 1 ].trim() ) > -1)
                      {
                        $this.prop( 'selected', true );
                      }

                      const svalue = $( "#select_location" )
                        .find( "option:selected" )
                        .text();
                      const vlq = $( "#select_location" )
                        .find( "option:selected" )
                        .attr( "data-lc-qty" );
                      const vV = $( "#select_location" )
                        .find( "option:selected" )
                        .val();

                      const locName = svalue;
                      const selA = locName.split( "-" );
                      let OOS = "";
                      if ( selA.hasOwnProperty( 1 ) )
                      {
                        OOS = selA[ 1 ].trim();
                      }

                      if ( $( "#globMsg, #seloc" ).length )
                      {
                        $( "#globMsg, #seloc" ).remove();
                      }
                      if ( OOS == "Out of Stock" )
                      {
                        $(
                          '<div id="load" style="display:none"><img src="//s.svgbox.net/loaders.svg?fill=maroon&ic=tail-spin" style="width:33px"></div>'
                        ).appendTo( ".Wcmlim_nextloc_label" );
                        $( "#load" ).show();
                        $.ajax( {
                          type: "POST",
                          url: ajaxurl,
                          data: {
                            action: "wcmlim_closest_location",
                            selectedLocationId: vV,
                          },
                          dataType: "json",
                          success ( r )
                          {
                            
                            if ( $.trim( r.status ) == "true" )
                            {
                              if ( nextloc == "on" )
                              {
                                $( ".next_closest_location_detail" ).html( "" );
                                $( ".next_closest_location_detail" ).show();
                                $( "#load" ).hide();
                                $( ".Wcmlim_accept_btn, .nextAcceptLoc" ).remove();
                                $(
                                  `<button class="Wcmlim_accept_btn"><i class="fa fa-check"></i>Accept</button><input type="hidden" class="nextAcceptLoc" value="${ r.secNearLocKey }" />`
                                ).appendTo( ".Wcmlim_nextloc_label" );
                                $(
                                  `<strong>` + NextClosestinStock +
                                  `: <br/> ` + r.secNearLocAddress + ` <span class="next_km">(` + r.secNearStoreDisUnit + `) </span></strong>`
                                ).appendTo( ".next_closest_location_detail" );

                                if ( $( ".Wcmlim_accept_btn" ).length )
                                {
                                  $( ".Wcmlim_accept_btn" ).click( () =>
                                  {
                                    $( "#select_location" )
                                      .val( r.secNearLocKey )
                                      .trigger( "change" );
                                    $( ".Wcmlim_accept_btn" ).remove();
                                  } );
                                }

                                if ( $( ".postcode-location-distance" ).length )
                                {
                                  $( ".postcode-location-distance" ).hide();
                                }
                              }
                            }
                            $( ".wclimlocsearch" ).hide();
                          },
                          error ( r )
                          {
                            $( "#load" ).hide();
                            // console.log( r );
                          },
                        } );
                        if (
                          $(
                            "#globMsg, #losm, #seloc, #locsoldImg, #locstockImg"
                          ).length > 0
                        )
                        {
                          $(
                            "#globMsg, #losm, #seloc, #locsoldImg, #locstockImg"
                          ).remove();
                        }

                        $(
                          "<p id='losm'>" + multi_inventory.soldout + "</p>"
                        ).insertAfter( ".Wcmlim_prefloc_sel" );
                        $(
                          `<div id="locsoldImg" class="Wcmlim_over_stock"><i class="fa fa-times"></i>${ soldout }</div>`
                        ).appendTo( ".Wcmlim_locstock" );
                        $(
                          ".actions-button, .qty, .quantity, .single_add_to_cart_button, .add_to_cart_button, .stock, .compare"
                        ).hide();
                      } else
                      {
                        
                        if ( enable_price == "on" )
                        {
                          const regularPrice = $( "#select_location" )
                            .find( "option:selected" )
                            .attr( "data-lc-regular-price" );
                          let pp = 0;
                          if ( typeof regularPrice !== 'undefined' && regularPrice.length > 9 )
                          {
                            const extracted = extractMoney( regularPrice );
                            pp = extracted.amount;
                          }
                          const salePrice = $( "#select_location" )
                            .find( "option:selected" )
                            .attr( "data-lc-sale-price" );

                          if ( typeof regularPrice !== 'undefined' && regularPrice.length > 9 || typeof salePrice !== 'undefined' && salePrice.length > 9 )
                          {
                            if ( pp > 0 )
                            {
                              if ( typeof salePrice !== 'undefined' && salePrice.length > 9 )
                              {
                                $( ".price.wcmlim_product_price" ).html( `<del>${ regularPrice }</del><ins>${ salePrice }</ins>` );
                              } else
                              {
                                $( ".price.wcmlim_product_price" ).html( regularPrice );
                              }
                              document.getElementById( "lc_regular_price" ).value = regularPrice;
                              document.getElementById( "lc_sale_price" ).value = salePrice;
                            } else
                            {
                              const pOp = document.getElementById( "productOrgPrice" ).value;
                              $( ".price.wcmlim_product_price" ).empty().append( pOp );
                              document.getElementById( "lc_regular_price" ).value = "";
                              document.getElementById( "lc_sale_price" ).value = "";
                            }
                          } else
                          {
                            const pOp = document.getElementById( "productOrgPrice" ).value;
                            $( ".price.wcmlim_product_price" ).empty().append( pOp );
                          }
                        }

                        if ( typeof vlq !== 'undefined' && vlq.length > 9 )
                        {
                          $(
                            `<p id='globMsg'><b>${ vlq } </b>${ multi_inventory.instock }</p>`
                          ).insertAfter( ".Wcmlim_prefloc_sel" );
                        } else
                        {
                          const stockDisplay = $( "#wcstdis_format" ).val();
                          if ( stockDisplay == "no_amount" )
                          {
                            $( `<p id='globMsg'>${ multi_inventory.instock }</p>` ).insertAfter( ".Wcmlim_prefloc_sel" );
                          } else
                          {
                            if (vlq > 0) {
                              $( `<p id='globMsg'><b>${ vlq } </b>${ multi_inventory.instock }</p>` ).insertAfter( ".Wcmlim_prefloc_sel" );
                            }
                          }

                        }
                        
                        $(
                          `<div id="seloc" class="selected_location_name"><i class="fa fa-dot-circle"></i>${ selA[ 0 ].trim() }</div>`
                        ).appendTo( ".selected_location_detail" );
                        const kmval = $( "#product-location-distance" ).val();
                        if ( kmval || kmval != '' )
                        {
                          $( ".postcode-location-distance" ).html(
                            `<i class="fa fa-map-marker-alt"></i> ${ kmval } ` +
                            multi_inventory.away
                          );
                        }

                        if ( $( "#locstockImg" ).length > 0 )
                        {
                          $( "#locstockImg" ).remove();
                        }

                        $(
                          `<div id="locstockImg" class="Wcmlim_have_stock"><i class="fa fa-check"></i>${ instock }</div>`
                        ).appendTo( ".Wcmlim_locstock" );
                        const bOa = $( "#backorderAllowed" ).val();
                        if ( bOa == 0 )
                        {
                          $( ".qty" ).attr( { max: vlq } );
                        }
                      }
                    }
                  }
                }
              } );
            listOrdering();
            /**Radio Listing */
          },
        } );
      }else{
        $( ".quantity" ).hide();
        $( ".single_add_to_cart_button" ).hide();
      }
    } );
  }

  $( "#select_location" ).on( "change", function ( e )
  {
    if ( $( '.wclimadvlist' ).length < 1)
    {
      select_location( this );
    }
  } );
  function select_location ( e )
  {
    const selectedText = $( e ).find( "option:selected" ).text();
    const selectedValue = $( e ).find( "option:selected" ).val();
    const stockDisplay = $( "#wcstdis_format" ).val();
    const clasname = $( e ).find( "option:selected" ).attr( 'class' );
    $( 'body' ).removeClass( function ( index, css )
    {
      return ( css.match( /\bwclimloc_\S+/g ) || [] ).join( ' ' );
    } )
    var body = document.body;
    body.classList.add( clasname );
    let undefinedclass = $( 'body' ).hasClass( 'undefined' );
    if ( undefinedclass == true )
    {
      $( body ).removeClass( 'undefined' )
      $( body ).addClass( 'wclimloc_none' )
    }
    if ( selectedValue )
    {
      $( ".rselect_location input[name=select_location][value=" + selectedValue + "]" ).prop( 'checked', true );
      $( ".rlist_location input[name=wcmlim_change_lc_to][value=" + selectedValue + "]" ).prop( 'checked', true );
    }   
    
    const stockQt = $( e ).find( "option:selected" ).attr( "data-lc-qty" );
    const prId = $( ".variation_id" ).val();
    const boStatus = $( "#backorderAllowed" ).val();
    $( ".Wcmlim_loc_label" ).show();
    $( ".postcode-checker-change" ).trigger( "click" );
    $( ".postcode-location-distance" ).remove();
    if (
      $( "#globMsg, #seloc, #locsoldImg, #locstockImg, .Wcmlim_accept_btn" )
        .length > 0
    )
    {
      $(
        "#globMsg, #seloc, #locsoldImg, #locstockImg, .Wcmlim_accept_btn"
      ).remove();
    }
  
    if ( selectedText )
    {
      const selA = selectedText.split( "-" );
      if ( 1 in selA )
      {
        if (
          !stockDisplay ||
          stockDisplay == "no_amount" ||
          stockDisplay == "low_amount"
        )
        {
          if ( stockQt <= 0 && boStatus == 0 )
          {
            if ( stockQt == "" )
            {
              $( "#globMsg, #seloc, #losm" ).remove();
              $( ".Wcmlim_loc_label" ).hide();
            } else
            {
              $(
                '<div id="load" style="display:none"><img src="//s.svgbox.net/loaders.svg?fill=maroon&ic=tail-spin" style="width:33px"></div>'
              ).appendTo( ".Wcmlim_nextloc_label" );
              $( "#load" ).show();
              $.ajax( {
                type: "POST",
                url: ajaxurl,
                data: {
                  action: "wcmlim_closest_location",
                  selectedLocationId: selectedValue,
                  product_id: prId,
                },
                dataType: "json",
                success ( res )
                {
                  
                   $( "#load" ).hide();
                  if ( $.trim( res.status ) == "true" )
                  {
                    if ( nextloc == "on" )
                    {
                      $( ".next_closest_location_detail" ).html( "" );
                      $( ".next_closest_location_detail" ).show();
                      $( "#load" ).hide();
                      $(
                        `<button id="" class="Wcmlim_accept_btn"><i class="fa fa-check"></i>Accept</button><input type="hidden" class="nextAcceptLoc" value="${ res.secNearLocKey }" />`
                      ).appendTo( ".Wcmlim_nextloc_label" );
                      $(
                        `<strong>` + NextClosestinStock +
                        `: <br/> ` +res.loc_address + ` <span class="next_km">(` + res.secNearStoreDisUnit + `)</span></strong>`
                      ).appendTo( ".next_closest_location_detail" );

                      if ( $( ".Wcmlim_accept_btn" ).length )
                      {
                        $( ".Wcmlim_accept_btn" ).click( () =>
                        {
                          $( "#select_location" )
                            .val( res.loc_key )
                            .trigger( "change" );
                          $( ".Wcmlim_accept_btn" ).remove();
                        } );
                      }

                      if ( $( ".postcode-location-distance" ).length )
                      {
                        $( ".postcode-location-distance" ).hide();
                      }
                      var kmval = res.fetch_origin_distance;
                      if(kmval || kmval != '')
                      {
                        $(
                          "<div class='postcode-location-distance'> <i class='fa fa-map-marker-alt'></i>" + kmval + " </div>"
                        ).insertAfter( ".selected_location_detail" );
                        $( ".postcode-location-distance" ).show();
                      }
                    }
                  }
                  $( ".wclimlocsearch" ).hide();
                },
                error ( res )
                {
                  $( "#load" ).show();
                  // console.log( res );
                },
              } );

              if (
                $( "#globMsg, #losm, #seloc, #locsoldImg, #locstockImg" ).length > 0
              )
              {
                $( "#globMsg, #losm, #seloc, #locsoldImg, #locstockImg" ).remove();
              }

              $( "<p id='losm'>" + multi_inventory.soldout + "</p>" ).insertAfter(
                ".Wcmlim_prefloc_sel"
              );
              $(
                `<div id="seloc" class="selected_location_name"><i class="fa fa-dot-circle"></i>${ selA[ 0 ].trim() }</div>`
              ).appendTo( ".selected_location_detail" );
              $(
                `<div id="locsoldImg" class="Wcmlim_over_stock"><i class="fa fa-times"></i>${ soldout }</div>`
              ).appendTo( ".Wcmlim_locstock" );
              $(
                ".actions-button, .qty, .quantity, .single_add_to_cart_button, .add_to_cart_button"
              ).hide();
            }
          } else
          {
            if ( $( '.variation_id' ).length )
            {
              var product_id = '';
              var variation_id = $( "input.variation_id" ).val();
            }
            else
            {
              var product_id = $( ".single_add_to_cart_button" ).val();
              var variation_id = '';
            }
            const svalue = $( "#select_location" ).find( "option:selected" ).text();
            const sLValue = $( "#select_location" ).find( "option:selected" ).val();
            $(
              '<div id="load" style="display:none"><img src="//s.svgbox.net/loaders.svg?fill=maroon&ic=tail-spin" style="width:33px"></div>'
            ).appendTo( ".Wcmlim_nextloc_label" );
            $( "#load" ).show();
            $.ajax( {
              type: "POST",
              url: ajaxurl,
              data: {
                action: "wcmlim_closest_location",
                selectedLocationId: sLValue,
                product_id: product_id,
                variation_id: variation_id,
              },
              dataType: "json",
              success ( res )
              { 
                
                $( "#load" ).hide();                
                if ( $.trim( res.status ) == "true" )
                {
                  if ( nextloc == "on" )
                  {
                    $( ".next_closest_location_detail" ).html( "" );
                    $( ".next_closest_location_detail" ).show();
                    $( "#load" ).hide();
                    $(
                      `<button id="" class="Wcmlim_accept_btn"><i class="fa fa-check"></i>Accept</button><input type="hidden" class="nextAcceptLoc" value="${ res.secNearLocKey }" />`
                    ).appendTo( ".Wcmlim_nextloc_label" );
                    $(
                      `<div id="seloc" class="selected_location_name"><i class="fa fa-dot-circle"></i>${ selA[ 0 ].trim() } <br />
                      </div>`
                    ).appendTo( ".selected_location_detail" );
                    if ( $( ".Wcmlim_accept_btn" ).length > 0 )
            {
              $( ".Wcmlim_accept_btn" ).remove();
            }

                    if ( $( ".postcode-location-distance" ).length )
                    {
                      $( ".postcode-location-distance" ).hide();
                    }
                  }
                }
                $( ".wclimlocsearch" ).hide();
              },
                error ( res )
                {
                  $( "#load" ).show();
                  // console.log( res );
                },
            } );
          
            if ( $( '#losm' ).length > 0 )
            {
              $( '#losm' ).hide();
            }

            if (boStatus == 0){
              $( `<p id='globMsg'><b> ${ stockQt } </b>${ multi_inventory.instock }</p>` ).insertAfter( ".Wcmlim_prefloc_sel" );
            }
            $(
              `<div id="locstockImg" class="Wcmlim_have_stock"><i class="fa fa-check"></i>${ instock }</div>`
            ).appendTo( ".Wcmlim_locstock" );
            $(
              ".actions-button, .qty, .quantity, .single_add_to_cart_button, .add_to_cart_button, .stock, .compare"
            ).show();
          }
        }
        if ( boStatus == 0 )
        {
          if ( stockQt )
          {
            $( ".qty" ).attr( { max: stockQt } );
            document.getElementById( "lc_qty" ).value = stockQt;
          }
        }
      }
    }

    if ( enable_price == "on" )
    {
      const regularPrice = $( e )
        .find( "option:selected" )
        .attr( "data-lc-regular-price" );
      let pp = 0;
      if ( typeof regularPrice !== 'undefined' && regularPrice.length > 9 )
      {
        const extracted = extractMoney( regularPrice );
        pp = extracted.amount;
      }
      const salePrice = $( e )
        .find( "option:selected" )
        .attr( "data-lc-sale-price" );

      if ( typeof regularPrice !== 'undefined' && regularPrice.length > 9 || typeof salePrice !== 'undefined' && salePrice.length > 9 )
      {
        if ( pp > 0 )
        {
          if ( typeof salePrice !== 'undefined' && salePrice.length > 9 )
          {
            $( ".price.wcmlim_product_price" ).html( `<del>${ regularPrice }</del><ins>${ salePrice }</ins>` );
          } else
          {
            $( ".price.wcmlim_product_price" ).html( regularPrice );
          }
          document.getElementById( "lc_regular_price" ).value = regularPrice;
          document.getElementById( "lc_sale_price" ).value = salePrice;
        } else
        {
          const pOp = document.getElementById( "productOrgPrice" ).value;
          $( ".price.wcmlim_product_price" ).empty().append( pOp );
          document.getElementById( "lc_regular_price" ).value = "";
          document.getElementById( "lc_sale_price" ).value = "";
        }
      } else
      {
        const pOp = document.getElementById( "productOrgPrice" ).value;
        $( ".price.wcmlim_product_price" ).empty().append( pOp );
        document.getElementById( "lc_regular_price" ).value = "";
        document.getElementById( "lc_sale_price" ).value = "";
      }
      if ( typeof salePrice !== 'undefined' && salePrice.length > 9 )
      {
        const sale_Price = $( "#lc_sale_price" ).val();
        if ( sale_Price.length > 9 )
        {
          $( ".price.wcmlim_product_price" ).html( `<del>${ regularPrice }</del><ins>${ salePrice }</ins>` );
        } else
        {
          const reg_Price = $( "#lc_regular_price" ).val();
          if ( reg_Price == "" || sale_Price == "" )
          {
            const pOp2 = document.getElementById( "productOrgPrice" ).value;
            $( ".price.wcmlim_product_price" ).empty().append( pOp2 );
          } else
          {
            $( ".price.wcmlim_product_price" ).html( regularPrice );
          }
        }
      }
    }

    if ( boStatus == 0 )
    {
      if ( selectedValue.split( "|" )[ 3 ] == 0 )
      {
        const qty = selectedText.split( ":" );
        const updateQty = qty[ 1 ].trim();
        $( ".qty" ).attr( { max: updateQty } );
      }
    }
  }

  let loader = '<div class="wcmlim-chase-wrapper">';
  loader += '<div class="wcmlim-chase">';
  loader += '<div class="wcmlim-chase-dot"></div>';
  loader += '<div class="wcmlim-chase-dot"></div>';
  loader += '<div class="wcmlim-chase-dot"></div>';
  loader += '<div class="wcmlim-chase-dot"></div>';
  loader += '<div class="wcmlim-chase-dot"></div>';
  loader += '<div class="wcmlim-chase-dot"></div>';
  loader += "</div>";
  loader += "</div>";

  $( document ).on( "click", "#submit_postcode_product", function ( e )
  {
    e.preventDefault();     
    const postal_code = $( ".class_post_code" ).val();
    if(postal_code == ''){
      Swal.fire( {
        icon: "error",
        text: "Please Enter Location!",
      } );
      return true;
    }
    //const product_id = $( "#postal-product-id" ).val();
    if ( $( '.variation_id' ).length )
    {
      var product_id = '';
      var variation_id = $( "input.variation_id" ).val();
    }
    else
    {
      var product_id = $( ".single_add_to_cart_button" ).val();
      var variation_id = '';
    }
    const globalPin = $( "#global-postal-check" ).val();
    const BoStatus = $( "#backorderAllowed" ).val();
    if ( $( '[name="post_code"]', this ).val() == "" )
    {
      $( this ).addClass( "wcmlim-shaker" );
      setTimeout( () =>
      {
        $( ".postcode-checker" )
          .find( ".wcmlim-shaker" )
          .removeClass( "wcmlim-shaker" );
      }, 600 );
      return;
    }
    $( ".postcode-checker-response" ).html( loader );
    $.ajax( {
      url: ajaxurl,
      type: "post",
      data: {
        postcode: postal_code,
        product_id: product_id,
        variation_id: variation_id,
        globalPin,
        lat,
        lng,
        action: "wcmlim_closest_location",
      },
      dataType: "json",
      success ( response )
      {
       
        if ( $.trim( response.status ) == "true" )
        {
          $( ".postcode-checker-change" ).show();
          $( ".Wcmlim_loc_label" ).show();
          $( ".postcode-checker-div" )
            .removeClass( "postcode-checker-div-show" )
            .addClass( "postcode-checker-div-hide" );
          $( ".postcode-checker-response" ).html(
            `<i class="fa fa-search"></i> ${ postal_code }`
          );
          const glocunit = response.loc_dis_unit;
          const locationCookie = getCookie( "wcmlim_selected_location" );
          if ( locationCookie == null || locationCookie == "undefined" )
          {
            // do cookie doesn't exist stuff;
            var gLocation = response.loc_key;
            $( "#wcmlim-change-lc-select" )
              .find( ":selected" )
              .removeAttr( "selected" );
            $( ".rselect_location input[name=select_location]" ).prop( 'checked', false );
            $( ".rlist_location input[name=wcmlim_change_lc_to]" ).prop( 'checked', false );
            $( "#select_location" ).find( ":selected" ).removeAttr( "selected" );
            $( "#wcmlim-change-lc-select" )
              .find( `option[value="${ gLocation }"]` )
              .prop( "selected", true );
            $( `#select_location option[value='${ gLocation }']` ).prop(
              "selected",
              true
            );
            $( ".rselect_location input[name=select_location][value=" + gLocation + "]" ).prop( 'checked', true );
            $( ".rlist_location input[name=wcmlim_change_lc_to][value=" + gLocation + "]" ).prop( 'checked', true );
            setcookie( "wcmlim_selected_location", gLocation );
            if (
              $( "#globMsg, #seloc, #losm, #locsoldImg, #locstockImg" ).length
            )
            {
              $( "#globMsg, #seloc, #losm, #locsoldImg, #locstockImg" ).remove();
            }
            if ( $( ".Wcmlim_accept_btn" ).length > 0 )
            {
              $( ".Wcmlim_accept_btn" ).remove();
            }
            var stockDisplay = $( "#wcstdis_format" ).val();
            var optText = $(
              `#select_location option[value='${ gLocation }']`
            ).text();
            var stockQt = $( "#select_location" )
              .find( "option:selected" )
              .attr( "data-lc-qty" );
            if ( optText )
            {
              var selA = optText.split( "-" );
              if ( 1 in selA )
              {
              

                if (
                  !stockDisplay ||
                  stockDisplay == "no_amount" ||
                  stockDisplay == "low_amount"
                )
                {
                  if ( stockQt <= 0 )
                  {
                    if (
                      $( "#locsoldImg, #locstockImg, #losm, #seloc, #globMsg" )
                        .length > 0
                    )
                    {
                      $(
                        "#locsoldImg, #locstockImg, #losm, #seloc, #globMsg"
                      ).remove();
                    }
                    $(
                      "<p id='losm'>" + multi_inventory.soldout + " </p>"
                    ).insertAfter( ".Wcmlim_prefloc_sel" );
                    $(
                      `<div id="seloc" class="selected_location_name"><i class="fa fa-dot-circle"></i>${ selA[ 0 ].trim() }</div>`
                    ).appendTo( ".selected_location_detail" );
                    $(
                      ".actions-button, .qty, .quantity, .single_add_to_cart_button, .add_to_cart_button, .stock, .compare"
                    ).hide();
                  } else
                  {
                    if (
                      $( "#locsoldImg, #locstockImg, #losm, #seloc, #globMsg" )
                        .length > 0
                    )
                    {
                      $(
                        "#locsoldImg, #locstockImg, #losm, #seloc, #globMsg"
                      ).remove();
                    }

                    if ( stockDisplay == "no_amount" )
                    {
                      $(
                        "<p id='globMsg'> " + multi_inventory.instock + " </p>"
                      ).insertAfter( ".Wcmlim_prefloc_sel" );
                      $(
                        `<div id="seloc" class="selected_location_name"><i class="fa fa-dot-circle"></i>${ selA[ 0 ].trim() }</div>`
                      ).appendTo( ".selected_location_detail" );
                    } else
                    {
                      $(
                        `<p id='globMsg'><b> ${ stockQt } </b> ` +
                        multi_inventory.instock +
                        `</p>`
                      ).insertAfter( ".Wcmlim_prefloc_sel" );
                      $(
                        `<div id="seloc" class="selected_location_name"><i class="fa fa-dot-circle"></i>${ selA[ 0 ].trim() }</div>`
                      ).appendTo( ".selected_location_detail" );
                    }
                    $(
                      ".actions-button, .qty, .quantity, .single_add_to_cart_button, .add_to_cart_button, .stock, .compare"
                    ).show();
                  }
                }

                if ( BoStatus == 0 )
                {
                  if ( stockQt )
                  {
                    $( ".qty" ).attr( { max: stockQt } );
                    document.getElementById( "lc_qty" ).value = stockQt;
                  }
                }
              }
            }
            if ( stockQt <= 0 && glocunit != null )
            {
              $(
                `<div id="locsoldImg" class="Wcmlim_over_stock"><i class="fa fa-times"></i>${ soldout }</div>`
              ).appendTo( ".Wcmlim_locstock" );
              $( ".postcode-location-distance" ).show();
              $( ".postcode-location-distance" ).html(
                `<i class="fa fa-map-marker-alt"></i> ${ glocunit } ` +
                multi_inventory.away
              );
              if ( nextloc == "on" )
              {
                $( ".next_closest_location_detail" ).html( "" );
                $( ".next_closest_location_detail" ).show();
                $(
                  `<button id="" class="Wcmlim_accept_btn"><i class="fa fa-check"></i>Accept</button><input type="hidden" class="nextAcceptLoc" value="${ response.secNearLocKey }" />`
                ).appendTo( ".Wcmlim_nextloc_label" );
                $(
                  `<strong>` + NextClosestinStock +
                  `: <br/> ` + response.secNearLocAddress + ` <span class="next_km">(`+ response.secNearStoreDisUnit + `)</span></strong>`
                ).appendTo( ".next_closest_location_detail" );
                if ( $( ".Wcmlim_accept_btn" ).length )
                {
                  $( ".Wcmlim_accept_btn" ).click( () =>
                  {
                    $( "#select_location" )
                      .val( response.secNearLocKey )
                      .trigger( "change" );
                    $( ".Wcmlim_accept_btn" ).remove();
                  } );
                }
                if ( $( ".postcode-location-distance" ).length )
                {
                  $( ".postcode-location-distance" ).hide();
                }
              }
            } else if ( stockQt > 0 && glocunit != null )
            {
              $(
                `<div id="locstockImg" class="Wcmlim_have_stock"><i class="fa fa-check"></i>${ instock }</div>`
              ).appendTo( ".Wcmlim_locstock" );
              $( ".postcode-location-distance" ).show();
              $( ".postcode-location-distance" ).html(
                `<i class="fa fa-map-marker-alt"></i> ${ glocunit } ` +
                multi_inventory.away
              );
              if ( $( ".next_closest_location_detail" ).length )
              {
                $( ".next_closest_location_detail" ).hide();
              }
            } else if (
              ( stockQt == null && glocunit != null ) ||
              glocunit == null
            )
            {
              $( "#locsoldImg, #locstockImg" ).remove();
              $( ".Wcmlim_accept_btn" ).remove();
              $( ".next_closest_location_detail" ).html( "" );
              $(
                '<div id="locstockImg" class="Wcmlim_noStore">No Store Found</div>'
              ).appendTo( ".Wcmlim_messageerror" );
            } else
            {
              $( "#locsoldImg, #locstockImg" ).remove();
              $(
                '<div id="locstockImg" class="Wcmlim_noStore">Please check the location</div>'
              ).appendTo( ".Wcmlim_messageerror" );
              if ( $( ".next_closest_location_detail" ).length )
              {
                $( ".next_closest_location_detail" ).hide();
              }
            }
          } else
{ 
            var gLocation = response.loc_key;
            // if(locationCookie != $.trim(response.location)){
            $( "#wcmlim-change-lc-select" )
              .find( ":selected" )
              .removeAttr( "selected" );
            $( "#select_location" ).find( ":selected" ).removeAttr( "selected" );
            $( ".rselect_location input[name=select_location]" ).prop( 'checked', false );
            $( ".rlist_location input[name=wcmlim_change_lc_to]" ).prop( 'checked', false );
            $( "#wcmlim-change-lc-select" )
              .find( `option[value="${ gLocation }"]` )
              .prop( "selected", true );
            $( `#select_location option[value='${ gLocation }']` ).prop(
              "selected",
              true
            );
            $( ".rselect_location input[name=select_location][value=" + gLocation + "]" ).prop( 'checked', true );
            $( ".rlist_location input[name=wcmlim_change_lc_to][value=" + gLocation + "]" ).prop( 'checked', true );
            setcookie( "wcmlim_selected_location", gLocation );
            if ( isClearCart == "on" )
            {
              clearCart( e );
            }
            if (
              $( "#globMsg, #seloc, #losm, #locsoldImg, #locstockImg" ).length
            )
            {
              $( "#globMsg, #seloc, #losm, #locsoldImg, #locstockImg" ).remove();
            }
            if ( $( ".Wcmlim_accept_btn" ).length > 0 )
            {
              $( ".Wcmlim_accept_btn" ).remove();
            }
            var stockDisplay = $( "#wcstdis_format" ).val();
            var optText = $(
              `#select_location option[value='${ gLocation }']`
            ).text();
            var stockQt = $( "#select_location" )
              .find( "option:selected" )
              .attr( "data-lc-qty" );
            if ( optText )
            {
              var selA = optText.split( "-" );
              if ( 1 in selA )
              {

                if (
                  !stockDisplay ||
                  stockDisplay == "no_amount" ||
                  stockDisplay == "low_amount"
                )
                {
                  if ( stockQt <= 0 && BoStatus == 0 )
                  {
                    if (
                      $( "#globMsg, #seloc, #losm, #locsoldImg, #locstockImg" )
                        .length
                    )
                    {
                      $(
                        "#globMsg, #seloc, #losm, #locsoldImg, #locstockImg"
                      ).remove();
                    }
                    $(
                      "<p id='losm'>" + multi_inventory.soldout + "</p>"
                    ).insertAfter( ".Wcmlim_prefloc_sel" );
                    $(
                      `<div id="seloc" class="selected_location_name"><i class="fa fa-dot-circle"></i>${ selA[ 0 ].trim() }</div>`
                    ).appendTo( ".selected_location_detail" ); 
                    $(
                      ".actions-button, .qty, .quantity, .single_add_to_cart_button, .add_to_cart_button, .stock, .compare"
                    ).hide();
                  } else
                  {
                    if (
                      $( "#globMsg, #seloc, #losm, #locsoldImg, #locstockImg" )
                        .length
                    )
                    {
                      $(
                        "#globMsg, #seloc, #losm, #locsoldImg, #locstockImg"
                      ).remove();
                    }
                    if ( stockDisplay == "no_amount" )
                    {
                      $(
                        "<p id='globMsg'> " + multi_inventory.instock + " </p>"
                      ).insertAfter( ".Wcmlim_prefloc_sel" );
                      $(
                        `<div id="seloc" class="selected_location_name"><i class="fa fa-dot-circle"></i>${ selA[ 0 ].trim() }</div>`
                      ).appendTo( ".selected_location_detail" );
                    } else
                    {
                      if ( typeof stockQt == 'undefined' )
                      {
                        $( `<p id='globMsg'>${ multi_inventory.instock }</p>` ).insertAfter( ".Wcmlim_prefloc_sel" );
                      } else
                      {
                        $( `<p id='globMsg'><b> ${ stockQt } </b>${ multi_inventory.instock }</p>` ).insertAfter( ".Wcmlim_prefloc_sel" );
                      }
                      $(
                        `<div id="seloc" class="selected_location_name"><i class="fa fa-dot-circle"></i>${ selA[ 0 ].trim() }</div>`
                      ).appendTo( ".selected_location_detail" );
                      
                    }
                    $(
                      ".actions-button, .qty, .quantity, .single_add_to_cart_button, .add_to_cart_button, .stock, .compares"
                    ).show();
                  }
                }
                if ( BoStatus == 0 )
                {
                  if ( stockQt )
                  {
                    $( ".qty" ).attr( { max: stockQt } );
                    document.getElementById( "lc_qty" ).value = stockQt;
                  }
                }
              }
            }

            if ( stockQt <= 0 && glocunit != null && BoStatus == 0 )
            {
              $(
                `<div id="locsoldImg" class="Wcmlim_over_stock"><i class="fa fa-times"></i>${ soldout }</div>`
              ).appendTo( ".Wcmlim_locstock" );
              $( ".postcode-location-distance" ).show();
              $( ".postcode-location-distance" ).html(
                `<i class="fa fa-map-marker-alt"></i> ${ glocunit } ` +
                multi_inventory.away
              );
              if ( nextloc == "on" )
              {
                $( ".next_closest_location_detail" ).html( "" );
                $( ".next_closest_location_detail" ).show();
                $(
                  `<button id="" class="Wcmlim_accept_btn"><i class="fa fa-check"></i>Accept</button><input type="hidden" class="nextAcceptLoc" value="${ response.secNearLocKey }" />`
                ).appendTo( ".Wcmlim_nextloc_label" );
                $(
                  `<strong>` + NextClosestinStock +
                  `: <br/> ` + response.secNearLocAddress + `<span class="next_km">(` + response.secNearStoreDisUnit + `)</span></strong>`
                ).appendTo( ".next_closest_location_detail" );
                if ( $( ".Wcmlim_accept_btn" ).length )
                {
                  $( ".Wcmlim_accept_btn" ).click( () =>
                  {
                    $( "#select_location" )
                      .val( response.secNearLocKey )
                      .trigger( "change" );
                    $( ".Wcmlim_accept_btn" ).remove();
                  } );
                }
                if ( $( ".postcode-location-distance" ).length )
                {
                  $( ".postcode-location-distance" ).hide();
                }
              }
            } else if ( stockQt > 0 && glocunit != null )
            {
              $(
                `<div id="locstockImg" class="Wcmlim_have_stock"><i class="fa fa-check"></i>${ instock }</div>`
              ).appendTo( ".Wcmlim_locstock" );
              $( ".postcode-location-distance" ).show();

              $( ".postcode-location-distance" ).html( `<i class="fa fa-map-marker-alt"></i> ${ glocunit } ` + multi_inventory.away );
              if ( $( ".next_closest_location_detail" ).length )
              {
                $( ".next_closest_location_detail" ).hide();
              }
            } else if (
              ( stockQt == null && glocunit != null ) ||
              glocunit == null
            )
            {

              $( "#locsoldImg, #locstockImg" ).remove();
              $( ".Wcmlim_accept_btn" ).remove();
              $(
                `<div id="locstockImg" class="Wcmlim_have_stock"><i class="fa fa-check"></i>${ instock }</div>`
              ).appendTo( ".Wcmlim_locstock" );
            } else
            {
              $( "#locsoldImg, #locstockImg" ).remove();
              if ( $( ".next_closest_location_detail" ).length )
              {
                $( ".next_closest_location_detail" ).hide();
              }
            }
          }
        }
          var postcode = $('.class_post_code').val();              
         if(gLocation == null){
          $('<div id="locstockImg" class="Wcmlim_noStore"><b>No location Near '+ postcode +'</b> </div>' ).appendTo( ".Wcmlim_messageerror" );
        }
        $( ".wclimlocsearch" ).hide();
      },
      error: function ( data, textStatus, errorThrown )
      {
        $( ".postcode-checker-response" ).empty();
      },
    } ).done( ( response ) =>
    {
      // if bacorder not allowed update max value of quantity field
      if ( response.backorder === false )
      {
        const stockAvailabe = response.stock_in_location;
        $( ".qty" ).attr( { max: stockAvailabe } );
      }
    } );
  } );

  /**
   * Pincode change.
   */
  $( document ).on( "click", "[data-wpzc-form-open]", ( e ) =>
  {
    e.preventDefault();
    $( ".class_post_code" ).val( "" );
    $( ".postcode-checker-change" ).hide();
    $( ".postcode-location-distance" ).hide();
    $( ".postcode-checker-div" )
      .removeClass( "postcode-checker-div-hide" )
      .addClass( "postcode-checker-div-show" );
    $( ".postcode-checker-response" ).empty();
  } );
  if ( $( "#wcmlim-change-lcselect" ).length > 0 && isLocationsGroup == "on" )
  {
    $( ".wcmlim-lcswitch" ).delegate(
      "#wcmlim-change-lcselect",
      "change",
      function ( e )
      {
        $( "#select_location" ).find( ":selected" ).removeAttr( "selected" );
        const get_loc = $( this ).find( "option:selected" ).val();
        $( `#select_location option[value='${ get_loc }']` ).prop(
          "selected",
          true
        );
        setcookie( "wcmlim_selected_location", get_loc );
        const get_term2 = $( this ).find( "option:selected" ).attr( 'data-lc-term' );
        setcookie( "wcmlim_selected_location_termid", get_term2 );
        const get_regID = $( this ).find( "option:selected" ).attr( 'data-lc-storeid' );
        setcookie( "wcmlim_selected_location_regid", get_regID );
        select_location( "#select_location" );
      }
    );
  }
  if ( $( "#wcmlim-change-lc-select" ).length > 0 )
  {
    $( ".wcmlim-lc-switch" ).delegate(
      "#wcmlim-change-lc-select",
      "change",
      function ( e )
      {
          if ( isClearCart == "on" )
          {
            var e_value = $( e.target ).val();
            jQuery(this).find('option[jsselect]').removeAttr("jsselect");
            jQuery(this).find('option[value="' + e_value + '"]').attr("jsselect", "jsselect");
  
            $( '.single_add_to_cart_button' ).prop( "disabled", true );
            $( ".wcmlim_cart_valid_err" ).remove();
            $( "<div class='wcmlim_cart_valid_err'><center><i class='fas fa-spinner fa-spin'></i></center></div>" ).insertAfter( ".Wcmlim_loc_label" );
            $( document.body ).trigger( 'wc_fragments_refreshed' );
          $.ajax( {
            type: "POST",
            url: ajaxurl,
            data: {
              action: "wcmlim_ajax_cart_count",
            },
            success ( res )
            {
              e.preventDefault();
              var ajaxcartcount = JSON.parse( JSON.stringify( res ) );
              const value = $( e.target ).val();
              const cck_selected_location = getCookie( "wcmlim_selected_location" );
              if ( ajaxcartcount != 0 )
              {
                if ( cck_selected_location != '' || cck_selected_location != null )
                {
                  if ( cck_selected_location != value )
                  {

                    $( '.single_add_to_cart_button' ).prop( "disabled", true );
                    $( ".wcmlim_cart_valid_err" ).remove();
                    $( "<div class='wcmlim_cart_valid_err'>" + multi_inventory.swal_cart_validation_message + "<br/><button type='button' class='wcmlim_validation_clear_cart'>" + multi_inventory.swal_cart_update_btn + "</button></div>" ).appendTo( ".er_location" );
                    $( "#select_location" ).find( ":selected" ).removeAttr( "selected" );
                    $( ".rselect_location input[name=select_location]" ).prop( 'checked', false );
                    $( ".rlist_location input[name=wcmlim_change_lc_to]" ).prop( 'checked', false );
                    $( "#select_location option[value=" + value + "]" ).prop( 'selected', true );
                    $( ".rselect_location input[name=select_location][value=" + value + "]" ).prop( 'checked', true );
                    $( ".rlist_location input[name=wcmlim_change_lc_to][value=" + value + "]" ).prop( 'checked', true );
                    $( "#select_location" ).val( value ).trigger( 'change' );
                  }
                  else
                  {
                    $( ".wcmlim_cart_valid_err" ).remove();
                    $( '.single_add_to_cart_button' ).prop( "disabled", false );
                    $( "#wcmlim-change-lc-select" ).closest( "form" ).submit();
                  }
                }
              } else
              {
                setcookie( "wcmlim_selected_location", value );
                $( ".wcmlim_cart_valid_err" ).remove();
                $( '.single_add_to_cart_button' ).prop( "disabled", false );
                $( "#wcmlim-change-lc-select" ).closest( "form" ).submit();
                window.location.href = window.location.href;
              }
            },
          } );

        } else
        {
          $( this ).closest( "form" ).submit();
        }
        if ( isLocationsGroup == "on" )
        {
          const get_regID = $( this ).find( "option:selected" ).attr( 'data-lc-storeid' );
          setcookie( "wcmlim_selected_location_regid", get_regID );
        } else
        {
          const get_regID = -1;
          setcookie( "wcmlim_selected_location_regid", get_regID );
        }
        const get_termID = $( this ).find( "option:selected" ).attr( 'data-lc-term' );
        setcookie( "wcmlim_selected_location_termid", get_termID );
      }
    );
  }

  if ( $( ".wcmlim_locwid_dd" ).length > 0 )
  {
    // console.log( "widget exists" );
    if ( widget_select_type == "simple" )
    {
      $( ".WCMLIM_Widget" ).delegate( ".wcmlim_locwid_dd", "change", function ()
      {
        var se = $( this ).closest( "select" ).val();
        setcookie( "wcmlim_widget_chosenlc", se );
        $( this ).closest( "form" ).submit();
      } );
    }

    if ( widget_select_type == "multi" )
    {
      $( ".wcmlim_locwid_dd option[value='-1']" ).remove();
      $( ".wcmlim_locwid_dd" ).chosen( { width: "100%" } );
      $( ".wcmlim_submit_location_form" ).click( function ()
      {
        var sem = $( ".wcmlim_locwid_dd" ).val();
        setcookie( "wcmlim_widget_chosenlc", sem );
        $( this ).closest( "form" ).submit();
      } );

      $( ".wcmlim_reset_location_form" ).click( function ()
      {
        $( ".wcmlim_locwid_dd" ).find( "option:selected" ).remove().end();
        $( this ).closest( "form" ).submit();
      } );
    }
  }

  if ( $( ".class_post_code" ).val() )
  {
    $( ".postcode-checker-change" ).show();
    $( ".postcode-checker-div" )
      .removeClass( "postcode-checker-div-show" )
      .addClass( "postcode-checker-div-hide" );
    $( ".postcode-checker-response" ).html(
      `<i class="fa fa-search"></i>${ $( ".class_post_code" ).val() }`
    );
  }

  if ( $( ".class_post_code_global" ).val() )
  {
    $( ".postcode-checker-change" ).show();
    $( ".postcode-checker-div" )
      .removeClass( "postcode-checker-div-show" )
      .addClass( "postcode-checker-div-hide" );
    $( ".postcode-checker-response" ).html(
      `<i class="fa fa-search"></i>${ $( ".class_post_code_global" ).val() }`
    );
  }

  function setcookie ( name, value, days )
  {
    let date = new Date();
    if ( days )
    {
      date.setTime( date.getTime() + days * 24 * 60 * 60 * 1000 );
      var expires = `; expires=${ date.toUTCString() }`;
    } else
    {
      date.setTime( date.getTime() + 1 * 24 * 60 * 60 * 1000 );
      var expires = `; expires=${ date.toUTCString() }`;
    }
    document.cookie = `${ name }=${ value }${ expires };path=/`;
  }

  function getCookie ( name )
  {
    const dc = document.cookie;
    const prefix = `${ name }=`;
    let begin = dc.indexOf( `; ${ prefix }` );
    if ( begin == -1 )
    {
      begin = dc.indexOf( prefix );
      if ( begin != 0 ) return null;
    } else
    {
      begin += 2;
      var end = document.cookie.indexOf( ";", begin );
      if ( end == -1 )
      {
        end = dc.length;
      }
    }
    // because unescape has been deprecated, replaced with decodeURI
    // return unescape(dc.substring(begin + prefix.length, end));
    return decodeURI( dc.substring( begin + prefix.length, end ) );
  }

  $( document ).on( "click", "#submit_postcode_global", function ( e )
  {
    e.preventDefault();
   
    var val = $( this ).closest( "div.wcmlim_form_box" ).find( "input[name='post_code_global']" ).val();
    if ( val )
    {      
      setLocation( val );
    } else
    {      
      setLocation();
    }
  } );

  function setLocation ( address )
  {     
    if ( address )
    {      
      var postal_code = address;
    } else
    {
      var postal_code = $( ".class_post_code_global" ).val();
    }
    const globalPin = $( "#global-postal-check" ).val();

    if ( $( '[name="post_code_global"]', this ).val() == "" )
    {
      $( this ).addClass( "wcmlim-shaker" );
      setTimeout( () =>
      {
        $( ".postcode-checker" )
          .find( ".wcmlim-shaker" )
          .removeClass( "wcmlim-shaker" );
      }, 600 );
      return;
    }
    $( ".postcode-checker-response" ).html( loader );
    $.ajax( {
      url: ajaxurl,
      type: "post",
      data: {
        postcode: postal_code,
        globalPin,
        lat,
        lng,
        action: "wcmlim_closest_location",
      },
      dataType: "json",
      success ( response )
      {
        setcookie( "wcmlim_selected_location", response.loc_key );         
        setcookie( "wcmlim_selected_location_regid",  response.secgrouploc  );   
        $('select[name="wcmlim_change_sl_to"] option[value="'+response.secgrouploc+'"]').attr("selected","selected");
        $('select[name="wcmlim_change_sl_to"]').trigger('change');

        if ( $.trim( response.status ) === "true" )
        {          
          var dunit = response.loc_dis_unit;
          if ( dunit !== null )
          {
            var spu = dunit.split( " " );
            var n = spu[ 0 ];
          }
          if ( response.locServiceRadius != '' )
          {            
            if ( response.locServiceRadius <= n || !n )
            {
              if ( response.cookie != "" )
              {
                Swal.fire( {
                  title: "Oops...!",
                  text: "We are not serving this area...",
                  icon: "info",
                  timer: 2000,
                  showConfirmButton: false
                } ).then( function ()
                {
                  $( "#lc-switch-form" ).submit();
                } );
              }
              else	
              {
                $( ".postcode-checker-response" ).html();
              }

            }
          } else
          {            
            $( ".postcode-checker-change" ).show();
            $( ".postcode-checker-div" )
              .removeClass( "postcode-checker-div-show" )
              .addClass( "postcode-checker-div-hide" );
            if ( address )
            {
              $( ".postcode-checker-response" ).html(
                `<i class="fa fa-search"></i> ${ address }`
              );
            } else
            {
              $( ".postcode-checker-response" ).html(
                `<i class="fa fa-search"></i> ${ postal_code }`
              );
            }
            const locationCookie = getCookie( "wcmlim_selected_location" );
           
            if ( locationCookie == null )
            {
              /* do cookie doesn't exist stuff; */
              var gLocation = response.loc_key;
              $( "#wcmlim-change-lc-select" )
                .find( ":selected" )
                .removeAttr( "selected" );
              $( ".rselect_location input[name=select_location]" ).prop( 'checked', false );
              $( ".rlist_location input[name=wcmlim_change_lc_to]" ).prop( 'checked', false );
              $( "#select_location" ).find( ":selected" ).removeAttr( "selected" );
              $( "#wcmlim-change-lc-select" )
                .find( `option[value="${ gLocation }"]` )
                .prop( "selected", true );
              $( `#select_location option[value='${ gLocation }']` ).prop(
                "selected",
                true
              );
              $( ".rselect_location input[name=select_location][value=" + gLocation + "]" ).prop( 'checked', true );
              $( ".rlist_location input[name=wcmlim_change_lc_to][value=" + gLocation + "]" ).prop( 'checked', true );
              setcookie( "wcmlim_selected_location", gLocation );
              $( "#lc-switch-form" ).submit();
            } else
            {
              // if(locationCookie != $.trim(response.location)){
              var gLocation = response.loc_key;
              $( "#wcmlim-change-lc-select" )
                .find( ":selected" )
                .removeAttr( "selected" );
              $( "#select_location" ).find( ":selected" ).removeAttr( "selected" );
              $( ".rselect_location input[name=select_location]" ).prop( 'checked', false );
              $( ".rlist_location input[name=wcmlim_change_lc_to]" ).prop( 'checked', false );
              $( "#wcmlim-change-lc-select" )
                .find( `option[value="${ gLocation }"]` )
                .prop( "selected", true );
              $( `#select_location option[value='${ gLocation }']` ).prop(
                "selected",
                true
              );
              $( ".rselect_location input[name=select_location][value=" + gLocation + "]" ).prop( 'checked', true );
              $( ".rlist_location input[name=wcmlim_change_lc_to][value=" + gLocation + "]" ).prop( 'checked', true );
         
            }
          }
        }
        $( ".wclimlocsearch" ).hide();
      },
      error: function ( data, textStatus, errorThrown )
      {
        $( ".postcode-checker-response" ).empty();
      },
    } ).done( ( response ) =>
    {
      // if bacorder not allowed update max value of quantity field
      if ( response.backorder === false )
      {
        const stockAvailabe = response.stock_in_location;
        $( ".qty" ).attr( { max: stockAvailabe } );
      }
    } );
  }

  function clearCart ( e )
  {
    $( '.single_add_to_cart_button' ).prop( "disabled", true );
    $( ".wcmlim_cart_valid_err" ).remove();
    $( "<div class='wcmlim_cart_valid_err'><center><i class='fas fa-spinner fa-spin'></i></center></div>" ).insertAfter( ".Wcmlim_loc_label" );
    $( document.body ).trigger( 'wc_fragments_refreshed' );
    $.ajax( {
      type: "POST",
      url: ajaxurl,
      data: {
        action: "wcmlim_ajax_cart_count",
      },
      success ( res )
      {
        var ajaxcartcount = JSON.parse( JSON.stringify( res ) );
        var value = $( e.target ).val();
        var cck_selected_location = getCookie( "wcmlim_selected_location" );
        if ( ajaxcartcount != 0 )
        {
          if ( cck_selected_location != '' || cck_selected_location != null )
          {
            if ( cck_selected_location != value )
            {
              $( '.single_add_to_cart_button' ).prop( "disabled", true );
              $( ".wcmlim_cart_valid_err" ).remove();
              $( "<div class='wcmlim_cart_valid_err'>" + multi_inventory.swal_cart_validation_message + "<br/><button type='button' class='wcmlim_validation_clear_cart'>" + multi_inventory.swal_cart_update_btn + "</button></div>" ).insertBefore( "#lc_regular_price" );
            }
            else
            {
              $( ".wcmlim_cart_valid_err" ).remove();
              $( '.single_add_to_cart_button' ).prop( "disabled", false );
            }
          }
        } else
        {
          $( ".wcmlim_cart_valid_err" ).remove();
          $( '.single_add_to_cart_button' ).prop( "disabled", false );
        }
      },
    } );
  }

  $( 'input[type=radio][name=select_location]' ).change( function ()
  {

    var stockQt = $( "#select_location" )
      .find( "option:selected" )
      .attr( "data-lc-qty" );
    var text_qty = document.getElementsByClassName( "qty" )[ 0 ].value;

    const boStatus = $( "#backorderAllowed" ).val();
    if (boStatus != 1){
    if ( stockQt < text_qty )
    {
      $( ".qty" ).attr( { max: stockQt } );
      document.getElementById( "lc_qty" ).value = stockQt;
      document.getElementsByClassName( "qty" )[ 0 ].value = 1;
    }
    else
    {
      $( ".qty" ).attr( { max: stockQt } );
      document.getElementById( "lc_qty" ).value = stockQt;
    }
  }
  } );

  $("#select_location").on( "change", function ()
  {
    
    var addcartid = $(this).data("lc-id");
    var term_key = $(this).val();
    var product_simple = $(this).find(':selected').data("lc-prod-id");
    var product_vid = $( "input.variation_id" ).val();
    var prodsaleprice = $(this).find(':selected').data("lc-sale-price");
    var prodcity = $(this).find(':selected').data("lc-city");
    var productprice = productprice ? prodregularprice : prodsaleprice ;
    var product_qty = $(".qty").val();
    var prodregularprice = $(this).find(':selected').data("lc-regular-price");
    
    var prod_backorder =  $(this).find(':selected').data("lc-backorder");
   
    if(multi_inventory.isBackorderOn == "on"){
      $("#globMsg").hide();
      $("#losm").hide();
      $.ajax( {
          url: multi_inventory.ajaxurl,
          type: "post",
          data: {
            action: "wcmlim_backorder4el",
            'term_key': term_key,
            'addcartid' : addcartid,
            'prodregularprice' : prodregularprice,
            'prodsaleprice' : prodsaleprice,
            'productprice' : productprice,
            'product_qty' : product_qty,
            'prodcity' : prodcity,
            'product_vid' : product_vid,        
            'product_simple' : product_simple,
            
            },
        
            success ( response )
            {
              if(response == "show_btn" || prod_backorder == "yes")
              {
                $(".single_add_to_cart_button").show();
                $(".single_add_to_cart_button").removeClass("disabled");
                $(".input-text").show();
                $(".quantity").show();
                $(".qty").removeAttr("max");
                $("#losm").hide();
                $(".stock").hide();
                $("#globMsg").hide();
                
            }else{
              
              console.log(response);
              if(response == "ofs"){
                $(".single_add_to_cart_button").addClass("disabled");

              $("#losm").show();
              }
              if(response == "instk"){
                $("#losm").hide();
                $(".stock").show();
                $("#globMsg").show();
              }else{
                $("#globMsg").show();
              }
            }
            }
            });
          }
      });

     
      $("#select_location").trigger("change");
      // allow specific location 
      if(multi_inventory.specific_location == "on"){
        $("#select_location").val("-1");
      }
      

      // hide location dropdwon variation 
 
      $(document).ready(function() {
        setTimeout(function() {
          if(jQuery('.variations').length > 0)
      {
        $( '.variations' ).trigger("click");
        
      }
        }, 2000);
      });

  if(hideDropdown == "on"){
      $( document ).on( "click", ".variations", function ( e )
      {
        e.preventDefault();
        $( ".in-stock").hide();
        $( ".qty, .quantity").hide();
        $( ".single_add_to_cart_button" ).hide();
        $( ".losm").hide();

      var locationCookie = getCookie( "wcmlim_selected_location_termid" );
       var product_id = $( "input.variation_id" ).val();
           if(locationCookie != '' && product_id != '0' && product_id != '')
               {
                  $.ajax( {
               url: multi_inventory.ajaxurl,
               type: "POST",
               data: {
                   action: 'action_variation_dropdown',
                   'locationCookie':locationCookie,
                   'product_id':product_id,
                   
                 },
               success (response){
               if(response > 0){
                $( ".single_add_to_cart_button").show();
                $( ".qty, .quantity").show();
                $( ".in-stock").show();
                $( ".losm").hide();
               }else{
                $( ".single_add_to_cart_button" ).hide();
                $( ".qty, .quantity, .in-stock").hide();
                if ($( "#losm" ).length > 0)
                {
                  $( "#losm" ).remove();
                }
                $( "<p id='losm'>" + multi_inventory.soldout + "</p>" ).insertAfter( ".variation_id" );
               }
                
             }
             } );
               }
      } );
    }
      // code -end
 } );
