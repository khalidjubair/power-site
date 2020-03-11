<?php

namespace PowerSiteBuilder\Admin\Menu;
/**
 * Dashboard main template
 */

defined( 'ABSPATH' ) || die();
 
$tabs = Init::get_tabs(); 

?>

<div class="psb-wrapper">
    <div class="power-dashboard-panel">
        <form action="" method="POST" id="psb-admin-action-form" enctype="multipart/form-data">
            <?php foreach($tabs as $key=>$value):
                if ( empty( $value['render'] ) || ! is_callable( $value['render'] ) ) {
                    continue;
                }
                
                $slug = @$_GET['admin_tab'];
                
                if($slug === esc_attr( strtolower( $key ) ))
                    Init::render_tabs($slug);

            endforeach; ?>
            <button class="psb-admin-action-form-submit"><div class="power-spinner"></div><?php esc_html_e('Save Changes', 'power-site-builder'); ?></button>
        </form>
    </div>
</div>