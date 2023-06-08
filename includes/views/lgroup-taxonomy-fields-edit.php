<table class="form-table" role="presentation">
  <tbody>
    <?php
  
   ?>
  <tr class="form-field term-c-wrap">
      <th>
      <label class="" for="location"><?php esc_html_e('Location', 'wcmlim'); ?></label>
      </th>    
      <td>
      <?php 

       $wcmlim_location = get_term_meta( $term->term_id , 'wcmlim_location', true);
         $location_mange = array(
          'taxonomy'     => 'locations',
          'show_option_none'  => 'Please Select',
          'hide_empty'        => 0,
          'value_field'       => 'term_id',
          'name'              => 'wcmlim_location',
          'id'                => 'location',
          'class'             => 'form-control',
          'orderby'           => 'id',
          'selected'          => $wcmlim_location,
        );
          wp_dropdown_categories($location_mange);  
         
          ?>  
          </td> 
  </tr>
    <?php $wcmlim_email_regmanager = get_term_meta( $term->term_id, 'wcmlim_email_regmanager', true ); ?> 
  <tr class="form-field term-c-wrap">
      <th>
        <label class="" for="wcmlim_email_regmanager"><?php esc_html_e('Email', 'wcmlim'); ?></label>
      </th>    
      <td>
      <input class="form-control" id="wcmlim_email_regmanager" name="wcmlim_email_regmanager" type="text" value="<?php echo esc_attr( $wcmlim_email_regmanager ) ?>" /> 
      </td> 
  </tr>
    <?php $espe = get_option("wcmlim_assign_location_shop_manager");    
    if ($espe == "on") { ?>
      <tr class="form-field term-c-wrap">
        <th>
          <label class="" for="wcmlim_shop_regmanager"><?php esc_html_e('Location Regional Manager', 'wcmlim'); ?></label>
        </th>
        <td>
          <select multiple="multiple" class="multiselect" name="wcmlim_shop_regmanager[]" id="wcmlim_shop_regmanager">
            <?php
            $args = ['role' => 'location_regional_manager'];
            $all_users = get_users($args);
            foreach ((array) $all_users as $key => $user) {
            ?>
              <option value="<?php esc_html_e($user->ID); ?>" <?php if (!empty($groupshopManager)) {
                                                                if (in_array($user->ID, $groupshopManager)) {
                                                                  echo "selected='selected'";
                                                                }
                                                              }
                                                              ?>><?php esc_html_e($user->display_name); ?></option>
            <?php } ?>
          </select>
        </td>
      </tr>
    <?php } ?>  
  </tbody>
</table>
