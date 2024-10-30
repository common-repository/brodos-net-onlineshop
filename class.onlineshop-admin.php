<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class onlineshopAdmin {

    public static function plugin_activation() {
        add_option('onlineshop_do_activation_redirect', true);
    }

    public static function plugin_deactivation() {
        delete_option('brodos_shop_url');
    }

    function my_plugin_redirect() {
        if (get_option('onlineshop_do_activation_redirect', false)) {
            delete_option('onlineshop_do_activation_redirect');
            if (!isset($_GET['activate-multi'])) {
                wp_redirect(admin_url('admin.php?page=onlineshop'));
            }
        }
    }

    public function __construct() {
        // Hook into the admin menu
        add_action('admin_menu', array($this, 'create_plugin_settings_page'));
        add_action('admin_menu', array($this, 'register_sub_menu'));
    }

    public function create_plugin_settings_page() {
        // Add the menu item and page
        $page_title = 'Brodos Onlineshop';
        $menu_title = 'brodos.net Onlineshop';
        $capability = 'manage_options';
        $slug = 'onlineshop';
        $callback = array($this, 'plugin_settings_page_content');
        $icon = 'dashicons-cart';
        $position = 100;

        add_menu_page($page_title, $menu_title, $capability, $slug, $callback, $icon, $position);
    }

    public function register_sub_menu() {
        add_submenu_page('onlineshop', 'Brodos Onlineshop Help', 'Help', 'manage_options', 'onlineshop-help', array($this, 'help_callback'));
    }

    function help_callback() {
        include_once( 'help.php' ); 
    }

    public function plugin_settings_page_content() {
        $brodosCatTypes = array(
            array("button", "Button", "Bitte geben Sie einen Namen f&uuml;r den Kategorie-Button an."),
            array("image", "Bild", "Bitte geben Sie die Bild-URL ein."),
            array("text", "Text", "Bitte geben Sie den anzuzeigenden Kategorie-Text ein."),
            array("menu", "Men&uuml;", "Bitte geben Sie einen Namen f&uuml;r den Men&uuml;punkt ein.")
        );
        $brodosSearchGroupTypes = array(
            array("button", "Button", "Bitte geben Sie einen Namen f&uuml;r den Button an."),
            array("image", "Bild", "Bitte geben Sie die Bild-URL ein."),
            array("text", "Text", "Bitte geben Sie den anzuzeigenden Text ein."),
            array("menu", "Men&uuml;", "Bitte geben Sie einen Namen f&uuml;r den Men&uuml;punkt ein.")
        );
        $brodosArticleTypes = array(
            array("button", "Button", "Bitte geben Sie einen Namen f&uuml;r den Button an."),
            array("image", "Bild", "Bitte geben Sie die Bild-URL ein."),
            array("text", "Text", "Bitte geben Sie den anzuzeigenden Text ein."),
            array("menu", "Men&uuml;", "Bitte geben Sie einen Namen f&uuml;r den Men&uuml;punkt ein.")
        );
        if (!empty($_POST["updated"]) && $_POST['updated'] === 'true') {
            if (class_exists('onlineshopFormHandling')) {
                $onlineshopFormHandling = new onlineshopFormHandling();
                $onlineshopFormHandling->handle_form();
            }
        }
        if (!empty($_POST["brodos_ga_code_updated"]) && $_POST['brodos_ga_code_updated'] === 'true') {
            if (class_exists('onlineshopFormHandling')) {
                $onlineshopFormHandling = new onlineshopFormHandling();
                $onlineshopFormHandling->handle_ga_code_form();
            }
        }
        if (get_option('brodos_shop_url') == "") {
            ?>
            <div class="notice notice-warning">
                <p>Bitte geben Sie die URL Ihres brodos.net-Onlineshops ein, um die Such- und Warenkorbfunktion zu nutzen.</p>
            </div>
            <?php
        }
        ?>
        <div class="wrap onlineshopPage">
            <h1>brodos.net Onlineshop Plugin f&uuml;r Wordpress</h1>
            <form method="POST">
                <input type="hidden" name="updated" value="true" />
                <?php wp_nonce_field('onlineshop_search_update', 'onlineshop_search_form'); ?>
                <table class="form-table">
                    <tbody>
                        <tr>
                            <th scope="row">URL Ihres brodos.net Onlineshops</th>
                            <td>
                                <input name="brodos_shop_url" id="brodos_shop_url" type="text" placeholder="" value="<?php echo get_option('brodos_shop_url'); ?>" required="required">
                                <p class="description">Geben Sie die URL Ihres brodos.net Onlineshops ein</p>
                                <?php
                                submit_button();
                                ?>
                            </td>
                        </tr>
                        <tr><td colspan="2"><hr /></td></tr>
                        <tr <?php
                        if (get_option('brodos_shop_url') == "") {
                            echo 'class="readonly"';
                        }
                        ?>>
                            <th scope="row">Implementierung der brodos.net Onlineshop-Suche</th>
                            <td>
                                <input type="text" value="[BrodosSearch]" readonly="readonly"><span id="BrodosSearch" class="hide">[BrodosSearch]</span>
                                <button class="shortcodeCopyButton button button-primary" data-target="BrodosSearch"><?php _e('Copy'); ?></button>
                                <p class="description">
                                    Hinterlegen Sie die URL Ihres brodos.net Onlineshops und kopieren Sie den generierten shortcode <strong>[BrodosSearch]</strong>.<br />
                                    F&uuml;gen Sie ihn in den Bereich ihrer Wordpress Website ein, in dem Sie die Suchfunktion des Onlineshops anzeigen lassen m&ouml;chten.<br />
                                    Sollten Sie weitere Unterst&uuml;tzung ben&ouml;tigen, finden Sie diese im Bereich &quot;Hilfe&quot;.
                                </p>
                            </td>
                        </tr>
                        <tr><td colspan="2"><hr /></td></tr>
                        <tr <?php
                        if (get_option('brodos_shop_url') == "") {
                            echo 'class="readonly"';
                        }
                        ?>>
                            <th scope="row">Implementierung der brodos.net Onlineshop-Cart</th>
                            <td>
                                <input type="text" value="[BrodosCart]" readonly="readonly"><span id="brodosCart" class="hide">[BrodosCart]</span>
                                <button class="shortcodeCopyButton button button-primary" data-target="brodosCart"><?php _e('Copy'); ?></button>
                                <p class="description">
                                    Hinterlegen Sie die URL Ihres brodos.net Onlineshops und kopieren Sie den generierten shortcode <strong>[BrodosCart]</strong>.<br />
                                    F&uuml;gen Sie ihn in den Bereich ihrer Wordpress Website ein, in dem Sie die cart funktion des Onlineshops anzeigen lassen m&ouml;chten.<br />
                                    Sollten Sie weitere Unterst&uuml;tzung ben&ouml;tigen, finden Sie diese im Bereich &quot;Hilfe&quot;.
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
            
            <?php
            /* ---------------------------- */
            /* Delivery to store storeids  */
            if ( is_plugin_active( 'woocommerce-shipping-local-pickup-plus/woocommerce-shipping-local-pickup-plus.php' ) ) {
            ?>
            <hr />
            <form method="POST">
                <input type="hidden" name="storeids_updated" value="true" />
                <?php wp_nonce_field('onlineshop_storeids_update', 'onlineshop_storeids_form'); ?>
                <?php
                    if (!empty($_POST["storeids_updated"]) && $_POST['storeids_updated'] === 'true') {
                        if (class_exists('onlineshopFormHandling')) {
                            $onlineshopFormHandling = new onlineshopFormHandling();
                            $onlineshopFormHandling->handle_storeids_form();
                        }
                    }
                                ?>
                <table class="form-table">
                    <tbody>
                        <tr>
                            <th scope="row">Store ID's für Abholung im Laden</th>
                            <td>
                                <input name="brodos_delivery_to_storeId" id="brodos_delivery_to_storeId" type="number" placeholder="StoreIds" value="<?php echo get_option('brodos_delivery_to_storeId'); ?>" required>
                                <p class="description">Geben Sie storeid für die Lieferung an die Filiale ein.</p>
                                <p class="submit">
                                    <input type="submit" name="submit" class="button button-primary" value="Save Storeids">
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
            <?php 
            } 
            /* ---------------------------- */
            ?>
            <hr />
            <!-- Additional GA code -->
            <form method="POST">
                <input type="hidden" name="brodos_ga_code_updated" value="true" />
                <?php wp_nonce_field('onlineshop_ga_code_update', 'onlineshop_ga_code_form'); ?>
                <table class="form-table">
                    <tbody>
                        <tr>
                            <th scope="row">GA-Code für PowerBi-Bericht</th>
                            <td>
                                <input name="brodos_ga_code" id="brodos_ga_code" type="text" placeholder="GA code" value="<?php echo get_option('brodos_ga_code'); ?>">
                                <p class="description">GA-Code f&uuml;r PowerBi-Bericht eingeben.</p>
                                <p class="submit">
                                    <input type="submit" name="submit" class="button button-primary" value="GA-Code speichern">
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
            <hr />
            <form method="POST">
                <input type="hidden" name="cat_updated" value="true" />
                <?php wp_nonce_field('onlineshop_cat_update', 'onlineshop_cat_form'); ?>
                <table class="form-table">
                    <tbody>
                        <tr>
                            <th scope="row">Integration der brodos.net Onlineshop Kategorien</th>
                            <td>
                                <input name="brodos_cat_url" id="brodos_cat_url" type="text" placeholder="Bitte geben Sie die URL Ihrer Wunschkategorie ein." required>
                                <br /><br />
                                <select name="brodos_cat_type" id="brodos_cat_type" required>
                                    <option value="">Bitte w&auml;hlen Sie das Format der anzuzeigenden Kategorie aus:</option>
                                    <?php
                                    foreach ($brodosCatTypes as $brodosCatType) {
                                        echo '<option value="' . $brodosCatType[0] . '" data-placeholder="' . $brodosCatType[2] . '">' . $brodosCatType[1] . '</option>';
                                    }
                                    ?>
                                </select>
                                <br /><br />
                                <input name="brodos_cat_text" id="brodos_cat_text" placeholder="" type="text" required>
                                <br /><br />
                                <?php
                                if (!empty($_POST["cat_updated"]) && $_POST['cat_updated'] === 'true') {
                                    if (class_exists('onlineshopFormHandling')) {
                                        $onlineshopFormHandling = new onlineshopFormHandling();
                                        $onlineshopFormHandling->handle_cat_form();
                                    }
                                }
                                ?>
                                <p class="submit">
                                    <input type="submit" name="submit" class="button button-primary" value="Shortcode generieren">
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
            <hr />
            <form method="POST">
                <input type="hidden" name="search_group_updated" value="true" />
                <?php wp_nonce_field('onlineshop_search_group_update', 'onlineshop_search_group_form'); ?>
                <table class="form-table">
                    <tbody>
                        <tr>
                            <th scope="row">Implementierung individueller Produktgruppen aus dem brodos.net Onlineshop</th>
                            <td>
                                <input name="brodos_search_group_url" id="brodos_search_group_url" type="text" placeholder="Bitte URL eingeben." required>
                                <br /><br />
                                <select name="brodos_search_group_type" id="brodos_search_group_type" required>
                                    <option value="">Bitte w&auml;hlen Sie das Format</option>
                                    <?php
                                    foreach ($brodosSearchGroupTypes as $brodosSearchGroupType) {
                                        echo '<option value="' . $brodosSearchGroupType[0] . '" data-placeholder="' . $brodosSearchGroupType[2] . '">' . $brodosSearchGroupType[1] . '</option>';
                                    }
                                    ?>
                                </select>
                                <br /><br />
                                <input name="brodos_search_group_text" id="brodos_search_group_text" placeholder="" type="text" required>
                                <br /><br />
                                <?php
                                if (!empty($_POST["search_group_updated"]) && $_POST['search_group_updated'] === 'true') {
                                    if (class_exists('onlineshopFormHandling')) {
                                        $onlineshopFormHandling = new onlineshopFormHandling();
                                        $onlineshopFormHandling->handle_search_group_form();
                                    }
                                }
                                ?>
                                <p class="submit">
                                    <input type="submit" name="submit" class="button button-primary" value="Shortcode generieren">
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
            <hr />
            <form method="POST">
                <input type="hidden" name="article_linking_updated" value="true" />
                <?php wp_nonce_field('onlineshop_article_linking_update', 'onlineshop_article_linking_form'); ?>
                <table class="form-table">
                    <tbody>
                        <tr>
                            <th scope="row">Integration von Artikeldaten aus dem brodos.net Onlineshop</th>
                            <td>
                                <input name="brodos_article_linking_url" id="brodos_article_linking_url" type="text" placeholder="Bitte URL eingeben." required>
                                <br /><br />
                                <select name="brodos_article_linking_type" id="brodos_article_linking_type" required>
                                    <option value="">Bitte w&auml;hlen Sie das Format</option>
                                    <?php
                                    foreach ($brodosArticleTypes as $brodosArticleType) {
                                        echo '<option value="' . $brodosArticleType[0] . '" data-placeholder="' . $brodosArticleType[2] . '">' . $brodosArticleType[1] . '</option>';
                                    }
                                    ?>
                                </select>
                                <br /><br />
                                <input name="brodos_article_linking_text" id="brodos_article_linking_text" placeholder="" type="text" required>
                                <br /><br />
                                <?php
                                if (!empty($_POST["article_linking_updated"]) && $_POST['article_linking_updated'] === 'true') {
                                    if (class_exists('onlineshopFormHandling')) {
                                        $onlineshopFormHandling = new onlineshopFormHandling();
                                        $onlineshopFormHandling->handle_article_linking_form();
                                    }
                                }
                                ?>
                                <p class="submit">
                                    <input type="submit" name="submit" class="button button-primary" value="Shortcode generieren">
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
            <hr />
            <form method="POST">
                <input type="hidden" name="article_link_updated" value="true" />
                <input type="hidden" name="global_brodos_url" value="<?php echo rtrim(get_option('brodos_shop_url'), "/"); ?>" />
                <?php wp_nonce_field('onlineshop_article_link_update', 'onlineshop_article_link_form'); ?>
                <table class="form-table">
                    <tbody>
                        <tr <?php
                        if (get_option('brodos_shop_url') == "") {
                            echo 'class="readonly"';
                        }
                        ?>>
                            <th scope="row">Article linking</th>
                            <td>
                                <input name="brodos_article_link_url" id="brodos_article_link_url" type="text" placeholder="Bitte URL eingeben." required>
                                <br /><br />
                                <p class="submit">
                                    <input type="submit" name="submit" id="brodos_article_link_submit" class="button button-primary" value="Shortcode generieren">
                                </p>
                                <div class="brodos_article_link_display" id="brodos_article_link_display"></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div> <?php
    }

    public function admin_assets($hook) {

        $current_screen = get_current_screen();
        if (strpos($current_screen->base, 'toplevel_page_onlineshop') === false) {
            return;
        } else {
            wp_enqueue_style('onlineshop-main-style', plugins_url('assets/onlineshop-admin.css', __FILE__));
            wp_enqueue_script('onlineshop-main-script', plugins_url('assets/onlineshop-admin.js', __FILE__));
        }
    }

}

$onlineshopAdmin = new onlineshopAdmin;
add_action('admin_init', array($onlineshopAdmin, 'my_plugin_redirect'));
add_action('admin_enqueue_scripts', array($onlineshopAdmin, 'admin_assets'));
