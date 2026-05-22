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
