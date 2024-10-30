<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class onlineshopFormHandling {
    /*
     * Form submission handling of Global URL.
     */

    public function handle_form() {
        if (!isset($_POST['onlineshop_search_form']) || !wp_verify_nonce($_POST['onlineshop_search_form'], 'onlineshop_search_update')) {
            ?>
            <div class="notice notice-error is-dismissible">
                <p>Sorry, je nonce was niet correct. Probeer het nog eens.</p>
            </div> <?php
            exit;
        } else {

            function is_url($uri) {
                if (preg_match('%^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@|\d{1,3}(?:\.\d{1,3}){3}|(?:(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)(?:\.(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)*(?:\.[a-z\x{00a1}-\x{ffff}]{2,6}))(?::\d+)?(?:[^\s]*)?$%iu', $uri)) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            }

            $brodos_shop_url = sanitize_text_field($_POST['brodos_shop_url']);
            if (is_url($brodos_shop_url)) {
                update_option('brodos_shop_url', $brodos_shop_url);
                ?>
                <div class="notice notice-success is-dismissible">
                    <p>Uw instellingen zijn bijgewerkt!</p>
                </div>
            <?php } else { ?>
                <div class="notice notice-error is-dismissible">
                    <p>Uw URL of Page waren ongeldig.</p>
                </div>
                <?php
            }
        }
    }

    /*
     * Form submission handling of storeids form.
     */

    public function handle_storeids_form() {

        if (!isset($_POST['onlineshop_storeids_form']) || !wp_verify_nonce($_POST['onlineshop_storeids_form'], 'onlineshop_storeids_update')) {
            ?>
            <div class="notice notice-error is-dismissible">
                <p>Sorry, je nonce was niet correct. Probeer het nog eens.</p>
            </div>
            <?php
            exit;
        } else {
            $storeids = $_POST['brodos_delivery_to_storeId'];
            $originalStoreId = get_option('brodos_delivery_to_storeId');
            update_option('brodos_delivery_to_storeId', $storeids);
            $this->add_location_to_local_pickup($storeids,$originalStoreId);
            ?>
            <?php
        }
    }

    /*
     * Form submission handling of GA code form.
     */

    public function handle_ga_code_form() {

        if (!isset($_POST['onlineshop_ga_code_form']) || !wp_verify_nonce($_POST['onlineshop_ga_code_form'], 'onlineshop_ga_code_update')) {
            ?>
            <div class="notice notice-error is-dismissible">
                <p>Sorry, je nonce was niet correct. Probeer het nog eens.</p>
            </div>
            <?php
            exit;
        } else {
            $brodos_ga_code = $_POST['brodos_ga_code'];
            update_option('brodos_ga_code', $brodos_ga_code);
            ?>
            <div class="notice notice-success is-dismissible">
                <p>Uw instellingen zijn bijgewerkt!</p>
            </div>
            <?php
        }
    }


    /*
     * Form submission handling of category form.
     */

    public function handle_cat_form() {
        if (!isset($_POST['onlineshop_cat_form']) || !wp_verify_nonce($_POST['onlineshop_cat_form'], 'onlineshop_cat_update')) {
            ?>
            <div class="notice notice-error is-dismissible">
                <p>Sorry, je nonce was niet correct. Probeer het nog eens.</p>
            </div>
            <?php
            exit;
        } else {

            function is_url($uri) {
                if (preg_match('%^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@|\d{1,3}(?:\.\d{1,3}){3}|(?:(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)(?:\.(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)*(?:\.[a-z\x{00a1}-\x{ffff}]{2,6}))(?::\d+)?(?:[^\s]*)?$%iu', $uri)) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            }

            $brodos_cat_url = $_POST['brodos_cat_url'];

            if (!is_url($brodos_cat_url)) {
                ?>
                <div class="notice notice-error is-dismissible">
                    <p>Die angegebene URL kann nicht verarbeitet werden.</p>
                </div>
                <?php
            } else if (trim($_POST['brodos_cat_type'], " ") == "") {
                ?>
                <div class="notice notice-error is-dismissible">
                    <p>Bitte w&auml;hlen Sie ein zul&auml;ssiges Format f&uuml;r die anzuzeigende Kategorie aus.</p>
                </div>
                <?php
            } else if (trim($_POST['brodos_cat_text'], " ") == "") {
                ?>
                <div class="notice notice-error is-dismissible">
                    <p>Bitte geben Sie Ihren Wunschtext in dem hierf&uuml;r vorgesehenen Format ein.</p>
                </div>
                <?php
            } else if ($_POST['brodos_cat_type'] == 'menu') {
                $postdata = array(
                    'post_type' => 'brodos_category',
                    'post_title' => sanitize_text_field($_POST['brodos_cat_text']),
                    'post_status' => 'publish'
                );
                $newid = wp_insert_post($postdata);
                add_post_meta($newid, 'brodos_category_link', $brodos_cat_url, true);
                ?>
                <div class="shortcodeDisplay">
                    <code id="brodosCat">Neue Kategorieverlinkung wurde erstellt, Bitte klicken Sie auf <strong>'Aussehen' > 'Men&uuml;s'</strong>, um die Kategorie als Men&uuml;punkt anzulegen.</code>
                </div>
                <?php
            } else {
                ?>
                <div class="shortcodeDisplay">
                    <code id="brodosCat">[BrodosCategory type="<?php echo $_POST['brodos_cat_type']; ?>" url="<?php echo $brodos_cat_url; ?>" data="<?php echo $_POST['brodos_cat_text']; ?>"]</code>
                    <button class="button button-primary shortcodeCopyButton" data-target="brodosCat"><?php _e('Copy'); ?></button>
                </div>
                <?php
            }
        }
    }


    /*
     * Form submission handling of search group form.
     */

    public function handle_search_group_form() {
        if (!isset($_POST['onlineshop_search_group_form']) || !wp_verify_nonce($_POST['onlineshop_search_group_form'], 'onlineshop_search_group_update')) {
            ?>
            <div class="notice notice-error is-dismissible">
                <p>Sorry, je nonce was niet correct. Probeer het nog eens.</p>
            </div> <?php
            exit;
        } else {

            function is_url($uri) {
                if (preg_match('%^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@|\d{1,3}(?:\.\d{1,3}){3}|(?:(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)(?:\.(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)*(?:\.[a-z\x{00a1}-\x{ffff}]{2,6}))(?::\d+)?(?:[^\s]*)?$%iu', $uri)) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            }

            $brodos_search_group_url = $_POST['brodos_search_group_url'];

            if (!is_url($brodos_search_group_url)) {
                ?>
                <div class="notice notice-error is-dismissible">
                    <p>Die angegebene URL kann nicht verarbeitet werden.</p>
                </div>
                <?php
            } else if (trim($_POST['brodos_search_group_type'], " ") == "") {
                ?>
                <div class="notice notice-error is-dismissible">
                    <p>Bitte w&auml;hlen Sie ein zul&auml;ssiges Format f&uuml;r die anzuzeigende Kategorie aus.</p>
                </div>
                <?php
            } else if (trim($_POST['brodos_search_group_text'], " ") == "") {
                ?>
                <div class="notice notice-error is-dismissible">
                    <p>Bitte geben Sie Ihren Wunschtext in dem hierf&uuml;r vorgesehenen Format ein.</p>
                </div>
                <?php
            } else if ($_POST['brodos_search_group_type'] == 'menu') {
                $postdata = array(
                    'post_type' => 'brodos_prod_group',
                    'post_title' => sanitize_text_field($_POST['brodos_search_group_text']),
                    'post_status' => 'publish'
                );
                $newid = wp_insert_post($postdata);
                add_post_meta($newid, 'brodos_prod_group_link', $brodos_search_group_url, true);
                ?>
                <div class="shortcodeDisplay">
                    <code id="brodosCat">Neue Produktgruppenverlinkung wurde erstellt, Bitte klicken Sie auf <strong>'Aussehen' > 'Men&uuml;s'</strong>, um die Produktgruppe als Men&uuml;punkt anzulegen.</code>
                </div>
                <?php
            } else {
                ?>
                <div class="shortcodeDisplay">
                    <code id="brodosSearchGroup">[BrodosSearchGroup type="<?php echo $_POST['brodos_search_group_type']; ?>" url="<?php echo $brodos_search_group_url; ?>" data="<?php echo $_POST['brodos_search_group_text']; ?>"]</code>
                    <button class="button button-primary shortcodeCopyButton" data-target="brodosSearchGroup"><?php _e('Copy'); ?></button>
                </div>
                <?php
            }
        }
    }

    /*
     * Form submission handling of article form.
     */

    public function handle_article_linking_form() {
        if (!isset($_POST['onlineshop_article_linking_form']) || !wp_verify_nonce($_POST['onlineshop_article_linking_form'], 'onlineshop_article_linking_update')) {
            ?>
            <div class="notice notice-error is-dismissible">
                <p>Sorry, je nonce was niet correct. Probeer het nog eens.</p>
            </div> <?php
            exit;
        } else {

            function is_url($uri) {
                if (preg_match('%^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@|\d{1,3}(?:\.\d{1,3}){3}|(?:(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)(?:\.(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)*(?:\.[a-z\x{00a1}-\x{ffff}]{2,6}))(?::\d+)?(?:[^\s]*)?$%iu', $uri)) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            }

            $brodos_article_linking_url = $_POST['brodos_article_linking_url'];

            if (!is_url($brodos_article_linking_url)) {
                ?>
                <div class="notice notice-error is-dismissible">
                    <p>Die angegebene URL kann nicht verarbeitet werden.</p>
                </div>
                <?php
            } else if (trim($_POST['brodos_article_linking_type'], " ") == "") {
                ?>
                <div class="notice notice-error is-dismissible">
                    <p>Bitte w&auml;hlen Sie ein zul&auml;ssiges Format f&uuml;r die anzuzeigende Kategorie aus.</p>
                </div>
                <?php
            } else if (trim($_POST['brodos_article_linking_text'], " ") == "") {
                ?>
                <div class="notice notice-error is-dismissible">
                    <p>Bitte geben Sie Ihren Wunschtext in dem hierf&uuml;r vorgesehenen Format ein.</p>
                </div>
                <?php
            } else if ($_POST['brodos_article_linking_type'] == 'menu') {
                $postdata = array(
                    'post_type' => 'brodos_article',
                    'post_title' => sanitize_text_field($_POST['brodos_article_linking_text']),
                    'post_status' => 'publish'
                );
                $newid = wp_insert_post($postdata);
                add_post_meta($newid, 'brodos_article_link', $brodos_article_linking_url, true);
                ?>
                <div class="shortcodeDisplay">
                    <code id="brodosCat">Neue Artikelverlinkung wurde erstellt, Bitte klicken Sie auf <strong>'Aussehen' > 'Men&uuml;s'</strong>, um den Artikel als Men&uuml;punkt anzulegen.</code>
                </div>
                <?php
            } else {
                ?>
                <div class="shortcodeDisplay">
                    <code id="brodosArticleLinking">[BrodosArticle type="<?php echo $_POST['brodos_article_linking_type']; ?>" url="<?php echo $brodos_article_linking_url; ?>" data="<?php echo $_POST['brodos_article_linking_text']; ?>"]</code>
                    <button class="button button-primary shortcodeCopyButton" data-target="brodosArticleLinking"><?php _e('Copy'); ?></button>
                </div>
                <?php
            }
        }
    }

    /*
     * Delivery to Store add locations .
    */

    public function add_location_to_local_pickup($storeIds,$originalStoreId) {
        // check for plugin activation
        if ( is_plugin_active( 'woocommerce-shipping-local-pickup-plus/woocommerce-shipping-local-pickup-plus.php' ) ) {
    
            /* -------------------------------------- */
            /* Add Pickup Locations ----------------- */
            /* -------------------------------------- */
            
            $storeIds = explode(',',$storeIds);
            foreach ($storeIds as $key => $storeId) {
                
                global $wpdb;
                $table = "{$wpdb->prefix}woocommerce_pickup_locations_geodata";
    
                // Verify token 
                $headers = getallheaders();
                $options = 0;
                $ciphering = "BF-CBC"; 
                $encryption = get_option('brodos_api_encryption');
                $decryption_key = openssl_digest(site_url(), 'MD5', TRUE);
                $decryption = openssl_decrypt (base64_decode($encryption), $ciphering, $decryption_key, $options, base64_decode(get_option('brodos_api_encryption_iv'))); 
                
                $url = trailingslashit(get_option('brodos_seller_api')).''.$storeId;
                $args = array(
                    'timeout' => 300,
                    'headers' => array(
                      'Content-Type' => 'application/json',
                      'X-BRODOS-API-KEY' => $decryption
                    ));

                $response = wp_remote_get($url,$args);
                
                if (is_wp_error($response)) {
                    echo wp_remote_retrieve_body($response);                
                }else{

                    $locationData = json_decode($response['body'],true);

                    if(!empty($locationData['id'])){
                        $products = array("products"=> array(0),"product_categories" => array(0));

                        // Delete all location data
                        $wpdb->query( 
                            $wpdb->prepare("
                                DELETE posts,pt,pm
                                FROM $wpdb->posts posts
                                LEFT JOIN $wpdb->term_relationships pt ON pt.object_id = posts.ID
                                LEFT JOIN $wpdb->postmeta pm ON pm.post_id = posts.ID
                                WHERE posts.post_type = 'wc_pickup_location'"
                            )
                        );
                    
                        // Add new pickup location 
                        $post_data = array(
                            'post_title'   => $locationData['firstname'],
                            'post_content' => $locationData['email'],
                            'post_type' => 'wc_pickup_location',
                            'post_status'  => 'publish',
                            'post_author'  => get_current_user_id(),
                            'meta_input'   => array(
                                '_pickup_location_products' => serialize($products),
                                '_pickup_location_price_adjustment_enabled' => 'no',
                                '_pickup_location_business_hours_enabled' => 'no',
                                '_pickup_location_public_holidays_enabled' => 'no',
                                '_pickup_location_pickup_lead_time_enabled' => 'no',
                                '_pickup_location_pickup_deadline_enabled' => 'no',
                                '_pickup_location_address_country' => 'DE',	
                                '_pickup_location_address_state' => '',
                                '_pickup_location_address_postcode' => $locationData['zipcode'],
                                '_pickup_location_address_city' => $locationData['city'],
                                '_pickup_location_address_address_1' => $locationData['street'],
                                '_pickup_location_address_address_2' => $locationData['streetno'],
                                '_pickup_location_phone' => $locationData['phone'],
                                '_pickup_location_email' => $locationData['email'],
                                '_pickup_location_website' => $locationData['website'],
                                '_pickup_location_lastname' => $locationData['lastname'],
                                '_pickup_location_storeId' => $locationData['id'],
                            ),
                        );
        
                        $post_id = wp_insert_post( $post_data );
                        $success = (bool) $wpdb->update(
                            $table,
                            array(
                                'post_id'      => $post_id,
                                'title'        => $locationData['firstname'],
                                'lat'          => '00.0000000',
                                'lon'          => '00.0000000',
                                'country'      => 'DE',
                                'state'        => '',
                                'postcode'     => $locationData['zipcode'],
                                'city'         => $locationData['city'],
                                'address_1'    => $locationData['street'],
                                'address_2'    => $locationData['streetno'],
                                'last_updated' => date( 'Y-m-d H:i:s', current_time( 'timestamp', true ) ),
                            ),
                            array( 'post_id' => $post_id),
                            array( '%s', '%f', '%f', '%s', '%s', '%s', '%s', '%s', '%s', '%s' ),
                            array( '%d' )
                        );

                        if(!empty($post_id)){
                            echo '<div class="notice notice-success is-dismissible"><p>Delivery to store address is successfully saved.</p></div>';
                        }

                    }else{
                        // Revert to original
                        update_option('brodos_delivery_to_storeId', $originalStoreId);
                        echo '<div class="notice notice-error is-dismissible"><p>Seems like Store Id is invalid. Please enter valid store id. </p></div>';
                    }
                }
            }
        }
    }        

    /*
     * Form submission handling of article fetching.
     */
    /*
    public function handle_article_link_form() {
        if (!isset($_POST['onlineshop_article_link_form']) || !wp_verify_nonce($_POST['onlineshop_article_link_form'], 'onlineshop_article_link_update')) {
            ?>
            <div class="notice notice-error is-dismissible">
                <p>Sorry, je nonce was niet correct. Probeer het nog eens.</p>
            </div> <?php
            exit;
        } else {

            function is_url($uri) {
                if (preg_match('%^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@|\d{1,3}(?:\.\d{1,3}){3}|(?:(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)(?:\.(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)*(?:\.[a-z\x{00a1}-\x{ffff}]{2,6}))(?::\d+)?(?:[^\s]*)?$%iu', $uri)) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            }

            $brodos_article_link_url = $_POST['brodos_article_link_url'];

            if (!is_url($brodos_article_link_url)) {
                ?>
                <div class="notice notice-error is-dismissible">
                    <p>Die angegebene URL kann nicht verarbeitet werden.</p>
                </div>
                <?php
            } else {
                ?>
                
                <?php
            }
        }
    }
    */
}
