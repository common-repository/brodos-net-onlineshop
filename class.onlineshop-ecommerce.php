<?php

class onlineshopEcommerce {

    function add_cors_http_header() {
        //ini_set('session.cookie_domain', '*');
        $url = get_option('brodos_shop_url');
        if (!empty($url)) {
            $sourceUrl = parse_url($url);
            $sourceUrl = $sourceUrl['host'];
            header("Access-Control-Allow-Origin: $sourceUrl");
            header("Access-Control-Allow-Credentials: true");
            header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT");
            header("Access-Control-Allow-Headers: x-requested-with, Content-Type, origin, authorization, accept, client-security-token");
        }
        if (is_user_logged_in() || is_admin()) {
            return;
        }
        if (isset(WC()->session)) {
            if (!WC()->session->has_session()) {
                WC()->session->set_customer_session_cookie(true);
            }
        }
    }

    function force_non_logged_user_wc_session() {
        if (is_user_logged_in() || is_admin()) {
            return;
        }
        if (isset(WC()->session)) {
            if (!WC()->session->has_session()) {
                WC()->session->set_customer_session_cookie(true);
            }
        }
    }

    function brodosAddToCart() {
        register_rest_route('v1/', 'shoppingitems', array(
            'methods' => 'POST',
            'callback' => [$this, 'BrodosAddToCartFun']
        ));
    }

    function brodosGetToken() {
        register_rest_route('v1/', 'tokens', array(
            'methods' => 'GET',
            'callback' => [$this, 'BrodosGetTokenFun']
        ));
    }

    function BrodosGetTokenFun($request_data) {
        $token = wp_create_nonce();
        $cookie_name = time();
        $cookie_value = time();
        setcookie($cookie_name, $cookie_value, time() + (10 * 30), "/");
        $returnArray["token"] = $cookie_name;
        return $returnArray;
    }

    function getProductQuantity($product_sku) {
        WC()->frontend_includes();
        WC()->session = new WC_Session_Handler();
        WC()->session->init();
        WC()->customer = new WC_Customer(get_current_user_id(), true);
        WC()->cart = new WC_Cart();
        $cartData = WC()->cart->get_cart();

        foreach ($cartData as $item => $values) {
            $_woo_product = wc_get_product($values['data']->get_id());
            if ($product_sku == $_woo_product->get_sku()) {
                return $values['quantity'];
            }
        }
    }

    function getAndUpdateMedia($product_id, $image_url) {
        // for images
        // Add Featured Image to Post
        // $image_url        = 'http://s.wordpress.org/style/images/wp-header-logo.png'; // Define the image URL here
        $image_name = "product-$product_id.png";
        $upload_dir = wp_upload_dir(); // Set upload folder
        // return json_encode($upload_dir);
        //die;
        $image_data = file_get_contents($image_url); // Get image data
        $unique_file_name = wp_unique_filename($upload_dir['path'], $image_name); // Generate unique name
        $filename = basename($unique_file_name); // Create image file name
        // Check folder permission and define file location
        if (wp_mkdir_p($upload_dir['path'])) {
            $file = $upload_dir['path'] . '/' . $filename;
        } else {
            $file = $upload_dir['basedir'] . '/' . $filename;
        }

        // Create the image  file on the server
        $get = file_put_contents($file, $image_data);

        // Check image file type
        $wp_filetype = wp_check_filetype($filename, null);

        // Set attachment data
        $attachment = array(
            'post_mime_type' => $wp_filetype['type'],
            'post_title' => sanitize_file_name($filename),
            'post_content' => '',
            'post_status' => 'inherit'
        );

        // Create the attachment
        // return $file;

        $attach_id = wp_insert_attachment($attachment, $file, $product_id);


        // Include image.php

        require_once(ABSPATH . 'wp-admin/includes/image.php');
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/media.php');

        // Define attachment metadata
        $attach_data = wp_generate_attachment_metadata($attach_id, $file);

        // Assign metadata to attachment
        wp_update_attachment_metadata($attach_id, $attach_data);

        // And finally assign featured image to post
        set_post_thumbnail($product_id, $attach_id);
    }

