<?php
/**
 * Theme functions and definitions.
 *
 * For additional information on potential customization options,
 * read the developers' documentation:
 *
 * https://developers.elementor.com/docs/hello-elementor-theme/
 *
 * @package HelloElementorChild
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

define('HELLO_ELEMENTOR_CHILD_VERSION', '2.0.0');

/**
 * Load child theme scripts & styles.
 *
 * @return void
 */
function hello_elementor_child_scripts_styles()
{

    wp_enqueue_style(
        'hello-elementor-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        [
            'hello-elementor-theme-style',
        ],
        HELLO_ELEMENTOR_CHILD_VERSION
    );

    wp_enqueue_style(
        'custom-swiper-style',
        get_stylesheet_directory_uri() . '/assets/css/swiper-bundle.min.css',
        [],
        '1.0',
        'all'
    );

    wp_enqueue_style('custome-style', get_stylesheet_directory_uri() . '/assets/css/custom.css', array(), '1.0', 'all');

    wp_enqueue_script(
        'swiper-bundle-min-js',
        trailingslashit(get_stylesheet_directory_uri()) . 'assets/js/swiper-bundle.min.js',
        ['jquery'],
        wp_get_theme()->get('Version'),
        true
    );

    wp_enqueue_script(
        'product-filter-dropdown',
        get_stylesheet_directory_uri() . '/assets/js/product-filter.js',
        [],
        null,
        true
    );

    wp_enqueue_script(
        'child-custom-js',
        trailingslashit(get_stylesheet_directory_uri()) . 'assets/js/custom.js',
        ['jquery'],
        wp_get_theme()->get('Version'),
        true
    );

}
add_action('wp_enqueue_scripts', 'hello_elementor_child_scripts_styles', 20);

//Stop Elementor / ACF meta from being copied to revisions
add_filter('wp_save_post_revision_post_has_meta', '__return_false');

//this code for allow specific svg file
function cc_mime_types($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}

add_filter('upload_mimes', 'cc_mime_types');

function register_products_cpt()
{

    register_post_type(
        'products',
        array(
            'labels' => array(
                'name' => 'Products',
                'singular_name' => 'Product',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Product',
                'edit_item' => 'Edit Product',
                'new_item' => 'New Product',
                'view_item' => 'View Product',
                'search_items' => 'Search Products',
                'not_found' => 'No products found',
                'not_found_in_trash' => 'No products found in Trash',
                'menu_name' => 'Products',
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'products'),
            'show_in_rest' => true,
            'menu_position' => 5,
            'menu_icon' => 'dashicons-cart',
            'supports' => array(
                'title',
                'editor',
                'thumbnail',
                'excerpt',
                'page-attributes',
                'comments',
            ),
        )
    );

    // Register Categories for Products
    register_taxonomy(
        'product_category',
        'products',
        array(
            'labels' => array(
                'name' => 'Product Categories',
                'singular_name' => 'Product Category',
                'search_items' => 'Search Categories',
                'all_items' => 'All Categories',
                'parent_item' => 'Parent Category',
                'parent_item_colon' => 'Parent Category:',
                'edit_item' => 'Edit Category',
                'update_item' => 'Update Category',
                'add_new_item' => 'Add New Category',
                'new_item_name' => 'New Category Name',
                'menu_name' => 'Categories',
            ),
            'hierarchical' => true,
            // Like normal categories
            'public' => true,
            'show_admin_column' => true,
            'show_in_rest' => true,
            'supports' => ['title', 'editor', 'thumbnail'],
            'rewrite' => array('slug' => 'product-category'),
        )
    );
}
add_action('init', 'register_products_cpt');


function register_recipe_cpt()
{

    // Register Recipe CPT
    register_post_type(
        'recipe',
        array(
            'labels' => array(
                'name' => 'Recipes',
                'singular_name' => 'Recipe',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Recipe',
                'edit_item' => 'Edit Recipe',
                'new_item' => 'New Recipe',
                'view_item' => 'View Recipe',
                'search_items' => 'Search Recipes',
                'not_found' => 'No recipes found',
                'not_found_in_trash' => 'No recipes found in Trash',
                'menu_name' => 'Recipes',
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'recipes'),
            'show_in_rest' => true,
            // Gutenberg + Elementor
            'menu_position' => 6,
            'menu_icon' => 'dashicons-carrot',
            'supports' => array(
                'title',
                'editor',
                'thumbnail',
                'excerpt',
                'page-attributes',
                'comments',
                // enables reviews/comments
            ),
        )
    );

    // Register Recipe Categories
    register_taxonomy(
        'recipe_category',
        'recipe',
        array(
            'labels' => array(
                'name' => 'Recipe Categories',
                'singular_name' => 'Recipe Category',
                'search_items' => 'Search Categories',
                'all_items' => 'All Categories',
                'parent_item' => 'Parent Category',
                'parent_item_colon' => 'Parent Category:',
                'edit_item' => 'Edit Category',
                'update_item' => 'Update Category',
                'add_new_item' => 'Add New Category',
                'new_item_name' => 'New Category Name',
                'menu_name' => 'Categories',
            ),
            'hierarchical' => true,
            'public' => true,
            'show_admin_column' => true,
            'show_in_rest' => true,
            'rewrite' => array('slug' => 'recipe-category'),
        )
    );
}

add_action('init', 'register_recipe_cpt');

function register_shared_taxonomies()
{

    register_taxonomy('flavour_profile', ['products'], [
        'labels' => [
            'name' => 'Flavor Profile',
            'singular_name' => 'Flavor Profile',
        ],
        'hierarchical' => true,
        'public' => true,
        'show_admin_column' => true,
        'show_in_rest' => true,
        'rewrite' => ['slug' => 'flavor-profile'],
    ]);

    register_taxonomy('spicy_level', ['products'], [
        'labels' => [
            'name' => 'Spicy Levels',
            'singular_name' => 'Spicy Level',
        ],
        'hierarchical' => false,
        'public' => true,
        'show_admin_column' => true,
        'show_in_rest' => true,
        'rewrite' => ['slug' => 'spicy-level'],
    ]);

    register_taxonomy('dietary_preference', ['products'], [
        'labels' => [
            'name' => 'Dietary Preferences',
            'singular_name' => 'Dietary Preference',
        ],
        'hierarchical' => true,
        'public' => true,
        'show_admin_column' => true,
        'show_in_rest' => true,
        'rewrite' => ['slug' => 'dietary-preference'],
    ]);
}
add_action('init', 'register_shared_taxonomies');


