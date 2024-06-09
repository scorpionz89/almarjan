<?php
/**
 * Template Welcome
 *
 *
 * @package bighearts\core\dashboard
 * @author WebGeniusLab <webgeniuslab@gmail.com>
 * @since 1.0.0
 */

if (!class_exists('TGMPA_List_Table')) {
    return;
}

$plugin_table = new TGMPA_List_Table();

wp_clean_plugins_cache(false);

?>
<div class="wgl-tgmpa_dashboard tgmpa wrap">

    <?php $plugin_table->prepare_items(); ?>

    <?php $plugin_table->views(); ?>

    <form id="tgmpa-plugins" action="<?php echo esc_url(admin_url( 'themes.php?page=tgmpa-install-plugins' )); ?>" method="post">
        <input type="hidden" name="tgmpa-page" value="tgmpa-install-plugins" />
        <input type="hidden" name="plugin_status" value="<?php echo esc_attr( $plugin_table->view_context ); ?>" />
        <?php $plugin_table->display(); ?>
    </form>
</div>
