<?php
namespace PowerSiteBuilder\Admin;

/**
 * Dashboard widgets tab template
 */

defined( 'ABSPATH' ) || die();


$widgets_map = Widgets::widgets_map(); 
$active_widgets = Widgets::active_widgets();

?>
<h2>Our widget</h2>
<div class="power-dashboard-widget">

  <?php foreach($widgets_map as $key=>$value):
    
    $checked = 'checked="checked"';
    if ( !in_array( $key, $active_widgets ) ) {
        $checked = '';
    } ?>

      <div class="power-dashboard-widget-item">

          <i class="<?php echo $value['icon']; ?>"></i>
          <h3><?php echo $value['title']; ?></h3>
          <?php if($value['demo'] != ''){ ?>
            <a href="<?php echo esc_url($value['demo']);?>" target="_blank" class="power-demo-link"><?php esc_html_e('Demo', 'power-site-builder');?></a>
          <?php } ?>
          <label class="switch">
            <input id="power-toggle-<?php echo $key; ?>" <?php echo $checked; ?>
            type="checkbox" value="<?php echo $key; ?>" 
            name="widget_list[]" 
            value="inactive">
            
            <span class="slider round"></span>
          </label>
      </div>
  <?php endforeach; ?>
    <div class="clearfix"></div>
</div>