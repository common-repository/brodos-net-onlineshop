<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class onlineshopMenu {

    /**
     * Add menu meta box
     *
     * @param object $object The meta box object
     * @link https://developer.wordpress.org/reference/functions/add_meta_box/
     */
    function brodos_cat_menu_meta_box($object) {
        add_meta_box('brodos-cat-metabox', __('Brodos Categories'), array($this, 'brodos_cat_menu_meta'), 'nav-menus', 'side', 'default');
        return $object;
    }

    /**
     * Displays a metabox for Brodos OnlineShop functionality.
     *
     * @global int|string $nav_menu_selected_id (id, name or slug) of the currently-selected menu
     *
     * @link https://core.trac.wordpress.org/browser/tags/4.5/src/wp-admin/includes/nav-menu.php
     * @link https://core.trac.wordpress.org/browser/tags/4.5/src/wp-admin/includes/class-walker-nav-menu-edit.php
     * @link https://core.trac.wordpress.org/browser/tags/4.5/src/wp-admin/includes/class-walker-nav-menu-checklist.php
     */
    public function brodos_cat_menu_meta() {
        register_post_type('brodos_category', array(
            'labels' => array(
                'name' => __('brodos_category'),
                'singular_name' => __('brodos_category')
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'brodos_category')
                )
        );
        global $nav_menu_selected_id;
        $walker = new Walker_Nav_Menu_Checklist();
        $brodosCatArgs = array(
            'post_type' => 'brodos_category',
            'post_status' => 'any',
            'numberposts' => -1
        );
        $brodosCatPosts = get_posts($brodosCatArgs);
        $brodosCatFinal = array();
        $brodosCatFinalRecent = array();
        $count = 0;
        if (!empty($brodosCatPosts)) {
            foreach ($brodosCatPosts as &$brodosCatPost) {
                $brodosCatPost->classes = array('brodosCatMenu');
                $brodosCatPost->type = 'custom';
                $brodosCatPost->object_id = $brodosCatPost->ID;
                $brodosCatPost->title = $brodosCatPost->post_title;
                $brodosCatPost->object = 'custom';
                $brodosCatPost->url = get_post_meta($brodosCatPost->ID, 'brodos_category_link', true);
                $brodosCatPost->guid = get_post_meta($brodosCatPost->ID, 'brodos_category_link', true);
                $brodosCatFinal[] = $brodosCatPost;
                if ($count < 5) {
                    $brodosCatFinalRecent[] = $brodosCatPost;
                }
                $count++;
            }
        }
        $current_tab = 'recent';
        if (isset($_REQUEST['brodoscat-tab']) && 'recent' == $_REQUEST['brodoscat-tab']) {
            $current_tab = 'recent';
        } elseif (isset($_REQUEST['brodoscat-tab']) && 'all' == $_REQUEST['brodoscat-tab']) {
            $current_tab = 'all';
        }

        $removed_args = array('action', 'customlink-tab', 'edit-menu-item', 'menu-item', 'page-tab', '_wpnonce');
        ?>
        <div id="brodoscategory" class="brodoscatdiv categorydiv">
            <ul id="brodoscat-tabs" class="brodoscat-tabs add-menu-item-tabs">
                <li <?php echo ( 'recent' == $current_tab ? ' class="tabs"' : '' ); ?>>
                    <a class="nav-tab-link" data-type="tabs-panel-brodoscategory-recent" href="<?php if ($nav_menu_selected_id) echo esc_url(add_query_arg('brodoscat-tab', 'recent', remove_query_arg($removed_args))); ?>#tabs-panel-brodoscategory-recent">
                        <?php _e('Most Recent'); ?>
                    </a>
                </li>
                <li <?php echo ( 'all' == $current_tab ? ' class="tabs"' : '' ); ?>>
                    <a class="nav-tab-link" data-type="tabs-panel-brodoscategory-all" href="<?php if ($nav_menu_selected_id) echo esc_url(add_query_arg('brodoscat-tab', 'all', remove_query_arg($removed_args))); ?>#tabs-panel-brodoscategory-all">
                        <?php _e('View All'); ?>
                    </a>
                </li>
            </ul>
            <div id="tabs-panel-brodoscategory-recent" class="tabs-panel tabs-panel-view-recent <?php echo ( 'recent' == $current_tab ? 'tabs-panel-active' : 'tabs-panel-inactive' ); ?>">
                <ul id="brodoscategory-checklist-recent" class="categorychecklist form-no-clear">
                    <?php
                    if (!empty($brodosCatFinalRecent)) {
                        echo walk_nav_menu_tree($brodosCatFinalRecent, 0, (object) array('walker' => $walker));
                    } else {
                        ?>
                        <li><?php _e('No results found.'); ?></li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
            <div id="tabs-panel-brodoscategory-all" class="tabs-panel tabs-panel-view-all <?php echo ( 'all' == $current_tab ? 'tabs-panel-active' : 'tabs-panel-inactive' ); ?>">
                <ul id="brodoscategory-checklist-all" class="categorychecklist form-no-clear">
                    <?php
                    if (!empty($brodosCatFinal)) {
                        echo walk_nav_menu_tree($brodosCatFinal, 0, (object) array('walker' => $walker));
                    } else {
                        ?>
                        <li><?php _e('No results found.'); ?></li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
            <p class="button-controls wp-clearfix" data-items-type="brodoscategory">
                <span class="list-controls hide-if-no-js">
                    <input type="checkbox" id="brodos-cat-tab" class="select-all">
                    <label for="brodos-cat-tab"><?php _e('Select All'); ?></label>
                </span>
                <span class="add-to-menu">
                    <input type="submit"<?php wp_nav_menu_disabled_check($nav_menu_selected_id); ?> class="button-secondary submit-add-to-menu right" value="<?php esc_attr_e('Add to Menu'); ?>" name="add-brodoscategory-menu-item" id="submit-brodoscategory" />
                    <span class="spinner"></span>
                </span>
            </p>
        </div>
        <?php
    }

    /**
     * Brodos Product Grouping Menu linking
     */
    function brodos_product_group_menu_meta_box($object) {
        add_meta_box('brodos-pro-group-metabox', __('Brodos Product Grouping'), array($this, 'brodos_product_group_menu_meta'), 'nav-menus', 'side', 'default');
        return $object;
    }

    public function brodos_product_group_menu_meta() {
        register_post_type('brodos_prod_group', array(
            'labels' => array(
                'name' => __('brodos_prod_group'),
                'singular_name' => __('brodos_prod_group')
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'brodos_prod_group')
                )
        );
        global $nav_menu_selected_id;
        $walker = new Walker_Nav_Menu_Checklist();
        $brodosProductGroupArgs = array(
            'post_type' => 'brodos_prod_group',
            'post_status' => 'any',
            'numberposts' => -1
        );
        $brodosProductGroupPosts = get_posts($brodosProductGroupArgs);
        $brodosProductGroupFinal = array();
        $brodosProductGroupFinalRecent = array();
        $count = 0;
        if (!empty($brodosProductGroupPosts)) {
            foreach ($brodosProductGroupPosts as &$brodosProductGroup) {
                $brodosProductGroup->classes = array('brodosProductGroupMenu');
                $brodosProductGroup->type = 'custom';
                $brodosProductGroup->object_id = $brodosProductGroup->ID;
                $brodosProductGroup->title = $brodosProductGroup->post_title;
                $brodosProductGroup->object = 'custom';
                $brodosProductGroup->url = get_post_meta($brodosProductGroup->ID, 'brodos_prod_group_link', true);
                $brodosProductGroup->guid = get_post_meta($brodosProductGroup->ID, 'brodos_prod_group_link', true);
                $brodosProductGroupFinal[] = $brodosProductGroup;
                if ($count < 5) {
                    $brodosProductGroupFinalRecent[] = $brodosProductGroup;
                }
                $count++;
            }
        }
        $current_tab = 'recent';
        if (isset($_REQUEST['brodosprodgroup-tab']) && 'recent' == $_REQUEST['brodosprodgroup-tab']) {
            $current_tab = 'recent';
        } elseif (isset($_REQUEST['brodosprodgroup-tab']) && 'all' == $_REQUEST['brodosprodgroup-tab']) {
            $current_tab = 'all';
        }

        $removed_args = array('action', 'customlink-tab', 'edit-menu-item', 'menu-item', 'page-tab', '_wpnonce');
        ?>
        <div id="brodosProductGroup" class="brodosprodgroupdiv categorydiv">
            <ul id="brodosprodgroup-tabs" class="brodosprodgroup-tabs add-menu-item-tabs">
                <li <?php echo ( 'recent' == $current_tab ? ' class="tabs"' : '' ); ?>>
                    <a class="nav-tab-link" data-type="tabs-panel-brodosProductGroup-recent" href="<?php if ($nav_menu_selected_id) echo esc_url(add_query_arg('brodosprodgroup-tab', 'recent', remove_query_arg($removed_args))); ?>#tabs-panel-brodosProductGroup-recent">
                        <?php _e('Most Recent'); ?>
                    </a>
                </li>
                <li <?php echo ( 'all' == $current_tab ? ' class="tabs"' : '' ); ?>>
                    <a class="nav-tab-link" data-type="tabs-panel-brodosProductGroup-all" href="<?php if ($nav_menu_selected_id) echo esc_url(add_query_arg('brodosprodgroup-tab', 'all', remove_query_arg($removed_args))); ?>#tabs-panel-brodosProductGroup-all">
                        <?php _e('View All'); ?>
                    </a>
                </li>
            </ul>
            <div id="tabs-panel-brodosProductGroup-recent" class="tabs-panel tabs-panel-view-recent <?php echo ( 'recent' == $current_tab ? 'tabs-panel-active' : 'tabs-panel-inactive' ); ?>">
                <ul id="brodosProductGroup-checklist-recent" class="categorychecklist form-no-clear">
                    <?php
                    if (!empty($brodosProductGroupFinalRecent)) {
                        echo walk_nav_menu_tree($brodosProductGroupFinalRecent, 0, (object) array('walker' => $walker));
                    } else {
                        ?>
                        <li><?php _e('No results found.'); ?></li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
            <div id="tabs-panel-brodosProductGroup-all" class="tabs-panel tabs-panel-view-all <?php echo ( 'all' == $current_tab ? 'tabs-panel-active' : 'tabs-panel-inactive' ); ?>">
                <ul id="brodosProductGroup-checklist-all" class="categorychecklist form-no-clear">
                    <?php
                    if (!empty($brodosProductGroupFinal)) {
                        echo walk_nav_menu_tree($brodosProductGroupFinal, 0, (object) array('walker' => $walker));
                    } else {
                        ?>
                        <li><?php _e('No results found.'); ?></li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
            <p class="button-controls wp-clearfix" data-items-type="brodosProductGroup">
                <span class="list-controls hide-if-no-js">
                    <input type="checkbox" id="brodos-prod-group-tab" class="select-all">
                    <label for="brodos-prod-group-tab"><?php _e('Select All'); ?></label>
                </span>
                <span class="add-to-menu">
                    <input type="submit"<?php wp_nav_menu_disabled_check($nav_menu_selected_id); ?> class="button-secondary submit-add-to-menu right" value="<?php esc_attr_e('Add to Menu'); ?>" name="add-brodosProductGroup-menu-item" id="submit-brodosProductGroup" />
                    <span class="spinner"></span>
                </span>
            </p>
        </div>
        <?php
    }

    /**
     * Brodos Article Menu linking
     */
    function brodos_article_menu_meta_box($object) {
        add_meta_box('brodos-article-metabox', __('Brodos Articles'), array($this, 'brodos_article_menu_meta'), 'nav-menus', 'side', 'default');
        return $object;
    }

    public function brodos_article_menu_meta() {
        register_post_type('brodos_article', array(
            'labels' => array(
                'name' => __('brodos_article'),
                'singular_name' => __('brodos_article')
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'brodos_article')
                )
        );
        global $nav_menu_selected_id;
        $walker = new Walker_Nav_Menu_Checklist();
        $brodosArticleArgs = array(
            'post_type' => 'brodos_article',
            'post_status' => 'any',
            'numberposts' => -1
        );
        $brodosArticlePosts = get_posts($brodosArticleArgs);
        $brodosArticleFinal = array();
        $brodosArticleFinalRecent = array();
        $count = 0;
        if (!empty($brodosArticlePosts)) {
            foreach ($brodosArticlePosts as &$brodosArticle) {
                $brodosArticle->classes = array('brodosArticleMenu');
                $brodosArticle->type = 'custom';
                $brodosArticle->object_id = $brodosArticle->ID;
                $brodosArticle->title = $brodosArticle->post_title;
                $brodosArticle->object = 'custom';
                $brodosArticle->url = get_post_meta($brodosArticle->ID, 'brodos_article_link', true);
                $brodosArticle->guid = get_post_meta($brodosArticle->ID, 'brodos_article_link', true);
                $brodosArticleFinal[] = $brodosArticle;
                if ($count < 5) {
                    $brodosArticleFinalRecent[] = $brodosArticle;
                }
                $count++;
            }
        }
        $current_tab = 'recent';
        if (isset($_REQUEST['brodosarticle-tab']) && 'recent' == $_REQUEST['brodosarticle-tab']) {
            $current_tab = 'recent';
        } elseif (isset($_REQUEST['brodosarticle-tab']) && 'all' == $_REQUEST['brodosarticle-tab']) {
            $current_tab = 'all';
        }

        $removed_args = array('action', 'customlink-tab', 'edit-menu-item', 'menu-item', 'page-tab', '_wpnonce');
        ?>
        <div id="brodosArticle" class="brodosarticlediv categorydiv">
            <ul id="brodosarticle-tabs" class="brodosarticle-tabs add-menu-item-tabs">
                <li <?php echo ( 'recent' == $current_tab ? ' class="tabs"' : '' ); ?>>
                    <a class="nav-tab-link" data-type="tabs-panel-brodosArticle-recent" href="<?php if ($nav_menu_selected_id) echo esc_url(add_query_arg('brodosarticle-tab', 'recent', remove_query_arg($removed_args))); ?>#tabs-panel-brodosArticle-recent">
        <?php _e('Most Recent'); ?>
                    </a>
                </li>
                <li <?php echo ( 'all' == $current_tab ? ' class="tabs"' : '' ); ?>>
                    <a class="nav-tab-link" data-type="tabs-panel-brodosArticle-all" href="<?php if ($nav_menu_selected_id) echo esc_url(add_query_arg('brodosarticle-tab', 'all', remove_query_arg($removed_args))); ?>#tabs-panel-brodosArticle-all">
                        <?php _e('View All'); ?>
                    </a>
                </li>
            </ul>
            <div id="tabs-panel-brodosArticle-recent" class="tabs-panel tabs-panel-view-recent <?php echo ( 'recent' == $current_tab ? 'tabs-panel-active' : 'tabs-panel-inactive' ); ?>">
                <ul id="brodosArticle-checklist-recent" class="categorychecklist form-no-clear">
                        <?php
                        if (!empty($brodosArticleFinalRecent)) {
                            echo walk_nav_menu_tree($brodosArticleFinalRecent, 0, (object) array('walker' => $walker));
                        } else {
                            ?>
                        <li><?php _e('No results found.'); ?></li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
            <div id="tabs-panel-brodosArticle-all" class="tabs-panel tabs-panel-view-all <?php echo ( 'all' == $current_tab ? 'tabs-panel-active' : 'tabs-panel-inactive' ); ?>">
                <ul id="brodosArticle-checklist-all" class="categorychecklist form-no-clear">
                    <?php
                    if (!empty($brodosArticleFinal)) {
                        echo walk_nav_menu_tree($brodosArticleFinal, 0, (object) array('walker' => $walker));
                    } else {
                        ?>
                        <li><?php _e('No results found.'); ?></li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
            <p class="button-controls wp-clearfix" data-items-type="brodosArticle">
                <span class="list-controls hide-if-no-js">
                    <input type="checkbox" id="brodos-article-tab" class="select-all">
                    <label for="brodos-article-tab"><?php _e('Select All'); ?></label>
                </span>
                <span class="add-to-menu">
                    <input type="submit"<?php wp_nav_menu_disabled_check($nav_menu_selected_id); ?> class="button-secondary submit-add-to-menu right" value="<?php esc_attr_e('Add to Menu'); ?>" name="add-brodosArticle-menu-item" id="submit-brodosArticle" />
                    <span class="spinner"></span>
                </span>
            </p>
        </div>
        <?php
    }

}

$onlineshopMenu = new onlineshopMenu;
add_filter('nav_menu_meta_box_object', array($onlineshopMenu, 'brodos_cat_menu_meta_box'), 10, 1);
add_filter('nav_menu_meta_box_object', array($onlineshopMenu, 'brodos_product_group_menu_meta_box'), 10, 1);
add_filter('nav_menu_meta_box_object', array($onlineshopMenu, 'brodos_article_menu_meta_box'), 10, 1);