    function BrodosAddToCartFun($request_data) {
        $token = wp_create_nonce();
        $parameters = $request_data->get_params();
        $tkn = $parameters['token'];
        $cookie_name = $tkn;
        if (!isset($_COOKIE[$cookie_name])) {
            return "0";
        } else {
            $product_ean = $parameters['ean'];
            $product_title = $parameters['title'];
            $product_sku = $parameters['sku'];
            $product_price = $parameters['price'];
            $product_quantity = $parameters['quantity'];
            $return_url = $parameters['return_url'];
            $image_url = $parameters['image'];
            $product_title_slug = sanitize_title($product_title);

            global $wpdb;
            $product_id_check = $wpdb->get_var($wpdb->prepare("SELECT post_id FROM $wpdb->postmeta WHERE meta_key='_sku' AND meta_value='%s' LIMIT 1", $product_sku));
            if ( FALSE === get_post_status( $product_id_check ) ) {
                $wpdb->delete( $wpdb->postmeta, [ 'post_id' => $product_id_check ], [ '%d' ] );
                // The post does not exist
                $product_id = wp_insert_post(array(
                    'post_title' => $product_title,
                    'post_type' => 'product',
                    'post_status' => 'publish',
                    'post_content' => $product_title,
                    'post_excerpt' => $product_title,
                    'post_name' => "productarticleno" . $product_sku,
                ));
                // set product is simple/variable/grouped
                wp_set_object_terms($product_id, 'simple', 'product_type');
                update_post_meta($product_id, 'product_ean', $product_ean);
                update_post_meta($product_id, '_visibility', 'visible');
                update_post_meta($product_id, '_stock_status', 'instock');
                update_post_meta($product_id, 'total_sales', '0');
                update_post_meta($product_id, '_downloadable', 'no');
                update_post_meta($product_id, '_virtual', 'no');
                update_post_meta($product_id, '_regular_price', $product_price);
                update_post_meta($product_id, '_sale_price', '');
                update_post_meta($product_id, '_purchase_note', '');
                update_post_meta($product_id, '_featured', 'no');
                update_post_meta($product_id, '_weight', 'N/A');
                update_post_meta($product_id, '_length', 'N/A');
                update_post_meta($product_id, '_width', 'N/A');
                update_post_meta($product_id, '_height', 'N/A');
                update_post_meta($product_id, '_sku', $product_sku);
                update_post_meta($product_id, '_product_attributes', array());
                update_post_meta($product_id, '_sale_price_dates_from', '');
                update_post_meta($product_id, '_sale_price_dates_to', '');
                update_post_meta($product_id, '_price', $product_price);
                update_post_meta($product_id, '_sold_individually', '');
                update_post_meta($product_id, '_manage_stock', 'yes');
                wc_update_product_stock($product_id, $product_quantity, 'set');
                update_post_meta($product_id, '_backorders', 'no');

                $this->getAndUpdateMedia($product_id, $image_url);



                WC()->frontend_includes();
                WC()->session = new WC_Session_Handler();
                WC()->session->init();
                WC()->customer = new WC_Customer(get_current_user_id(), true);
                WC()->cart = new WC_Cart();
            } else {
                // The post exists
                $product_id = $product_id_check;
                $product_id = wp_update_post(array(
                    'ID' => $product_id,
                    'post_title' => $product_title,
                    'post_type' => 'product',
                    'post_status' => 'publish',
                    'post_content' => $product_title,
                    'post_excerpt' => $product_title,
                    'post_name' => "productarticleno" . $product_sku,
                ));
                $quantity = $this->getProductQuantity($product_sku);
                wp_set_object_terms($product_id, 'simple', 'product_type');
                update_post_meta($product_id, 'product_ean', $product_ean);
                update_post_meta($product_id, '_visibility', 'visible');
                update_post_meta($product_id, '_stock_status', 'instock');
                update_post_meta($product_id, 'total_sales', '0');
                update_post_meta($product_id, '_downloadable', 'no');
                update_post_meta($product_id, '_virtual', 'no');
                update_post_meta($product_id, '_regular_price', $product_price);
                update_post_meta($product_id, '_sale_price', '');
                update_post_meta($product_id, '_purchase_note', '');
                update_post_meta($product_id, '_featured', 'no');
                update_post_meta($product_id, '_weight', 'N/A');
                update_post_meta($product_id, '_length', 'N/A');
                update_post_meta($product_id, '_width', 'N/A');
                update_post_meta($product_id, '_height', 'N/A');
                update_post_meta($product_id, '_sku', $product_sku);
                update_post_meta($product_id, '_product_attributes', array());
                update_post_meta($product_id, '_sale_price_dates_from', '');
                update_post_meta($product_id, '_sale_price_dates_to', '');
                update_post_meta($product_id, '_price', $product_price);
                update_post_meta($product_id, '_sold_individually', '');
                update_post_meta($product_id, '_manage_stock', 'yes');
                wc_update_product_stock($product_id, $product_quantity + $quantity, 'set');
                update_post_meta($product_id, '_backorders', 'no');
                $this->getAndUpdateMedia($product_id, $image_url);



                WC()->frontend_includes();
                WC()->session = new WC_Session_Handler();
                WC()->session->init();
                WC()->customer = new WC_Customer(get_current_user_id(), true);
                //WC()->cart = new WC_Cart();
            }
            WC()->cart->add_to_cart($product_id);
            $cartLink = wc_get_cart_url();
            $returnArray["cart_count"] = WC()->cart->get_cart_contents_count();
            $returnArray["cart_url"] = $cartLink;
            return $returnArray;
        }
    }

