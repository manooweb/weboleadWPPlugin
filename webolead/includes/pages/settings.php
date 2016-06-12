<?php
/*
 * WebOLead Settings page
 * 
 */
?>
<div class="wrap">
    <h2><span class="dashicons dashicons-admin-comments"></span> <?php echo __('WebOLead', 'webolead') ?></h2>
    <?php settings_errors('wol_webolead_siteid_number'); ?>
    <form action="options.php" method="post">
        <?php
        settings_fields('wol_webolead_options');
        do_settings_sections('webolead');
        ?>
        <input type="submit" name="save" value="<?php _e('Save settings', 'webolead'); ?>" class="button-primary">
    </form>
</div>
