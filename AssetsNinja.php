<?php
/**
 * Plugin Name: Assets Ninja
 * Description: A simple Assets Management website
 * Plugin URI: https://nahidulislamsayel.co
 * Author: Nahidul Islam Sayel
 * Author URI: https://NahidulIslamSayel.com
 * Version: 1.0
 * License: GPL2 or later
 * Text Domain: assetsninja
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */
define("ASSETNINJA_ASSETS_DIR", plugin_dir_url(__FILE__) . "/assets");
define("ASSETNINJA_ASSETS_PUBLIC_DIR", ASSETNINJA_ASSETS_DIR . "/public");
define("ASSETNINJA_ASSETS_ADMIN_DIR", ASSETNINJA_ASSETS_DIR . "/admin");

if (!defined('ABSPATH')) {
    exit;
}

class AssetsNinja
{
    private $version;

    public function __construct()
    {
        $this->version = time();
		add_action('init', array($this,'asn_init'));
        add_action('plugins_loaded', array($this, 'load_textdomain'));
        add_action('wp_enqueue_scripts', array($this, 'load_front_assets'));
        add_action('admin_enqueue_scripts', array($this, 'load_admin_assets'));
		
    }
	public function  asn_init(){
		wp_deregister_script('fontawesome-css');
		wp_register_style('fontawesome-css', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css');
	}

    public function load_admin_assets($screen)
    {
      if('options-general.php'== $screen) {
        wp_enqueue_script('asn-admin-js', ASSETNINJA_ASSETS_ADMIN_DIR . '/js/admin.js', array('jquery'), $this->version, true);
	  }
    }

    public function load_front_assets()
    {
        wp_enqueue_script('assetsninja-css', ASSETNINJA_ASSETS_PUBLIC_DIR . "/css/main.css", null, $this->version);
        wp_enqueue_script('assetsninja-js', ASSETNINJA_ASSETS_PUBLIC_DIR . "/js/main.js", array('jquery', 'assetsninja-another-js'), $this->version, true);
        wp_enqueue_script('assetsninja-another-js', ASSETNINJA_ASSETS_PUBLIC_DIR . "/js/another.js", array('jquery'), $this->version, true);

        $data = array(
            'name' => 'lwhh',
            'url'  => 'https://nahidulislamsayel.com',
        );
        $translate_string = array(
            'greetings' => __('Hello World', 'assetsninja'),
        );
        wp_localize_script('assetsninja-another-js', 'pdata', $data);
        wp_localize_script('assetsninja-another-js', 'translation', $translate_string);
    }

    public function load_textdomain()
    {
        load_plugin_textdomain('assetsninja', false, plugin_dir_path(__FILE__) . "/languages");
    }

}

new AssetsNinja();