//--------------- PRODUCT FILTER --------------------
function product_filter()
{
    ?>
    <div class="product-filter-wrapper">

        <button type="button" class="filter-toggle" aria-label="Open filters">
            <svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M12.9105 0.595641C12.8336 0.417836 12.706 0.266576 12.5438 0.160675C12.3816 0.0547745 12.1918 -0.00109474 11.998 1.62529e-05H0.99803C0.804487 0.000397602 0.615214 0.0569351 0.453171 0.16277C0.291128 0.268606 0.163279 0.41919 0.0851347 0.596256C0.00699009 0.773322 -0.0180924 0.969261 0.0129302 1.1603C0.0439527 1.35134 0.129747 1.52928 0.259905 1.67252L0.264905 1.67814L4.49803 6.19814V11C4.49799 11.181 4.54706 11.3586 4.64003 11.5139C4.73299 11.6692 4.86635 11.7963 5.0259 11.8818C5.18544 11.9672 5.36519 12.0078 5.54596 11.9991C5.72674 11.9904 5.90178 11.9328 6.05241 11.8325L8.05241 10.4988C8.18951 10.4074 8.30193 10.2837 8.37967 10.1384C8.45741 9.99319 8.49807 9.831 8.49803 9.66627V6.19814L12.7318 1.67814L12.7368 1.67252C12.8683 1.52993 12.9549 1.35176 12.9858 1.16025C13.0167 0.968733 12.9905 0.772361 12.9105 0.595641ZM7.63428 5.66127C7.54778 5.75297 7.49912 5.87396 7.49803 6.00002V9.66627L5.49803 11V6.00002C5.49807 5.87305 5.4498 5.75083 5.36303 5.65814L0.99803 1.00002H11.998L7.63428 5.66127Z"
                    fill="black" />
            </svg>

        </button>
        <div class="blank_div"></div>
        <form method="get" class="product-filters">
            <button type="button" class="close-filter">
                <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M14.781 13.7198C14.8507 13.7895 14.906 13.8722 14.9437 13.9632C14.9814 14.0543 15.0008 14.1519 15.0008 14.2504C15.0008 14.349 14.9814 14.4465 14.9437 14.5376C14.906 14.6286 14.8507 14.7114 14.781 14.781C14.7114 14.8507 14.6286 14.906 14.5376 14.9437C14.4465 14.9814 14.349 15.0008 14.2504 15.0008C14.1519 15.0008 14.0543 14.9814 13.9632 14.9437C13.8722 14.906 13.7895 14.8507 13.7198 14.781L7.50042 8.56073L1.28104 14.781C1.14031 14.9218 0.94944 15.0008 0.750417 15.0008C0.551394 15.0008 0.360523 14.9218 0.219792 14.781C0.0790615 14.6403 3.92322e-09 14.4494 0 14.2504C-3.92322e-09 14.0514 0.0790615 13.8605 0.219792 13.7198L6.4401 7.50042L0.219792 1.28104C0.0790615 1.14031 0 0.94944 0 0.750417C0 0.551394 0.0790615 0.360523 0.219792 0.219792C0.360523 0.0790615 0.551394 0 0.750417 0C0.94944 0 1.14031 0.0790615 1.28104 0.219792L7.50042 6.4401L13.7198 0.219792C13.8605 0.0790615 14.0514 -3.92322e-09 14.2504 0C14.4494 3.92322e-09 14.6403 0.0790615 14.781 0.219792C14.9218 0.360523 15.0008 0.551394 15.0008 0.750417C15.0008 0.94944 14.9218 1.14031 14.781 1.28104L8.56073 7.50042L14.781 13.7198Z"
                        fill="currentColor" />
                </svg>
            </button>
            <label>Filter :</label>

            <div class="custom-dropdown" data-name="category">
                <button type="button" class="dropdown-toggle">
                    <span class="dropdown-label">
                        <?php
                        if (!empty($_GET['category'])) {
                            $term = get_term_by('slug', $_GET['category'], 'product_category');
                            echo esc_html($term->name ?? 'Category');
                        } else {
                            echo 'Category';
                        }
                        ?>
                    </span>
                </button>

                <ul class="dropdown-list">
                    <li data-value="">Category</li>
                    <?php foreach (get_terms('product_category') as $term): ?>
                        <li data-value="<?= esc_attr($term->slug); ?>">
                            <?= esc_html($term->name); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <input type="hidden" name="category" value="<?= esc_attr($_GET['category'] ?? ''); ?>">
            </div>

            <div class="custom-dropdown" data-name="flavor">
                <button type="button" class="dropdown-toggle">
                    <span class="dropdown-label">
                        <?php
                        if (!empty($_GET['flavor'])) {
                            $term = get_term_by('slug', $_GET['flavor'], 'flavour_profile');
                            echo esc_html($term->name ?? 'Flavor Profile');
                        } else {
                            echo 'Flavor Profile';
                        }
                        ?>
                    </span>
                </button>

                <ul class="dropdown-list">
                    <li data-value="">Flavor Profile</li>
                    <?php foreach (get_terms('flavour_profile') as $term): ?>
                        <li data-value="<?= esc_attr($term->slug); ?>">
                            <?= esc_html($term->name); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <input type="hidden" name="flavor" value="<?= esc_attr($_GET['flavor'] ?? ''); ?>">
            </div>
            <div class="custom-dropdown" data-name="spicy">
                <button type="button" class="dropdown-toggle">
                    <span class="dropdown-label">
                        <?php
                        if (!empty($_GET['spicy'])) {
                            $term = get_term_by('slug', $_GET['spicy'], 'spicy_level');
                            echo esc_html($term->name ?? 'Spicy Level');
                        } else {
                            echo 'Spicy Level';
                        }
                        ?>
                    </span>
                </button>

                <ul class="dropdown-list">
                    <li data-value="">Spicy Level</li>
                    <?php foreach (get_terms('spicy_level') as $term): ?>
                        <li data-value="<?= esc_attr($term->slug); ?>">
                            <?= esc_html($term->name); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <input type="hidden" name="spicy" value="<?= esc_attr($_GET['spicy'] ?? ''); ?>">
            </div>

            <div class="custom-dropdown" data-name="diet">
                <button type="button" class="dropdown-toggle">
                    <span class="dropdown-label">
                        <?php
                        if (!empty($_GET['diet'])) {
                            $term = get_term_by('slug', $_GET['diet'], 'dietary_preference');
                            echo esc_html($term->name ?? 'Dietary Preference');
                        } else {
                            echo 'Dietary Preference';
                        }
                        ?>
                    </span>
                </button>

                <ul class="dropdown-list">
                    <li data-value="">Dietary Preference</li>
                    <?php foreach (get_terms('dietary_preference') as $term): ?>
                        <li data-value="<?= esc_attr($term->slug); ?>">
                            <?= esc_html($term->name); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <input type="hidden" name="diet" value="<?= esc_attr($_GET['diet'] ?? ''); ?>">
            </div>
        </form>
    </div>
    <?php
}
add_shortcode('product_filter', 'product_filter');


