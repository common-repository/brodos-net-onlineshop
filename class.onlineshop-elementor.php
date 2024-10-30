<?php

final class Elementor_Hello_World {

    const VERSION = '1.0.0';
    const MINIMUM_ELEMENTOR_VERSION = '2.0.0';
    const MINIMUM_PHP_VERSION = '5.6';

    public function __construct() {
        add_action('init', array($this, 'i18n'));
        add_action('plugins_loaded', array($this, 'init'));
    }

    public function i18n() {
        load_plugin_textdomain('brodos-onlineshop');
    }

    public function init() {
        if (!did_action('elementor/loaded')) {
            add_action('admin_notices', array($this, 'admin_notice_missing_main_plugin'));
            return;
        }
        if (!version_compare(ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=')) {
            add_action('admin_notices', array($this, 'admin_notice_minimum_elementor_version'));
            return;
        }
        if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
            add_action('admin_notices', array($this, 'admin_notice_minimum_php_version'));
            return;
        }
        require_once( 'class.onlineshop-elementor-init.php' );
    }

    /**
     * Check if a plugin is installed
     *
     * @since v3.0.0
     */
    public function is_plugin_installed($basename) {
        if (!function_exists('get_plugins')) {
            include_once ABSPATH . '/wp-admin/includes/plugin.php';
        }

        $installed_plugins = get_plugins();

        return isset($installed_plugins[$basename]);
    }

    public function admin_notice_missing_main_plugin() {
        if (isset($_GET['activate'])) {
            unset($_GET['activate']);
        }
        //$message = sprintf(esc_html__('"%1$s" requires "%2$s" to be installed and activated.', 'brodos-onlineshop'), '<strong>' . esc_html__('brodos.net Onlineshop', 'brodos-onlineshop') . '</strong>', '<strong>' . esc_html__('Elementor', 'brodos-onlineshop') . '</strong>');
        //printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
        if (!current_user_can('activate_plugins')) {
            return;
        }
        $elementor = 'elementor/elementor.php';

        if ($this->is_plugin_installed($elementor)) {
            $activation_url = wp_nonce_url('plugins.php?action=activate&amp;plugin=' . $elementor . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $elementor);
            $message = __('<strong>brodos.net Onlineshop</strong> requires <strong>Elementor</strong> plugin to be active. Please activate Elementor to continue.', 'brodos-onlineshop');
            $button_text = __('Activate Elementor', 'brodos-onlineshop');
        } else {
            $activation_url = wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=elementor'), 'install-plugin_elementor');
            $message = sprintf(__('<strong>brodos.net Onlineshop</strong> requires <strong>Elementor</strong> plugin to be installed and activated. Please install Elementor to continue.', 'brodos-onlineshop'), '<strong>', '</strong>');
            $button_text = __('Install Elementor', 'brodos-onlineshop');
        }

        $button = '<p><a href="' . $activation_url . '" class="button-primary">' . $button_text . '</a></p>';

        printf('<div class="error"><p>%1$s</p>%2$s</div>', __($message), $button);
    }

    public function admin_notice_minimum_elementor_version() {
        if (isset($_GET['activate'])) {
            unset($_GET['activate']);
        }
        $message = sprintf(esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'brodos-onlineshop'), '<strong>' . esc_html__('brodos.net Onlineshop', 'brodos-onlineshop') . '</strong>', '<strong>' . esc_html__('Elementor', 'brodos-onlineshop') . '</strong>', self::MINIMUM_ELEMENTOR_VERSION);
        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    public function admin_notice_minimum_php_version() {
        if (isset($_GET['activate'])) {
            unset($_GET['activate']);
        }
        $message = sprintf(esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'brodos-onlineshop'), '<strong>' . esc_html__('brodos.net Onlineshop', 'brodos-onlineshop') . '</strong>', '<strong>' . esc_html__('PHP', 'brodos-onlineshop') . '</strong>', self::MINIMUM_PHP_VERSION);
        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

}

new Elementor_Hello_World();
