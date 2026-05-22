<?php
defined('ABSPATH') || exit;

add_action('after_setup_theme', function (): void {
    load_theme_textdomain('starter-theme', get_template_directory() . '/languages');

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', [
        'search-form', 'comment-form', 'comment-list',
        'gallery', 'caption', 'style', 'script',
    ]);
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('responsive-embeds');
    add_theme_support('align-wide');
    add_theme_support('editor-styles');

    // WooCommerce
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');

    register_nav_menus([
        'primary' => __('Primary Menu', 'starter-theme'),
        'footer'  => __('Footer Menu', 'starter-theme'),
    ]);

    add_image_size('hero', 1920, 1080, true);
    add_image_size('card', 800, 600, true);
    add_image_size('card-2x', 1600, 1200, true);
    add_image_size('card-square', 600, 600, true);
});

add_filter('excerpt_length', fn() => 20);
add_filter('excerpt_more', fn() => '&hellip;');

add_action('init', function (): void {
    $theme_uri     = get_template_directory_uri();
    $style_handles = [];

    if (st_is_vite_dev()) {
        wp_register_script('starter-theme-slider', 'http://localhost:5173/assets/src/js/slider.js', [], null, true);
    } else {
        $slider_js = st_vite_asset('assets/src/js/slider.js');
        if ($slider_js) {
            wp_register_script('starter-theme-slider', $theme_uri . '/dist/' . $slider_js, [], null, true);
        }
        foreach (st_vite_asset_css_files('assets/src/js/slider.js') as $i => $css_file) {
            $handle = 'starter-theme-slider-' . $i;
            wp_register_style($handle, $theme_uri . '/dist/' . $css_file, [], null);
            $style_handles[] = $handle;
        }
    }

    register_block_type(__DIR__ . '/../blocks/slider', [
        'view_script_handles' => ['starter-theme-slider'],
        'style_handles'       => $style_handles,
    ]);
});