add_action('pre_get_posts', function ($query) {

    if (
        is_admin() ||
        !$query->is_main_query()
    ) {
        return;
    }

    if (
        !(
            $query->is_post_type_archive(['products', 'recipe']) ||
            $query->is_tax()
        )
    ) {
        return;
    }
    $tax_query = [];

    if (!empty($_GET['category'])) {
        $tax_query[] = [
            'taxonomy' => 'product_category',
            'field' => 'slug',
            'terms' => sanitize_text_field($_GET['category']),
        ];
    }

    if (!empty($_GET['flavor'])) {
        $tax_query[] = [
            'taxonomy' => 'flavour_profile',
            'field' => 'slug',
            'terms' => sanitize_text_field($_GET['flavor']),
        ];
    }

    if (!empty($_GET['spicy'])) {
        $tax_query[] = [
            'taxonomy' => 'spicy_level',
            'field' => 'slug',
            'terms' => sanitize_text_field($_GET['spicy']),
        ];
    }

    if (!empty($_GET['diet'])) {
        $tax_query[] = [
            'taxonomy' => 'dietary_preference',
            'field' => 'slug',
            'terms' => sanitize_text_field($_GET['diet']),
        ];
    }

    if ($tax_query) {
        $query->set('tax_query', array_merge(['relation' => 'AND'], $tax_query));
    }

    if (!empty($_GET['sort'])) {
        if ($_GET['sort'] === 'name_asc') {
            $query->set('orderby', 'title');
            $query->set('order', 'ASC');
        } elseif ($_GET['sort'] === 'name_desc') {
            $query->set('orderby', 'title');
            $query->set('order', 'DESC');
        }
    }
});


//----------- PRODUCT FILTER-- END--------------
function recipe_filter()
{

    $products = get_posts([
        'post_type' => 'products',
        'posts_per_page' => -1,
        'orderby' => 'title',
        'order' => 'ASC',
    ]);
    ?>
    <div class="product-filter-wrapper">

        <button type="button" class="filter-toggle" aria-label="Open filters">
            <svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M12.9105 0.595641C12.8336 0.417836 12.706 0.266576 12.5438 0.160675C12.3816 0.0547745 12.1918 -0.00109474 11.998 1.62529e-05H0.99803C0.804487 0.000397602 0.615214 0.0569351 0.453171 0.16277C0.291128 0.268606 0.163279 0.41919 0.0851347 0.596256C0.00699009 0.773322 -0.0180924 0.969261 0.0129302 1.1603C0.0439527 1.35134 0.129747 1.52928 0.259905 1.67252L0.264905 1.67814L4.49803 6.19814V11C4.49799 11.181 4.54706 11.3586 4.64003 11.5139C4.73299 11.6692 4.86635 11.7963 5.0259 11.8818C5.18544 11.9672 5.36519 12.0078 5.54596 11.9991C5.72674 11.9904 5.90178 11.9328 6.05241 11.8325L8.05241 10.4988C8.18951 10.4074 8.30193 10.2837 8.37967 10.1384C8.45741 9.99319 8.49807 9.831 8.49803 9.66627V6.19814L12.7318 1.67814L12.7368 1.67252C12.8683 1.52993 12.9549 1.35176 12.9858 1.16025C13.0167 0.968733 12.9905 0.772361 12.9105 0.595641ZM7.63428 5.66127C7.54778 5.75297 7.49912 5.87396 7.49803 6.00002V9.66627L5.49803 11V6.00002C5.49807 5.87305 5.4498 5.75083 5.36303 5.65814L0.99803 1.00002H11.998L7.63428 5.66127Z"
                    fill="black" />
            </svg>

        </button>
        <div class="blank_div"></div>
        <form method="get" class="product-filters recipe-filter">
            <button type="button" class="close-filter">
                <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M14.781 13.7198C14.8507 13.7895 14.906 13.8722 14.9437 13.9632C14.9814 14.0543 15.0008 14.1519 15.0008 14.2504C15.0008 14.349 14.9814 14.4465 14.9437 14.5376C14.906 14.6286 14.8507 14.7114 14.781 14.781C14.7114 14.8507 14.6286 14.906 14.5376 14.9437C14.4465 14.9814 14.349 15.0008 14.2504 15.0008C14.1519 15.0008 14.0543 14.9814 13.9632 14.9437C13.8722 14.906 13.7895 14.8507 13.7198 14.781L7.50042 8.56073L1.28104 14.781C1.14031 14.9218 0.94944 15.0008 0.750417 15.0008C0.551394 15.0008 0.360523 14.9218 0.219792 14.781C0.0790615 14.6403 3.92322e-09 14.4494 0 14.2504C-3.92322e-09 14.0514 0.0790615 13.8605 0.219792 13.7198L6.4401 7.50042L0.219792 1.28104C0.0790615 1.14031 0 0.94944 0 0.750417C0 0.551394 0.0790615 0.360523 0.219792 0.219792C0.360523 0.0790615 0.551394 0 0.750417 0C0.94944 0 1.14031 0.0790615 1.28104 0.219792L7.50042 6.4401L13.7198 0.219792C13.8605 0.0790615 14.0514 -3.92322e-09 14.2504 0C14.4494 3.92322e-09 14.6403 0.0790615 14.781 0.219792C14.9218 0.360523 15.0008 0.551394 15.0008 0.750417C15.0008 0.94944 14.9218 1.14031 14.781 1.28104L8.56073 7.50042L14.781 13.7198Z"
                        fill="currentColor" />
                </svg>
            </button>
            <label>Filter :</label>

            <div class="custom-dropdown" data-name="recipe_cat">
                <button type="button" class="dropdown-toggle">
                    <span class="dropdown-label">
                        <?php
                        if (!empty($_GET['recipe_cat'])) {
                            $term = get_term_by('slug', $_GET['recipe_cat'], 'recipe_category');
                            echo esc_html($term->name ?? 'Category');
                        } else {
                            echo 'Category';
                        }
                        ?>
                    </span>
                </button>

                <ul class="dropdown-list">
                    <li data-value="">Category</li>
                    <?php foreach (get_terms('recipe_category') as $term): ?>
                        <li data-value="<?= esc_attr($term->slug); ?>">
                            <?= esc_html($term->name); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <input type="hidden" name="recipe_cat" value="<?= esc_attr($_GET['recipe_cat'] ?? ''); ?>">
            </div>

            <div class="custom-dropdown" data-name="product_filter">
                <button type="button" class="dropdown-toggle">
                    <span class="dropdown-label">
                        <?php
                        if (!empty($_GET['product_filter'])) {
                            $product = get_post($_GET['product_filter']);
                            echo esc_html($product->post_title ?? 'All Products');
                        } else {
                            echo 'All Products';
                        }
                        ?>
                    </span>
                </button>

                <ul class="dropdown-list">
                    <li data-value="">All Products</li>
                    <?php foreach ($products as $product): ?>
                        <li data-value="<?= esc_attr($product->ID); ?>">
                            <?= esc_html($product->post_title); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <input type="hidden" name="product_filter" value="<?= esc_attr($_GET['product_filter'] ?? ''); ?>">
            </div>


        </form>
    </div>
    <?php
}
add_shortcode('recipe_filter', 'recipe_filter');

