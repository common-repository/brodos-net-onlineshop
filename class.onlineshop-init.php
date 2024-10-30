<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class onlineshopInit
{
    /*
     * Insert required CSS and JS files
     */

    function brodos_assets()
    {
        wp_enqueue_style('brodos_css', plugins_url('assets/brodos-css.css', __FILE__));
        wp_enqueue_script('brodos_js', plugins_url('assets/brodos-js.js', __FILE__), array('jquery'), '1.0.0', true);
    }

    /*
     * Search code
     */

    function BrodosSearchShortcode()
    {
        $site = get_option('brodos_shop_url');
        $HTML = '';
        if ($site != "") {
            $actionURL = rtrim($site, "/") . '/de/search';
            $HTML .= '<form action="' . $actionURL . '" class="BrodosSearch">';
            $HTML .= '<input placeholder="Suche" required="required" type="text" name="search_api_views_fulltext" size="60" maxlength="128" />';
            $HTML .= '<input value="Suche" type="submit" />';
            $HTML .= '</form>';
        } else {
            $HTML .= '<p style="color: #c00;">Bitte geben Sie die URL Ihres brodos.net-Onlineshops ein, um die Suchfunktion zu nutzen.</p>';
        }
        return $HTML;
    }

    /*
     * Cart code
     */

    function BrodosCartShortcode()
    {
        $site = get_option('brodos_shop_url');
        $HTML = '';
        if ($site != "") {
            $cartURL = rtrim($site, "/") . '/cart';
            $HTML .= '<div class="BrodosCart">';
            $HTML .= '<a class="BrodosCartLink BrodosCartCount" data-site="' . rtrim($site, "/") . '" href="' . $cartURL . '" data-count="0">';
            $HTML .= '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="40pt" height="40pt" viewBox="0 0 40 40" version="1.1"><g id="surface1"><path style=" stroke:none;fill-rule:nonzero;fill:#fff;fill-opacity:1;" d="M 15.714844 34.285156 C 15.714844 35.058594 15.429688 35.730469 14.867188 36.292969 C 14.300781 36.859375 13.632812 37.144531 12.855469 37.144531 C 12.082031 37.144531 11.414062 36.859375 10.847656 36.292969 C 10.28125 35.730469 10 35.058594 10 34.285156 C 10 33.511719 10.28125 32.84375 10.847656 32.277344 C 11.414062 31.710938 12.082031 31.429688 12.855469 31.429688 C 13.632812 31.429688 14.300781 31.710938 14.867188 32.277344 C 15.429688 32.84375 15.714844 33.511719 15.714844 34.285156 Z M 35.714844 34.285156 C 35.714844 35.058594 35.429688 35.730469 34.867188 36.292969 C 34.300781 36.859375 33.632812 37.144531 32.855469 37.144531 C 32.082031 37.144531 31.414062 36.859375 30.847656 36.292969 C 30.28125 35.730469 30 35.058594 30 34.285156 C 30 33.511719 30.28125 32.84375 30.847656 32.277344 C 31.414062 31.710938 32.082031 31.429688 32.855469 31.429688 C 33.632812 31.429688 34.300781 31.710938 34.867188 32.277344 C 35.429688 32.84375 35.714844 33.511719 35.714844 34.285156 Z M 38.570312 10 L 38.570312 21.429688 C 38.570312 21.785156 38.449219 22.101562 38.203125 22.378906 C 37.957031 22.652344 37.65625 22.8125 37.300781 22.855469 L 13.996094 25.582031 C 14.1875 26.472656 14.285156 26.992188 14.285156 27.144531 C 14.285156 27.382812 14.105469 27.855469 13.75 28.570312 L 34.285156 28.570312 C 34.671875 28.570312 35.007812 28.710938 35.289062 28.996094 C 35.574219 29.277344 35.714844 29.613281 35.714844 30 C 35.714844 30.386719 35.574219 30.722656 35.289062 31.003906 C 35.007812 31.289062 34.671875 31.429688 34.285156 31.429688 L 11.429688 31.429688 C 11.042969 31.429688 10.707031 31.289062 10.425781 31.003906 C 10.140625 30.722656 10 30.386719 10 30 C 10 29.835938 10.058594 29.601562 10.179688 29.296875 C 10.296875 28.992188 10.417969 28.722656 10.535156 28.492188 C 10.65625 28.261719 10.816406 27.964844 11.015625 27.601562 C 11.214844 27.234375 11.332031 27.015625 11.363281 26.941406 L 7.410156 8.570312 L 2.855469 8.570312 C 2.46875 8.570312 2.136719 8.429688 1.851562 8.148438 C 1.570312 7.863281 1.429688 7.53125 1.429688 7.144531 C 1.429688 6.757812 1.570312 6.421875 1.851562 6.136719 C 2.136719 5.855469 2.46875 5.714844 2.855469 5.714844 L 8.570312 5.714844 C 8.808594 5.714844 9.023438 5.761719 9.207031 5.859375 C 9.394531 5.957031 9.539062 6.070312 9.644531 6.207031 C 9.746094 6.339844 9.84375 6.523438 9.933594 6.753906 C 10.023438 6.984375 10.082031 7.175781 10.113281 7.332031 C 10.140625 7.488281 10.183594 7.707031 10.234375 7.992188 C 10.285156 8.273438 10.320312 8.46875 10.335938 8.570312 L 37.144531 8.570312 C 37.53125 8.570312 37.863281 8.710938 38.148438 8.996094 C 38.429688 9.277344 38.570312 9.613281 38.570312 10 Z M 38.570312 10 "/></g></svg>';
            $HTML .= '<span class="BrodosCartText"><small>Mein</small><br>Warenkorb</span>';
            $HTML .= '</a>';
            $HTML .= '</div>';
        } else {
            $HTML .= '<p style="color: #c00;">Bitte geben Sie die URL Ihres brodos.net-Onlineshops ein, um die Warenkorbfunktion zu nutzen.</p>';
        }
        return $HTML;
    }

    /*
     * WP Cart code
     */

    function BrodosWPCartShortcode()
    {
        $HTML = '';
        if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
            $cartURL = wc_get_cart_url();
            $HTML .= '<div class="BrodosCart">';
            $HTML .= '<a class="BrodosWPCartLink" href="' . $cartURL . '">';
            $HTML .= '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="40pt" height="40pt" viewBox="0 0 40 40" version="1.1"><g id="surface1"><path style=" stroke:none;fill-rule:nonzero;fill:#fff;fill-opacity:1;" d="M 15.714844 34.285156 C 15.714844 35.058594 15.429688 35.730469 14.867188 36.292969 C 14.300781 36.859375 13.632812 37.144531 12.855469 37.144531 C 12.082031 37.144531 11.414062 36.859375 10.847656 36.292969 C 10.28125 35.730469 10 35.058594 10 34.285156 C 10 33.511719 10.28125 32.84375 10.847656 32.277344 C 11.414062 31.710938 12.082031 31.429688 12.855469 31.429688 C 13.632812 31.429688 14.300781 31.710938 14.867188 32.277344 C 15.429688 32.84375 15.714844 33.511719 15.714844 34.285156 Z M 35.714844 34.285156 C 35.714844 35.058594 35.429688 35.730469 34.867188 36.292969 C 34.300781 36.859375 33.632812 37.144531 32.855469 37.144531 C 32.082031 37.144531 31.414062 36.859375 30.847656 36.292969 C 30.28125 35.730469 30 35.058594 30 34.285156 C 30 33.511719 30.28125 32.84375 30.847656 32.277344 C 31.414062 31.710938 32.082031 31.429688 32.855469 31.429688 C 33.632812 31.429688 34.300781 31.710938 34.867188 32.277344 C 35.429688 32.84375 35.714844 33.511719 35.714844 34.285156 Z M 38.570312 10 L 38.570312 21.429688 C 38.570312 21.785156 38.449219 22.101562 38.203125 22.378906 C 37.957031 22.652344 37.65625 22.8125 37.300781 22.855469 L 13.996094 25.582031 C 14.1875 26.472656 14.285156 26.992188 14.285156 27.144531 C 14.285156 27.382812 14.105469 27.855469 13.75 28.570312 L 34.285156 28.570312 C 34.671875 28.570312 35.007812 28.710938 35.289062 28.996094 C 35.574219 29.277344 35.714844 29.613281 35.714844 30 C 35.714844 30.386719 35.574219 30.722656 35.289062 31.003906 C 35.007812 31.289062 34.671875 31.429688 34.285156 31.429688 L 11.429688 31.429688 C 11.042969 31.429688 10.707031 31.289062 10.425781 31.003906 C 10.140625 30.722656 10 30.386719 10 30 C 10 29.835938 10.058594 29.601562 10.179688 29.296875 C 10.296875 28.992188 10.417969 28.722656 10.535156 28.492188 C 10.65625 28.261719 10.816406 27.964844 11.015625 27.601562 C 11.214844 27.234375 11.332031 27.015625 11.363281 26.941406 L 7.410156 8.570312 L 2.855469 8.570312 C 2.46875 8.570312 2.136719 8.429688 1.851562 8.148438 C 1.570312 7.863281 1.429688 7.53125 1.429688 7.144531 C 1.429688 6.757812 1.570312 6.421875 1.851562 6.136719 C 2.136719 5.855469 2.46875 5.714844 2.855469 5.714844 L 8.570312 5.714844 C 8.808594 5.714844 9.023438 5.761719 9.207031 5.859375 C 9.394531 5.957031 9.539062 6.070312 9.644531 6.207031 C 9.746094 6.339844 9.84375 6.523438 9.933594 6.753906 C 10.023438 6.984375 10.082031 7.175781 10.113281 7.332031 C 10.140625 7.488281 10.183594 7.707031 10.234375 7.992188 C 10.285156 8.273438 10.320312 8.46875 10.335938 8.570312 L 37.144531 8.570312 C 37.53125 8.570312 37.863281 8.710938 38.148438 8.996094 C 38.429688 9.277344 38.570312 9.613281 38.570312 10 Z M 38.570312 10 "/></g></svg>';
            $HTML .= '<span class="BrodosCartText"><small>Mein</small><br>Warenkorb</span>';
            $HTML .= '<div class="BrodosWPCartCount">' . WC()->cart->get_cart_contents_count() . '</div>';
            $HTML .= '</a>';
            $HTML .= '</div>';
        } else {
            $HTML .= '<p style="color: #c00;">Bitte geben Sie die URL Ihres brodos.net-Onlineshops ein, um die Warenkorbfunktion zu nutzen.</p>';
        }
        return $HTML;
    }

    /*
     * WP Newsletter code
     */

    function BrodosWPNewsletterShortcode()
    {
        $newsletterURL = '/newsletter/anmelden';
        $HTML = '<div class="BrodosCart BrodosNewsletter">';
        $HTML .= '<a class="BrodosWPCartLink" href="' . $newsletterURL . '">';
        $HTML .= '<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512" fill="white"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M64 112c-8.8 0-16 7.2-16 16v22.1L220.5 291.7c20.7 17 50.4 17 71.1 0L464 150.1V128c0-8.8-7.2-16-16-16H64zM48 212.2V384c0 8.8 7.2 16 16 16H448c8.8 0 16-7.2 16-16V212.2L322 328.8c-38.4 31.5-93.7 31.5-132 0L48 212.2zM0 128C0 92.7 28.7 64 64 64H448c35.3 0 64 28.7 64 64V384c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V128z"/></svg>';
        $HTML .= '<span class="BrodosCartText"><small>Newsletter</small><br>Anmelden</span>';
        $HTML .= '</a>';
        $HTML .= '</div>';
        return $HTML;
    }

    /*
     * Category code
     */

    function BrodosCategoryShortcode($atts = [], $content = null, $tag = '')
    {
        $type = $atts['type'];
        $url = $atts['url'];
        $data = $atts['data'];
        // start output
        $HTML = '';
        if ($type == 'button') {
            $HTML .= '<a href="' . $url . '" class="brodosCat brodosCatButton">' . $data . '</a>';
        } else if ($type == 'image') {
            $HTML .= '<a href="' . $url . '" class="brodosCat brodosCatImage"><img src="' . $data . '" alt="" /></a>';
        } else if ($type == 'text') {
            $HTML .= '<a href="' . $url . '" class="brodosCat brodosCatText">' . $data . '</a>';
        }
        return $HTML;
    }

    /*
     * Category code
     */

    function BrodosSearchGroupShortcode($atts = [], $content = null, $tag = '')
    {
        $type = $atts['type'];
        $url = $atts['url'];
        $data = $atts['data'];
        // start output
        $HTML = '';
        if ($type == 'button') {
            $HTML .= '<a href="' . $url . '" class="brodosSearchGroup brodosSearchGroupButton">' . $data . '</a>';
        } else if ($type == 'image') {
            $HTML .= '<a href="' . $url . '" class="brodosSearchGroup brodosSearchGroupImage"><img src="' . $data . '" alt="" /></a>';
        } else if ($type == 'text') {
            $HTML .= '<a href="' . $url . '" class="brodosSearchGroup brodosSearchGroupText">' . $data . '</a>';
        }
        return $HTML;
    }

    /*
     * Article code
     */

    function BrodosArticleShortcode($atts = [], $content = null, $tag = '')
    {
        $type = $atts['type'];
        $url = $atts['url'];
        $data = $atts['data'];
        // start output
        $HTML = '';
        if ($type == 'button') {
            $HTML .= '<a href="' . $url . '" class="BrodosArticle BrodosArticleButton">' . $data . '</a>';
        } else if ($type == 'image') {
            $HTML .= '<a href="' . $url . '" class="BrodosArticle BrodosArticleImage"><img src="' . $data . '" alt="" /></a>';
        } else if ($type == 'text') {
            $HTML .= '<a href="' . $url . '" class="BrodosArticle BrodosArticleText">' . $data . '</a>';
        }
        return $HTML;
    }


    /*
     * Additional GA code
     */

    function BrodosGAShortcode()
    {
        $ga_code = get_option('brodos_ga_code');
        $HTML = '';
        if ($ga_code != "") {
?>
            <!-- Google tag (gtag.js) / Additional GA code -->
            <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $ga_code; ?>"></script>
            <script>
                window.dataLayer = window.dataLayer || [];

                function gtag() {
                    dataLayer.push(arguments);
                }
                gtag("js", new Date());
                gtag("config", "<?php echo $ga_code; ?>");
            </script>
<?php
        }
        return $HTML;
    }

    /*
     * Brodos Social Menu
     */
    function BrodosSocialMenuShortcode($atts)
    {
        $color = isset($atts['color']) ? $atts['color'] : 'white';

        $social_icons = array(
            'facebook' => '<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 320 512"><path d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z" fill="' . esc_attr($color) . '" /></svg>',
            'twitter' => '<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z" fill="' . esc_attr($color) . '" /></svg>',
            'linkedin' => '<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><path d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z" fill="' . esc_attr($color) . '" /></svg>',
            'instagram' => '<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z" fill="' . esc_attr($color) . '" /></svg>',
            'youtube' => '<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"><path d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z" fill="' . esc_attr($color) . '" /></svg>'
        );

        $output = '<div class="brodos-social-menu">';
        $output .= '<ul>';
        foreach ($social_icons as $network => $icon) {
            $social_handle_sc = '[sc name="' . $network . '"][/sc]';
            $social_handle_link = do_shortcode($social_handle_sc);
            if ($social_handle_link != "") {
                $output .= '<li><a data-social="' . $network . '" href="' . $social_handle_link . '" target="_blank">' . $icon . '</a></li>';
            }
        }
        $output .= '</ul>';
        $output .= '</div>';

        return $output;
    }

    /*
     * Brodos Social Menu
     */
    function brodosHeroBannerShortcode()
    {
        // Banner Image/s
        $hero_banner_images_urls = jet_engine()->listings->data->get_option('retailer-options::hero-banner-images-urls');
        if ($hero_banner_images_urls != "") {
            $image_urls = explode(',', $hero_banner_images_urls);
            $length = count($image_urls);
            if ($length == 1) {
                $background_image_css = "url('" . $image_urls[0] . "')";
            } else {
                $background_images = array();
                foreach ($image_urls as $url) {
                    $background_images[] = "url('" . trim($url) . "')";
                }
                $background_image_css = implode(', ', $background_images);
            }
        } else {
            $background_image_css = "url('https://bnet-onlineshop.obs.otc.t-systems.com/common/Demo-pic-Header-1.png'),url('https://bnet-onlineshop.obs.otc.t-systems.com/common/Demo-pic-Header-2.png'),url('https://bnet-onlineshop.obs.otc.t-systems.com/common/Demo-pic-Header-3.png'),url('https://bnet-onlineshop.obs.otc.t-systems.com/common/Demo-pic-Header-4.png')";
        }
        // Team Image
        $team_image = jet_engine()->listings->data->get_option('retailer-options::team-image');
        if ($team_image == "") {
            $team_image = 'https://bnet-onlineshop.obs.otc.t-systems.com/common/teamimage_template.png';
        }

        // Service HTML code
        $serviceHTML = "";
        $iconlist_option = jet_engine()->listings->data->get_option('retailer-options::what-to-display-beside-team-image');
        if ($iconlist_option == 'services') {
            $menu_items = wp_get_nav_menu_items('28');
            $menu_items_to_move = array();
            foreach ($menu_items as $key => $menu_item) {
                $menu_item_url = $menu_item->url;
                $menu_item_title = $menu_item->title;
                if (str_contains($menu_item_url, 'vertragsverlaengerung-tarifoptimierung')) {
                    $menu_items_to_move[] = $menu_item;
                    unset($menu_items[$key]);
                }
                if (!str_contains($menu_item_url, '/services/') || str_contains($menu_item_url, 'geschenkgutschein') || $menu_item_title == 'Services') {
                    unset($menu_items[$key]);
                }
            }
            $menu_items = array_merge($menu_items, $menu_items_to_move);
            $serviceHTML .= '<div class="brodos-hero-banner-bottom-right-top-wrap">';
            $serviceHTML .= '<div class="brodos-service-link-wrap">';
            $serviceHTML .= '<a href="/services/" class="brodos-service-link">Wir können helfen...</a>';
            $serviceHTML .= '</div>';
            $serviceHTML .= '</div>';
            $serviceHTML .= '<div class="brodos-hero-banner-bottom-right-middle-wrap"><ul class="brodos-banner-service">';
            foreach ($menu_items as $menu_item) {
                $menu_item_url = $menu_item->url;
                $menu_item_title = $menu_item->title;
                $menu_item_id = $menu_item->ID;
                $menu_item_parent_id = $menu_item->menu_item_parent;
                $serviceHTML .= '<li>
                    <a href="' . $menu_item_url . '">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg>
                        <span>' . $menu_item_title . '</span>
                    </a>
                    </li>';
            }
            $serviceHTML .= '</ul></div>';
            $serviceHTML .= '<div class="brodos-hero-banner-bottom-right-bottom-wrap">';
            $serviceHTML .= '<div class="brodos-service-link-wrap">';
            $serviceHTML .= '<a href="/produkt/beratungstermin/" class="brodos-general-service-link">...vereinbaren Sie jetzt einen Termin!</a>';
            $serviceHTML .= '</div>';
            $serviceHTML .= '</div>';
        } elseif ($iconlist_option == 'custom-html') {
            $custom_html = jet_engine()->listings->data->get_option('retailer-options::custom-html');
            $serviceHTML .= $custom_html;
        }
        /* ./ Menu code */



        $html = "";
        $html .= '<div class="brodos-hero-banner-wrapper">';
        $html .= '<div class="brodos-hero-banner-top-wrap">';
        $html .= '<div class="brodos-hero-banner-top-wrap-background" style="background-image: ' . $background_image_css . '"></div>';
        $html .= '<div class="brodos-hero-banner-top-right-wrapper">';
        $html .= '<div class="brodos_info_wrapper">
            <div class="brodos_info_wrap">
                <div class="brodos_info_icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M48 0C21.5 0 0 21.5 0 48V464c0 26.5 21.5 48 48 48h96V432c0-26.5 21.5-48 48-48s48 21.5 48 48v80h96c26.5 0 48-21.5 48-48V48c0-26.5-21.5-48-48-48H48zM64 240c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H80c-8.8 0-16-7.2-16-16V240zm112-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H176c-8.8 0-16-7.2-16-16V240c0-8.8 7.2-16 16-16zm80 16c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H272c-8.8 0-16-7.2-16-16V240zM80 96h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H80c-8.8 0-16-7.2-16-16V112c0-8.8 7.2-16 16-16zm80 16c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H176c-8.8 0-16-7.2-16-16V112zM272 96h32c8.8 0 16 7.2 16 16v32c0 8.8-7.2 16-16 16H272c-8.8 0-16-7.2-16-16V112c0-8.8 7.2-16 16-16z"/></svg>
                </div>
                <div class="brodos_info_wrap_inner">
                    <ul class="workingTime">
                        <li>' . do_shortcode('[sc name="shop_name" ]') . '</li>
                        <li>' . do_shortcode('[sc name="shop_street" ]') . '</li>
                        <li>' . do_shortcode('[sc name="shop_zipcode_city" ]') . '</li>
                        <li>' . do_shortcode('[sc name="shop_phonenumber_plaintext" ]') . '</li>
                    </ul>
                </div>
            </div>
            <div class="brodos_info_wrap">
                <div class="brodos_info_icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M464 256A208 208 0 1 1 48 256a208 208 0 1 1 416 0zM0 256a256 256 0 1 0 512 0A256 256 0 1 0 0 256zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z"/></svg>
                </div>
                <div class="brodos_info_wrap_inner">
                    <ul class="workingTime">
                        <li>' . do_shortcode('[sc name="shop_business-hours" ]') . '</li>
                        <li>' . do_shortcode('[sc name="shop_mail" ]') . '</li>
                    </ul>
                </div>
            </div>
        </div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="brodos-hero-banner-bottom-wrap">';
        $html .= '<div class="brodos-hero-banner-bottom-left-wrapper">';
        $html .= '<div class="brodos-team-image">';
        $html .= '<img src="' . $team_image . '" alt="" class="">';
        $html .= '<a href="/ueber-uns" target="_self" class="brodos-about-link">&Uuml;ber uns</a>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="brodos-hero-banner-bottom-right-wrapper">';
        $html .= $serviceHTML;
        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }

    function brodosUpdateMediaFunction($option_name)
    {
        // This function is called when a media is updated in the JetEngine options page
        if ($option_name == 'retailer-options_team-image' || $option_name == 'retailer-options_hero-banner-images-urls') {

            // TEAM IMAGE FUNCTION
            if (!function_exists('setTeamImage')) {
                // Declare the function only if it doesn't already exist
                function setTeamImage(&$array, $newUrl)
                {
                    foreach ($array as $key => &$value) {
                        if (is_array($value) && $value['widgetType'] == 'image' && $value['settings']['_element_id'] == 'brodos_team_section') {

                                $team_image_id = attachment_url_to_postid($newUrl);
                                $array[$key]['settings']['image']['url'] = $newUrl;
                                $array[$key]['settings']['image']['id'] = $team_image_id;
                            
                        } elseif (is_array($value)) {
                            setTeamImage($value, $newUrl);
                        }
                    }
                }
            }

            // BANNER SLIDESHOW 
            if (!function_exists('findAndReplaceSlideshowImages')) {
                function findAndReplaceSlideshowImages(&$array, $banner_images_array_all)
                {
                    foreach ($array as $key => &$value) {
                        if (is_array($value) && $value['settings']['_element_id'] == 'brodos_banner_section' ) {

                            $value['settings']['background_slideshow_gallery'] = $banner_images_array_all;

                            $value['settings']['background_image']['url'] = $banner_images_array_all[0]['url'];
                            $value['settings']['background_image']['id'] =  $banner_images_array_all[0]['id'];
                            $value['settings']['background_image']['source'] = 'library';
                
                            $value['settings']['background_background'] = 'slideshow';


                        } elseif (is_array($value)) {
                            findAndReplaceSlideshowImages($value, $banner_images_array_all);
                        }
                    }
                }
            }

            $team_url =  get_option('retailer-options_team-image');
            $slider_images = get_option('retailer-options_hero-banner-images-urls');
            $original_urls = explode(',', $slider_images);
            foreach ($original_urls as $url) {
                $image_id = attachment_url_to_postid($url);
                $banner_images_array[] = array(
                    'id' => $image_id,
                    'url' => $url
                );
            }

            $show_on_front = get_option('show_on_front');
            if ($show_on_front === 'page') {
                $page_to_update = get_option('page_on_front');
                $edata_meta = get_post_meta($page_to_update, '_elementor_data', true);
                if (!empty($edata_meta) && (!empty($banner_images_array) || !empty($team_url))) {
                    if (!is_array($edata_meta)) {
                        $elementor_data = json_decode($edata_meta, true);
                    } else {
                        $elementor_data = $edata_meta;
                    }
                    if ($elementor_data !== null) {
                        // Replace team image use [widgetType] => image and banner slider
                        if (!empty($team_url)) {
                            setTeamImage($elementor_data, $team_url);
                        }

                        if (!empty($banner_images_array)) {
                            findAndReplaceSlideshowImages($elementor_data, $banner_images_array);
                        }

                        $updated_elementor_data = json_encode($elementor_data);

                        // Save updated JSON on _elementor_data
                        global $wpdb;
                        $wpdb->query($wpdb->prepare(
                            "UPDATE $wpdb->postmeta SET meta_value = %s WHERE post_id = %d AND meta_key = '_elementor_data'",
                            $updated_elementor_data,
                            $page_to_update
                        ));

                        // echo 'Page updated.';

                        if (class_exists('Elementor\Plugin')) {
                            \Elementor\Plugin::$instance->files_manager->clear_cache();
                            \Elementor\Plugin::$instance->files_manager->clear_cache('script');
                            // echo 'Elementor cache cleared successfully.';
                        } else {
                            // echo 'Elementor is not active.';
                        }

                        // Clear cache.
                        if ( function_exists( 'rocket_clean_domain' ) ) {
                            rocket_clean_domain();
                        }

                        // Preload cache.
                        if ( function_exists( 'run_rocket_sitemap_preload' ) ) {
                            run_rocket_sitemap_preload();
                        }
                    }
                }
            }
        }
    }
}

