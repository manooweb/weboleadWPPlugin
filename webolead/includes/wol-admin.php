<?php

class Wol_Admin {

    public function __construct() {
        add_action('admin_menu', array($this, 'wol_admin_menu'));
        add_action('admin_init', array($this, 'wol_register_options'));
        add_action('admin_enqueue_scripts', array($this, 'wol_admin_style'));
        load_plugin_textdomain('webolead', false, 'webolead/languages');
    }

    public function wol_admin_style() {
        wp_enqueue_style('admin-styles', plugins_url('/css/wol-admin.css', __FILE__));
    }

    public function wol_admin_menu() {
        add_menu_page(__('WebOLead Settings', 'webolead'), 'WebOLead', 'manage_options', 'webolead', array($this, 'wol_settings_page'), 'dashicons-admin-comments'
            , 85.00001);
    }

    public function wol_register_options() {
        register_setting('wol_webolead_options', 'wol_webolead_options', array($this, 'wol_webolead_validate_options'));
    }

    public function wol_settings_page() {
        add_settings_section('wol_webolead_main', __('WebOLead Settings', 'webolead'), array($this, 'wol_webolead_siteid'), 'webolead');
        add_settings_field('wol_webolead_siteid_number', __('WebOLead site id :', 'webolead'), array($this, 'wol_webolead_siteid_input'), 'webolead', 'wol_webolead_main');
        add_settings_section('wol_webolead_example', __('WebOLead script example', 'webolead'), array($this, 'wol_webolead_example'), 'webolead');
        include(plugin_dir_path(__FILE__) . '/pages/settings.php');
    }

    public function wol_webolead_siteid() {
        echo '<p>' . __('Enter your WebOLead site Id here.', 'webolead') . '</p>';
    }

    public function wol_webolead_example() {
        echo '<p>' . __('You can find WebOLead site id in WebOLead script as in this example below', 'webolead') . '</p>';
        $wolScript = file_get_contents(plugin_dir_path(__FILE__) . '/wol-script/webolead-script.php');
        $wol_webolead_options = get_option('wol_webolead_options');
        $wol_site_id = $wol_webolead_options['siteid_number'];
        if (empty($wol_site_id) || !is_numeric($wol_site_id)) {
            $wol_site_id = "999";
        } else {
            echo str_replace('{{siteId}}', $wol_site_id, $wolScript);
        }
        echo "<pre>" . str_replace('{{siteId}}', '<span class="wolSiteId">' . $wol_site_id . '</span>', htmlspecialchars($wolScript, ENT_NOQUOTES)) . "</pre>";
    }

    public function wol_webolead_siteid_input() {
        $options = get_option('wol_webolead_options');
        if (empty($options)) {
            $options['siteid_number'] = "";
        }
        echo '<input id="" type="text" name="wol_webolead_options[siteid_number]" value="' . $options['siteid_number'] . '">';
    }

    public function wol_webolead_validate_options($input) {
        if (! is_numeric($input['siteid_number']) && trim($input['siteid_number']) != '' ){
            add_settings_error('wol_webolead_siteid_number', 'wol_webolead_siteid_number_error', __('WebOLead site id must be numeric', 'webolead'), 'error');
        } else {
            add_settings_error('wol_webolead_siteid_number', 'wol_webolead_siteid_number_error', __('WebOLead site id is updated', 'webolead'), 'updated');
        }
        return $input;
    }

}
