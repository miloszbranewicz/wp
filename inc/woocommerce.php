<?php
defined('ABSPATH') || exit;

if (! class_exists('WooCommerce')) {
    return;
}

// Remove default WooCommerce breadcrumb (we use our own)
add_action('init', function (): void {
    remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
});

// Add our breadcrumb in its place
add_action('woocommerce_before_main_content', function (): void {
    st_breadcrumbs();
}, 20);

// Remove default WooCommerce wrappers (we use theme templates)
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

add_action('woocommerce_before_main_content', function (): void {
    echo '<main id="main" role="main" class="container mx-auto px-4 py-8">';
}, 10);

add_action('woocommerce_after_main_content', function (): void {
    echo '</main>';
}, 10);

// Remove sidebar from WooCommerce pages
remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

// Schema: add Product structured data (WooCommerce handles this natively, just ensure it's enabled)
add_filter('woocommerce_structured_data_context', fn($context) => $context);

// Improve WooCommerce performance: disable unused features
add_filter('woocommerce_demo_store', '__return_false');

// Product image srcset helper
add_filter('woocommerce_product_get_image', function (string $html): string {
    return str_replace('<img ', '<img loading="lazy" decoding="async" ', $html);
});
