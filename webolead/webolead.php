<?php

/*
  Plugin Name: WebOLead
  Plugin URI: http://www.webolead.com
  Description: simply install WebOLead script on your website.
  Version: 1.0.0
  Author: WebOLead
  Author URI: http://www.webolead.com
  License: GPLv2 or later
  Text Domain: webolead
  Domain Path: /languages
 */

class Wol_Plugin {

    public function __construct() {
        if (is_admin()) {
            require_once(plugin_dir_path(__FILE__) . '/includes/wol-admin.php');
            new Wol_Admin();
        }
        add_action('wp_footer', array($this, 'put_webolead_script'));
        
    }

    public function put_webolead_script() {
        $wol_webolead_options = get_option('wol_webolead_options');
        $wol_site_id = $wol_webolead_options['siteid_number'];
        if (!empty($wol_site_id) && is_numeric($wol_site_id)) {
            $wolScript = file_get_contents(plugin_dir_path(__FILE__) . '/includes/wol-script/webolead-script.php');
            echo str_replace('{{siteId}}', $wol_site_id, $wolScript);
        }
    }

}

new Wol_Plugin();
