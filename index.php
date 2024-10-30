<?php

/**
 * Plugin Name: brodos.net Onlineshop Plugin
 * Plugin URI: https://brodos.net/
 * Description: Ein einfaches und dennoch leistungsstarkes Plugin der Brodos AG, das Ihre Website in eine komplette E-Commerce-L&ouml;sung verwandelt.
 * Version: 2.0.1
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * Author: brodosnet
 * Author URI: https://brodos.net
 * License: GPL v2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: brodos-onlineshop
 */
if (!defined('ABSPATH')) {
    exit;
}
define('ONLINESHOP_PLUGIN_DIR', plugin_dir_path(__FILE__));

register_activation_hook(__FILE__, array('onlineshopAdmin', 'plugin_activation'));
register_deactivation_hook(__FILE__, array('onlineshopAdmin', 'plugin_deactivation'));
require_once( ONLINESHOP_PLUGIN_DIR . 'class.onlineshop-init.php' );
require_once( ONLINESHOP_PLUGIN_DIR . 'class.onlineshop-forms.php' );
require_once( ONLINESHOP_PLUGIN_DIR . 'class.onlineshop-admin.php' );
require_once( ONLINESHOP_PLUGIN_DIR . 'class.onlineshop-menu.php' );
require_once( ONLINESHOP_PLUGIN_DIR . 'class.onlineshop-ecommerce.php' );
//require_once( ONLINESHOP_PLUGIN_DIR . 'class.onlineshop-elementor.php' );