    function brodosGetCartCount() {
        register_rest_route('v1/', 'cartcounts', array(
            'methods' => 'GET',
            'callback' => [$this, 'BrodosGetCartCnt']
        ));
    }

    function BrodosGetCartCnt($request_data) {
        WC()->frontend_includes();
        WC()->session = new WC_Session_Handler();
        WC()->session->init();
        WC()->customer = new WC_Customer(get_current_user_id(), true);
        WC()->cart = new WC_Cart();

        $cartLink = wc_get_cart_url();
        $token = wp_create_nonce();
        $returnArray["cart_count"] = WC()->cart->get_cart_contents_count();
        $returnArray["cart_url"] = $cartLink;
        $returnArray["token"] = $token;
        return $returnArray;
    }

    //Adding new custom field for EAN
    function add_ean_input() {
        $args = array(
            'label' => __('EAN', 'woocommerce'),
            'placeholder' => __('Enter EAN here', 'woocommerce'),
            'id' => 'product_ean',
            'desc_tip' => true,
            'description' => __('This EAN is for internal use only.', 'woocommerce'),
        );
        woocommerce_wp_text_input($args);
    }

    function brodosWPCartCountUpdate($fragments) {
        echo '<script>console.log("Cart Count: ' . WC()->cart->get_cart_contents_count() . '");</script>';
        $fragments['div.BrodosWPCartCount'] = '<div class="BrodosWPCartCount">' . WC()->cart->get_cart_contents_count() . '</div>';
        return $fragments;
    }

    /*
     * Disabled fragments due to return wrong cart count
     */

    function brodos_disable_woocommerce_cart_fragments() {
        wp_dequeue_script('wc-cart-fragments');
    }
}

if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    $onlineshopEcommerce = new onlineshopEcommerce;
    add_action('init', array($onlineshopEcommerce, 'add_cors_http_header'));
    add_action('woocommerce_init', array($onlineshopEcommerce, 'force_non_logged_user_wc_session'));
    add_action('rest_api_init', array($onlineshopEcommerce, 'brodosAddToCart'));
    add_action('rest_api_init', array($onlineshopEcommerce, 'brodosGetCartCount'));
    add_action('rest_api_init', array($onlineshopEcommerce, 'brodosGetToken'));
    add_action('woocommerce_product_options_sku', array($onlineshopEcommerce, 'add_ean_input'));
    add_filter('woocommerce_add_to_cart_fragments', array($onlineshopEcommerce, 'brodosWPCartCountUpdate'), 10, 1);
    //add_action('wp_enqueue_scripts', array($onlineshopEcommerce, 'brodos_disable_woocommerce_cart_fragments'), 11);
}