add_action('elementor/query/recipe_filter', function ($query) {

    $meta_query = [];
    $tax_query = [];

    if (!empty($_GET['product_filter'])) {
        $meta_query[] = [
            'key' => 'products',
            'value' => '"' . intval($_GET['product_filter']) . '"',
            'compare' => 'LIKE',
        ];
    }

    if (!empty($_GET['recipe_cat'])) {
        $tax_query[] = [
            'taxonomy' => 'recipe_category',
            'field' => 'slug',
            'terms' => sanitize_text_field($_GET['recipe_cat']),
        ];
    }

    if ($meta_query) {
        $query->set('meta_query', $meta_query);
    }

    if ($tax_query) {
        $query->set('tax_query', $tax_query);
    }
});

function recipe_related_products_thumbs()
{

    $products = get_field('products'); // ACF relationship field
    if (empty($products) || !is_array($products)) {
        return '';
    }

    $output = '<div class="recipe-related-products">';
    $count = 0;

    foreach ($products as $product) {
        if ($count >= 3) {
            break;
        }

        $product_id = is_object($product) ? $product->ID : $product;
        $thumb = get_the_post_thumbnail(
            $product_id,
            'thumbnail',
            ['alt' => esc_attr(get_the_title($product_id))]
        );
        if (!$thumb) {
            continue;
        }
        $output .= sprintf(
            '<a href="%s" class="related-product-thumb">%s</a>',
            esc_url(get_permalink($product_id)),
            $thumb
        );
        $count++;
    }
    $output .= '</div>';
    return $output;
}
add_shortcode('recipe_product_thumbs', 'recipe_related_products_thumbs');

