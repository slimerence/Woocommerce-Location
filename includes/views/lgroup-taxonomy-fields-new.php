<div class="form-field term-Regional-wrap">
      <label class="" for="wcmlim_email_regmanager"><?php esc_html_e('Email', 'wcmlim'); ?></label>
      <input class="form-control" id="wcmlim_email_regmanager" name="wcmlim_email_regmanager" type="text" /> 
</div> 
<div class="form-field term-Regional-wrap">
<label class="" for="location"><?php esc_html_e('Location', 'wcmlim'); ?></label>  
  <?php 
  $location_mange = array(
    'taxonomy'     => 'locations',
    'show_option_none'  => 'Please Select',
    'hide_empty'        => 0,
    'value_field'       => 'term_id',
    'name'              => 'wcmlim_location',
    'id'                => 'location',
    'class'             => 'form-control',
    'orderby'           => 'id',
    'selected'          => 0,
  );
  wp_dropdown_categories($location_mange);
  ?>
</div>

<?php $esp = get_option("wcmlim_assign_location_shop_manager");
if ($esp == "on") { ?>
  <div class="form-field term-Regional-wrap">
    <label class="" for="wcmlim_shop_regmanager"><?php esc_html_e('Location Regional Manager', 'wcmlim'); ?></label>
    <select multiple="multiple" class="multiselect" name="wcmlim_shop_regmanager[]" id="wcmlim_shop_regmanager">
      <?php
      $args = [
        'role' => 'location_regional_manager'
      ];
      $all_users = get_users($args);
      foreach ((array) $all_users as $key => $user) {
      ?>
        <option value="<?php esc_html_e($user->ID); ?>"><?php esc_html_e($user->display_name); ?></option>
      <?php } ?>
    </select>
  </div>
<?php } ?>