$onlineshopInit = new onlineshopInit;
add_action('wp_enqueue_scripts', array($onlineshopInit, 'brodos_assets'));
add_shortcode('BrodosSearch', array($onlineshopInit, 'BrodosSearchShortcode'));
add_shortcode('BrodosCart', array($onlineshopInit, 'BrodosCartShortcode'));
add_shortcode('BrodosWPCart', array($onlineshopInit, 'BrodosWPCartShortcode'));
add_shortcode('BrodosNewsletter', array($onlineshopInit, 'BrodosWPNewsletterShortcode'));
add_shortcode('BrodosCategory', array($onlineshopInit, 'BrodosCategoryShortcode'));
add_shortcode('BrodosSearchGroup', array($onlineshopInit, 'BrodosSearchGroupShortcode'));
add_shortcode('BrodosArticle', array($onlineshopInit, 'BrodosArticleShortcode'));
add_action('wp_footer', array($onlineshopInit, 'BrodosGAShortcode'));
add_shortcode('BrodosSocialMenu', array($onlineshopInit, 'BrodosSocialMenuShortcode'));
add_shortcode('brodosHeroBanner', array($onlineshopInit, 'brodosHeroBannerShortcode'));
add_action('updated_option', array($onlineshopInit, 'brodosUpdateMediaFunction'));