function recipe_related_product_single()
{

    $products = get_field('products');
    if (empty($products) || !is_array($products)) {
        return '';
    }

    $product = $products[0];
    $product_id = is_object($product) ? $product->ID : $product;
    $thumb = get_the_post_thumbnail($product_id, 'thumbnail');
    if (!$thumb) {
        return '';
    }
    $short_text = get_field('short_text_below_title', $product_id);

    ob_start(); ?>

    <div class="recipe-related-product-single">

        <div class="product-thumb">
            <a href="<?php echo esc_url(get_permalink($product_id)); ?>">
                <?php echo $thumb; ?>
            </a>
        </div>

        <div class="product-content">

            <p class="product-title">
                <a href="<?php echo esc_url(get_permalink($product_id)); ?>">
                    <?php echo esc_html(get_the_title($product_id)); ?>
                </a>
            </p>

            <?php if ($short_text): ?>
                <div class="product-short-text">
                    <?php echo esc_html($short_text); ?>
                </div>
            <?php endif; ?>

            <div class="product-stars">
                <?php for ($i = 0; $i < 5; $i++): ?>
                    <svg aria-hidden="true" class="star-icon" viewBox="0 0 1000 1000" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M450 75L338 312 88 350C46 354 25 417 58 450L238 633 196 896C188 942 238 975 275 954L500 837 725 954C767 975 813 942 804 896L763 633 942 450C975 417 954 358 913 350L663 312 550 75C529 33 471 33 450 75Z">
                        </path>
                    </svg>
                <?php endfor; ?>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('recipe_product_single', 'recipe_related_product_single');


//----------- SORT BY FILTER--------------
function sort_by_dropdown()
{
    ?>

    <div class="sort-wrapper custom-dropdown">


        <!-- <div class="custom-dropdown" data-name="sort"> -->
        <button type="button" class="dropdown-toggle sort-icon" aria-label="Sort products">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M12 12C12 12.1989 11.921 12.3897 11.7803 12.5303C11.6397 12.671 11.4489 12.75 11.25 12.75H4.5C4.30109 12.75 4.11032 12.671 3.96967 12.5303C3.82902 12.3897 3.75 12.1989 3.75 12C3.75 11.8011 3.82902 11.6103 3.96967 11.4697C4.11032 11.329 4.30109 11.25 4.5 11.25H11.25C11.4489 11.25 11.6397 11.329 11.7803 11.4697C11.921 11.6103 12 11.8011 12 12ZM4.5 6.75H17.25C17.4489 6.75 17.6397 6.67098 17.7803 6.53033C17.921 6.38968 18 6.19891 18 6C18 5.80109 17.921 5.61032 17.7803 5.46967C17.6397 5.32902 17.4489 5.25 17.25 5.25H4.5C4.30109 5.25 4.11032 5.32902 3.96967 5.46967C3.82902 5.61032 3.75 5.80109 3.75 6C3.75 6.19891 3.82902 6.38968 3.96967 6.53033C4.11032 6.67098 4.30109 6.75 4.5 6.75ZM9.75 17.25H4.5C4.30109 17.25 4.11032 17.329 3.96967 17.4697C3.82902 17.6103 3.75 17.8011 3.75 18C3.75 18.1989 3.82902 18.3897 3.96967 18.5303C4.11032 18.671 4.30109 18.75 4.5 18.75H9.75C9.94891 18.75 10.1397 18.671 10.2803 18.5303C10.421 18.3897 10.5 18.1989 10.5 18C10.5 17.8011 10.421 17.6103 10.2803 17.4697C10.1397 17.329 9.94891 17.25 9.75 17.25ZM21.5306 15.2194C21.461 15.1496 21.3783 15.0943 21.2872 15.0566C21.1962 15.0188 21.0986 14.9994 21 14.9994C20.9014 14.9994 20.8038 15.0188 20.7128 15.0566C20.6217 15.0943 20.539 15.1496 20.4694 15.2194L18 17.6897V10.5C18 10.3011 17.921 10.1103 17.7803 9.96967C17.6397 9.82902 17.4489 9.75 17.25 9.75C17.0511 9.75 16.8603 9.82902 16.7197 9.96967C16.579 10.1103 16.5 10.3011 16.5 10.5V17.6897L14.0306 15.2194C13.8899 15.0786 13.699 14.9996 13.5 14.9996C13.301 14.9996 13.1101 15.0786 12.9694 15.2194C12.8286 15.3601 12.7496 15.551 12.7496 15.75C12.7496 15.949 12.8286 16.1399 12.9694 16.2806L16.7194 20.0306C16.789 20.1004 16.8717 20.1557 16.9628 20.1934C17.0538 20.2312 17.1514 20.2506 17.25 20.2506C17.3486 20.2506 17.4462 20.2312 17.5372 20.1934C17.6283 20.1557 17.711 20.1004 17.7806 20.0306L21.5306 16.2806C21.6004 16.211 21.6557 16.1283 21.6934 16.0372C21.7312 15.9462 21.7506 15.8486 21.7506 15.75C21.7506 15.6514 21.7312 15.5538 21.6934 15.4628C21.6557 15.3717 21.6004 15.289 21.5306 15.2194Z"
                    fill="black" />
            </svg>
        </button>
        <ul class="dropdown-list">
            <li data-value="name_asc">Name (A–Z)</li>
            <li data-value="name_desc">Name (Z–A)</li>
        </ul>

        <input type="hidden" name="sort" value="<?= esc_attr($_GET['sort'] ?? ''); ?>">
        <!-- </div> -->

    </div>
    <?php
}
add_shortcode('orderby', 'sort_by_dropdown');
//----------- SORT BY FILTER-- END --------------

//-----------------Tabs------------------
function cooking_methods_tab_titles_shortcode()
{

    if (!have_rows('cooking_methods')) {
        return '';
    }

    ob_start();
    ?>
    <div class="cooking-tabs-titles">
        <?php
        $i = 0;
        while (have_rows('cooking_methods')):
            the_row();
            ?>
            <button class="cooking-tab-title <?= $i === 0 ? 'active' : ''; ?>" data-tab="cooking-tab-<?= $i; ?>">
                <?= esc_html(get_sub_field('method_name')); ?>
            </button>
            <?php
            $i++;
        endwhile;
        ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('cooking_tab_titles', 'cooking_methods_tab_titles_shortcode');
function cooking_methods_tab_content_shortcode()
{

    if (!have_rows('cooking_methods')) {
        return '';
    }

    ob_start();
    ?>
    <div class="cooking-tabs-contents">
        <?php
        $i = 0;
        while (have_rows('cooking_methods')):
            the_row();
            ?>
            <div class="cooking-tab-content <?= $i === 0 ? 'active' : ''; ?>" id="cooking-tab-<?= $i; ?>">
                <?= wp_kses_post(get_sub_field('cooking_method_instruction')); ?>
            </div>
            <?php
            $i++;
        endwhile;
        ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('cooking_tab_content', 'cooking_methods_tab_content_shortcode');
//-----------------Tabs------------------

function product_category_slider()
{
    $terms = get_terms([
        'taxonomy' => 'product_category',
        'hide_empty' => false,
    ]);

    if (empty($terms) || is_wp_error($terms)) {
        return '';
    }

    ob_start(); ?>

    <div class="product-category-slider">
        <div class="swiper productCatMain">
            <div class="swiper-wrapper">
                <?php foreach ($terms as $term):
                    $image = get_field('category_thumbnail', 'product_category_' . $term->term_id);
                    $image_url = $image ? esc_url($image['url']) : '';
                    $link = get_term_link($term);
                    ?>
                    <div class="swiper-slide category-slide" style="background-image:url('<?php echo $image_url; ?>');">
                        <!-- <div style="background: linear-gradient(90deg,rgba(190, 58, 121, 1) 0%,rgba(190, 58, 121, 0.5) 40%, rgba(128, 128, 128, 0) 60%, rgba(128, 128, 128, 0) 100%);" class="category_overlay"></div> -->
                        <div class="container">
                            <div class="category-slide-content">
                                <h2>
                                    <?php echo esc_html($term->name); ?>
                                </h2>

                                <?php if ($term->description): ?>
                                    <p>
                                        <?php echo esc_html($term->description); ?>
                                    </p>
                                <?php endif; ?>

                                <a href="<?php echo esc_url($link); ?>" class="btn">
                                    Explore
                                    <span class="arrow">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M17.25 8L21 11.75M21 11.75L17.25 15.5M21 11.75H3" stroke="#FBF9DE"
                                                stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <!-- <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div> -->
        </div>
        <div thumbsSlider class="swiper productCatThumbs">
            <div class="swiper-wrapper">
                <?php foreach ($terms as $term):
                    $image = get_field('category_thumbnail', 'product_category_' . $term->term_id);
                    $image_url = $image ? esc_url($image['url']) : '';
                    ?>
                    <div class="swiper-slide">
                        <div class="thmb_slide">
                            <img src="<?php echo $image_url; ?>" alt="">
                            <span>
                                <?php echo esc_html($term->name); ?>
                            </span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('product_category_slider', 'product_category_slider');


add_shortcode('get_cat_product', 'get_cat_product');
function get_cat_product()
{
    $terms = get_terms([
        'taxonomy' => 'product_category',
        'hide_empty' => false,
    ]);
    ob_start();

    if (!empty($terms) && !is_wp_error($terms)):
        ?>
        <div class="category-slider-wrapper">
            <div class="category-slider">
                <?php foreach ($terms as $term):
                    $cat_link = get_term_link($term);
                    $image_id = get_term_meta($term->term_id, 'india_by_category', true);
                    $desc = get_term_meta($term->term_id, 'india_by_category_slider_description', true);
                    $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'large') : '';
                    ?>
                    <div class="slide">
                        <div class="category-slide-inner">
                            <div class="category-content">
                                <h3>
                                    <?php echo esc_html($term->name); ?>
                                </h3>

                                <?php if ($desc): ?>
                                    <p>
                                        <?php echo esc_html($desc); ?>
                                    </p>
                                <?php endif; ?>

                                <a href="<?php echo esc_url($cat_link); ?>" class="btn">
                                    Explore
                                </a>
                                <div class="category-image-divider" style="color: #CDF1E0;">
                                    <svg width="46" height="892" viewBox="0 0 46 892" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_2_5)">
                                            <path
                                                d="M40.2171 240.384C39.7101 241.013 43.9345 225.753 45.1173 214.269C45.6242 210.178 44.9483 203.099 45.1173 202.942C45.2863 202.785 46.4691 205.931 45.7932 213.639C45.4553 218.831 40.724 239.754 40.2171 240.384ZM16.3905 0C16.3929 0.00379151 23.6564 11.4861 24.1633 22.0248C24.6702 32.7224 24.1633 41.8469 21.6287 54.9044C18.2492 72.6815 4.56223 106.977 11.9971 125.226C19.4319 143.475 19.77 144.262 24.5012 153.544C29.9084 163.927 40.7228 185.007 40.2159 211.122C39.7089 238.968 12.1663 289.467 13.518 310.233C13.687 312.436 14.8697 320.617 16.8974 326.752C18.925 332.73 23.3184 341.54 24.8392 353.496C25.5151 358.531 26.6978 366.554 26.3599 375.836C26.1909 378.196 25.6841 385.747 23.6565 394.714C21.6288 403.681 18.4182 412.019 17.4044 419.57C15.5469 435.763 18 446 18 446H0L0 0H16.3905ZM29.2326 245.418C27.3739 251.081 35.8226 229.686 36.1606 219.46C36.4292 211.333 35.8438 207.876 35.6771 206.879C35.6313 207.928 35.1467 211.564 35.1467 218.359C35.1467 226.225 31.0913 239.755 29.2326 245.418ZM29.2322 351.609C29.0636 350.981 32.9496 356.015 33.6254 362.622C33.9634 366.397 32.7806 372.847 32.4427 375.522C32.1059 378.187 32.6082 380.072 32.6116 380.084C32.6071 380.072 31.9352 378.188 31.7668 375.679C31.5978 373.162 32.2737 367.971 32.4427 365.139C32.9496 358.374 29.2322 352.239 29.2322 351.609ZM25.5125 59.3093C25.0056 59.9386 29.2299 44.6787 30.4127 33.1944C30.9197 29.1041 30.2438 22.0249 30.4127 21.8675C30.4127 21.7102 31.7646 24.8565 31.0887 32.5652C30.7507 37.7566 26.0197 58.6786 25.5125 59.3093ZM14.3628 154.645C13.18 151.97 22.3047 175.568 24.6703 183.749C25.6842 187.053 27.3738 193.503 28.0497 199.481C28.7256 205.616 28.7257 213.482 28.8947 213.325C29.2327 213.324 30.2464 204.2 28.8947 195.705C27.5429 187.21 27.0359 187.525 26.191 183.749C24.8392 177.771 15.5456 157.319 14.3628 154.645ZM21.6283 139.698C19.9387 136.71 17.7421 129.788 17.9108 129.787C18.0798 129.787 20.7834 136.08 22.4731 139.384C24.1628 142.687 27.0354 149.137 26.8665 149.295C26.8661 149.451 23.149 142.687 21.6283 139.698ZM22.3068 421.458C22.1379 421.458 22.3068 414.693 23.1516 410.917C23.9965 407.142 26.3622 403.052 26.5312 403.052C26.6999 403.052 25.1793 407.299 24.1655 411.075C23.1517 414.693 22.4759 421.3 22.3068 421.458ZM20.7851 119.248C20.6162 117.36 20.7851 116.101 21.292 116.101C21.7989 116.101 22.1369 116.258 21.9679 118.618C21.7989 121.293 22.8128 124.124 22.6438 124.282C22.4746 124.439 20.9541 121.135 20.7851 119.248ZM20.9528 391.725C20.9528 392.039 22.3045 388.421 22.4735 386.533C22.6425 384.646 22.6425 383.387 22.1356 383.387C21.6287 383.387 21.2907 383.544 21.4596 385.904C21.6286 388.421 20.9529 391.41 20.9528 391.725ZM18.5877 322.506C17.9118 319.989 18.4188 317.157 18.5877 317.157C18.9256 317.157 19.0946 316.843 19.4325 320.461C19.9395 324.079 21.4601 326.911 21.2912 327.225C21.1222 327.54 19.4326 325.023 18.5877 322.506ZM16.5594 51.6007C16.7284 51.1288 19.0942 46.7238 19.7701 42.1616C20.6149 37.442 20.7839 34.7677 19.0942 35.7115C17.4044 36.8128 18.4182 38.8579 18.4183 42.4762C18.4183 46.0945 16.3905 52.0726 16.5594 51.6007ZM14.1939 416.109C12.8421 422.402 14.3629 434.516 14.5319 433.886C14.7008 433.414 14.0249 420.986 15.7146 414.222C16.5595 410.76 16.5595 410.446 18.4183 405.254C20.2769 400.063 20.1079 396.917 19.601 396.759C19.263 396.602 19.263 399.748 17.5733 403.838C15.8835 407.929 14.8698 412.334 14.1939 416.109ZM11.6591 132.778C11.6591 132.463 10.9834 134.036 13.518 140.329C16.0526 146.621 19.4321 150.869 19.7701 151.184C19.9385 151.498 16.7283 145.677 14.7007 140.801C12.6734 136.082 11.6595 132.936 11.6591 132.778ZM18.4183 340.124C17.2354 337.607 16.2215 336.034 16.3905 336.663C16.5595 337.292 17.0664 338.079 17.7423 340.596C18.4182 343.271 18.2493 342.956 18.7562 343.113C19.2631 343.27 19.601 342.641 18.4183 340.124ZM14.7007 7.23672C11.4902 1.10128 9.96948 0.629393 10.1385 0.786713C10.3077 0.944474 11.9974 3.77601 14.3628 8.33783C16.5585 12.5723 18.7538 18.2977 18.9229 18.847C18.8743 18.312 17.8336 13.2237 14.7007 7.23672ZM15.3765 122.552C15.2074 122.08 12.3349 113.27 13.3487 101.629C14.3626 89.9872 16.7282 87.942 16.5592 88.2567C16.3901 88.5717 14.8694 95.3363 14.5315 103.202C14.1935 111.068 15.5454 123.181 15.3765 122.552ZM9.8005 303.941C9.29357 303.941 8.27983 305.514 9.29366 313.695C10.3075 321.875 15.7147 331.786 15.5457 331.157C15.3767 330.528 12.842 325.651 11.1523 317.942C9.2936 310.234 10.3074 303.941 9.8005 303.941ZM7.09686 97.2233C5.23817 110.123 7.0969 122.079 7.26593 120.979C7.43491 119.72 6.25202 105.876 9.12459 93.2902C10.3074 88.0987 12.842 78.6597 13.6869 73.7828C14.6984 68.6034 14.5326 64.6766 14.5319 64.6583C14.5304 64.6747 14.1912 68.4448 13.011 73.468C11.6592 78.5022 8.27968 89.6719 7.09686 97.2233ZM9.12459 290.726C8.1108 293.243 7.09703 298.906 7.43481 298.749C7.77276 298.592 8.78666 293.243 10.4764 289.939C12.1661 286.636 11.4902 287.108 11.3212 286.95C11.152 286.793 9.96935 288.209 9.12459 290.726ZM7.43481 321.403C7.26586 321.404 7.09695 323.134 7.77277 325.651C8.61759 328.325 11.1519 333.673 11.3212 333.359C11.4902 333.045 9.12458 328.011 8.44868 324.392C7.94175 320.774 7.60379 321.403 7.43481 321.403Z"
                                                fill="#CDF1E0" />
                                            <path
                                                d="M40.2171 686.384C39.7101 687.013 43.9345 671.753 45.1173 660.269C45.6242 656.178 44.9483 649.099 45.1173 648.942C45.2863 648.785 46.4691 651.931 45.7932 659.639C45.4553 664.831 40.724 685.754 40.2171 686.384ZM18 446C18 446 23.6564 457.486 24.1633 468.025C24.6702 478.722 24.1633 487.847 21.6287 500.904C18.2492 518.681 4.56223 552.977 11.9971 571.226C19.4319 589.475 19.77 590.262 24.5012 599.544C29.9084 609.927 40.7228 631.007 40.2159 657.122C39.7089 684.968 12.1663 735.467 13.518 756.233C13.687 758.436 14.8697 766.617 16.8974 772.752C18.925 778.73 23.3184 787.54 24.8392 799.496C25.5151 804.531 26.6978 812.554 26.3599 821.836C26.1909 824.196 25.6841 831.747 23.6565 840.714C21.6288 849.681 18.4182 858.019 17.4044 865.57C15.5469 881.763 18.2455 891.986 18.2492 892H0L0 446H18ZM29.2326 691.418C27.3739 697.081 35.8226 675.686 36.1606 665.46C36.4292 657.333 35.8438 653.876 35.6771 652.879C35.6313 653.928 35.1467 657.564 35.1467 664.359C35.1467 672.225 31.0913 685.755 29.2326 691.418ZM29.2322 797.609C29.0636 796.981 32.9496 802.015 33.6254 808.622C33.9634 812.397 32.7806 818.847 32.4427 821.522C32.1059 824.187 32.6082 826.072 32.6116 826.084C32.6071 826.072 31.9352 824.188 31.7668 821.679C31.5978 819.162 32.2737 813.971 32.4427 811.139C32.9496 804.374 29.2322 798.239 29.2322 797.609ZM25.5125 505.309C25.0056 505.939 29.2299 490.679 30.4127 479.194C30.9197 475.104 30.2438 468.025 30.4127 467.867C30.4127 467.71 31.7646 470.857 31.0887 478.565C30.7507 483.757 26.0197 504.679 25.5125 505.309ZM14.3628 600.645C13.18 597.97 22.3047 621.568 24.6703 629.749C25.6842 633.053 27.3738 639.503 28.0497 645.481C28.7256 651.616 28.7257 659.482 28.8947 659.325C29.2327 659.324 30.2464 650.2 28.8947 641.705C27.5429 633.21 27.0359 633.525 26.191 629.749C24.8392 623.771 15.5456 603.319 14.3628 600.645ZM21.6283 585.698C19.9387 582.71 17.7421 575.788 17.9108 575.787C18.0798 575.787 20.7834 582.08 22.4731 585.384C24.1628 588.687 27.0354 595.137 26.8665 595.295C26.8661 595.451 23.149 588.687 21.6283 585.698ZM22.3068 867.458C22.1379 867.458 22.3068 860.693 23.1516 856.917C23.9965 853.142 26.3622 849.052 26.5312 849.052C26.6999 849.052 25.1793 853.299 24.1655 857.075C23.1517 860.693 22.4759 867.3 22.3068 867.458ZM20.7851 565.248C20.6162 563.36 20.7851 562.101 21.292 562.101C21.7989 562.101 22.1369 562.258 21.9679 564.618C21.7989 567.293 22.8128 570.124 22.6438 570.282C22.4746 570.439 20.9541 567.135 20.7851 565.248ZM20.9528 837.725C20.9528 838.039 22.3045 834.421 22.4735 832.533C22.6425 830.646 22.6425 829.387 22.1356 829.387C21.6287 829.387 21.2907 829.544 21.4596 831.904C21.6286 834.421 20.9529 837.41 20.9528 837.725ZM18.5877 768.506C17.9118 765.989 18.4188 763.157 18.5877 763.157C18.9256 763.157 19.0946 762.843 19.4325 766.461C19.9395 770.079 21.4601 772.911 21.2912 773.225C21.1222 773.54 19.4326 771.023 18.5877 768.506ZM16.5594 497.601C16.7284 497.129 19.0942 492.724 19.7701 488.162C20.6149 483.442 20.7839 480.768 19.0942 481.712C17.4044 482.813 18.4182 484.858 18.4183 488.476C18.4183 492.095 16.3905 498.073 16.5594 497.601ZM14.1939 862.109C12.8421 868.402 14.3629 880.516 14.5319 879.886C14.7008 879.414 14.0249 866.986 15.7146 860.222C16.5595 856.76 16.5595 856.446 18.4183 851.254C20.2769 846.063 20.1079 842.917 19.601 842.759C19.263 842.602 19.263 845.748 17.5733 849.838C15.8835 853.929 14.8698 858.334 14.1939 862.109ZM11.6591 578.778C11.6591 578.463 10.9834 580.036 13.518 586.329C16.0526 592.621 19.4321 596.869 19.7701 597.184C19.9385 597.498 16.7283 591.677 14.7007 586.801C12.6734 582.082 11.6595 578.936 11.6591 578.778ZM18.4183 786.124C17.2354 783.607 16.2215 782.034 16.3905 782.663C16.5595 783.292 17.0664 784.079 17.7423 786.596C18.4182 789.271 18.2493 788.956 18.7562 789.113C19.2631 789.27 19.601 788.641 18.4183 786.124ZM14.7007 453.237C11.4902 447.101 9.96948 446.629 10.1385 446.787C10.3077 446.944 11.9974 449.776 14.3628 454.338C16.5585 458.572 18.7538 464.298 18.9229 464.847C18.8743 464.312 17.8336 459.224 14.7007 453.237ZM15.3765 568.552C15.2074 568.08 12.3349 559.27 13.3487 547.629C14.3626 535.987 16.7282 533.942 16.5592 534.257C16.3901 534.572 14.8694 541.336 14.5315 549.202C14.1935 557.068 15.5454 569.181 15.3765 568.552ZM9.8005 749.941C9.29357 749.941 8.27983 751.514 9.29366 759.695C10.3075 767.875 15.7147 777.786 15.5457 777.157C15.3767 776.528 12.842 771.651 11.1523 763.942C9.2936 756.234 10.3074 749.941 9.8005 749.941ZM7.09686 543.223C5.23817 556.123 7.0969 568.079 7.26593 566.979C7.43491 565.72 6.25202 551.876 9.12459 539.29C10.3074 534.099 12.842 524.66 13.6869 519.783C14.6984 514.603 14.5326 510.677 14.5319 510.658C14.5304 510.675 14.1912 514.445 13.011 519.468C11.6592 524.502 8.27968 535.672 7.09686 543.223ZM9.12459 736.726C8.1108 739.243 7.09703 744.906 7.43481 744.749C7.77276 744.592 8.78666 739.243 10.4764 735.939C12.1661 732.636 11.4902 733.108 11.3212 732.95C11.152 732.793 9.96935 734.209 9.12459 736.726ZM7.43481 767.403C7.26586 767.404 7.09695 769.134 7.77277 771.651C8.61759 774.325 11.1519 779.673 11.3212 779.359C11.4902 779.045 9.12458 774.011 8.44868 770.392C7.94175 766.774 7.60379 767.403 7.43481 767.403Z"
                                                fill="#CDF1E0" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_2_5">
                                                <rect width="46" height="892" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </div>
                            </div>
                            <div class="category-image">
                                <?php if ($image_url): ?>
                                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($term->name); ?>">
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="pagination_wrapper">
                <button id="prev">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6.75 8.25L3 12M3 12L6.75 15.75M3 12H21" stroke="currentColor" stroke-width="1.8"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
                <div class="dots" id="dots"></div>
                <button id="next">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.25 8.25L21 12M21 12L17.25 15.75M21 12H3" stroke="currentColor" stroke-width="1.8"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            </div>
        </div>
    <?php endif;
    return ob_get_clean();
}


add_shortcode('journey_slider', 'journey_slider');
function journey_slider()
{
    ob_start();
    if (have_rows('our_journey', 'option')): ?>
        <div class="timeline_slider_wrapper">
            <div class="swiper timeline_slider">
                <div class="timeline_line"></div>
                <div class="swiper-wrapper">
                    <?php
                    $i = 0;
                    while (have_rows('our_journey', 'option')):
                        the_row();
                        $image = get_sub_field('image');
                        $year = get_sub_field('year');
                        $title = get_sub_field('title');
                        $description = get_sub_field('description');
                        ?>
                        <div class="swiper-slide timeline_item">
                            <span class="timeline_dot"></span>
                            <div class="timeline_card timeline_card_<?php echo $i; ?>">
                                <?php if ($image): ?>
                                    <div class="timeline_image">
                                        <div class="timeline_image_wrapper">
                                            <img src="<?php echo esc_url($image['url']); ?>">
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <div class="timeline_content">
                                    <?php if ($year): ?>
                                        <h4>
                                            <?php echo $year; ?>
                                        </h4>
                                    <?php endif; ?>

                                    <?php if ($title): ?>
                                        <h3>
                                            <?php echo esc_html($title); ?>
                                        </h3>
                                    <?php endif; ?>

                                    <?php if ($description): ?>
                                        <p>
                                            <?php echo esc_html($description); ?>
                                        </p>
                                    <?php endif; ?>
                                </div>

                            </div>
                        </div>
                        <?php
                        $i++;
                    endwhile;
                    ?>
                    <?php
                    $i = 0;
                    while (have_rows('our_journey', 'option')):
                        the_row();
                        $image = get_sub_field('image');
                        $year = get_sub_field('year');
                        $title = get_sub_field('title');
                        $description = get_sub_field('description');
                        ?>
                        <div class="swiper-slide timeline_item">
                            <span class="timeline_dot"></span>
                            <div class="timeline_card timeline_card_<?php echo $i; ?>">
                                <?php if ($image): ?>
                                    <div class="timeline_image">
                                        <div class="timeline_image_wrapper">
                                            <img src="<?php echo esc_url($image['url']); ?>">
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <div class="timeline_content">
                                    <?php if ($year): ?>
                                        <h4>
                                            <?php echo $year; ?>
                                        </h4>
                                    <?php endif; ?>

                                    <?php if ($title): ?>
                                        <h3>
                                            <?php echo esc_html($title); ?>
                                        </h3>
                                    <?php endif; ?>

                                    <?php if ($description): ?>
                                        <p>
                                            <?php echo esc_html($description); ?>
                                        </p>
                                    <?php endif; ?>
                                </div>

                            </div>
                        </div>
                        <?php
                        $i++;
                    endwhile;
                    ?>
                </div>
            </div>
            <div class="swiper_btn_wrapper">
                <div class="swiper-button-prev swiper_btn">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.75 6.75L12 3M12 3L8.25 6.75M12 3L12 21" stroke="currentColor" stroke-width="1.8"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <div class="swiper-button-next swiper_btn">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.25 17.25L12 21M12 21L15.75 17.25M12 21L12 3" stroke="currentColor" stroke-width="1.8"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
            </div>
        </div>
    <?php endif;
    return ob_get_clean();
}

function insta_post_slider()
{
    ob_start();
    if (have_rows('image_for_instagram_slider', 'option')): ?>
        <div class="swiper collage-slider">
            <div class="swiper-wrapper">
                <?php
                $i = 0;
                while (have_rows('image_for_instagram_slider', 'option')):
                    the_row();
                    $image = get_sub_field('image');
                    ?>
                    <div class="swiper-slide">

                        <img src="<?php echo esc_url($image['url']); ?>">

                    </div>
                    <?php
                    $i++;
                endwhile;
                ?>

            </div>
            <div class="swiper-button-prev swiper_btn">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6.75 8.25L3 12M3 12L6.75 15.75M3 12H21" stroke="currentColor" stroke-width="1.8"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>
            <div class="swiper-button-next swiper_btn">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17.25 8.25L21 12M21 12L17.25 15.75M21 12H3" stroke="currentColor" stroke-width="1.8"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>
        </div>
    <?php endif;
    return ob_get_clean();
}

add_shortcode('insta_post_slider', 'insta_post_slider');


add_shortcode('new_custom_image_slider', 'new_custom_image_slider');
function new_custom_image_slider() {

    if (!function_exists('get_field')) {
        return '';
    }
    $tikka_group = get_field('tikka_group');
    if (!is_array($tikka_group)) {
        return '';
    }

    $columns = [
        1 => 'tikka_images',
        2 => 'tikka_second_images',
        3 => 'tikka_third_images',
        4 => 'tikka_fourth_images',
    ];
    ob_start();
    ?>
    <div class="gallery-wrapper">
        <?php foreach ($columns as $col_number => $repeater_name): ?>
            <?php
            $images = !empty($tikka_group[$repeater_name]) && is_array($tikka_group[$repeater_name])
                        ? $tikka_group[$repeater_name]
                        : [];

            $slides = array_merge($images, $images);
            ?>
            <div class="swiper vertical-column column-<?php echo esc_attr($col_number); ?>">
                <div class="swiper-wrapper">

                    <?php foreach ($slides as $row): ?>
                        <?php
                        if (empty($row['tikka_tribe_image'])) continue;
                        $img = $row['tikka_tribe_image'];
                        ?>
                        <div class="swiper-slide">
                            <img 
                                src="<?php echo esc_url($img['url']); ?>" 
                                alt="<?php echo esc_attr($img['alt']); ?>">
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php
    return ob_get_clean();
}


