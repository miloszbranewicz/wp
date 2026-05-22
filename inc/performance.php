<?php
defined('ABSPATH') || exit;

// --- Head cleanup ---
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_shortlink_wp_head', 10);
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('wp_head', 'rest_output_link_wp_head', 10);
remove_action('wp_head', 'wp_oembed_add_discovery_links');
remove_action('wp_head', 'feed_links_extra', 3);

add_filter('the_generator', '__return_empty_string');
add_filter('wp_resource_hints', fn($hints, $relation_type) =>
    $relation_type === 'dns-prefetch' ? [] : $hints, 10, 2);

// --- Disable block library CSS on front-end (loaded per-block instead) ---
add_filter('should_load_separate_core_block_assets', '__return_true');

// --- Disable classic theme styles (WP 6.1+) ---
add_filter('classic_theme_styles_inline_size_limit', '__return_zero');

// --- Contact Form 7: load assets only when shortcode is present ---
add_filter('wpcf7_load_js', '__return_false');
add_filter('wpcf7_load_css', '__return_false');

add_action('wp_enqueue_scripts', function (): void {
    global $post;
    if (isset($post->post_content) && has_shortcode($post->post_content, 'contact-form-7')) {
        wpcf7_enqueue_scripts();
        wpcf7_enqueue_styles();
    }
}, 99);

// --- Lazy load & CLS prevention for images ---
// Preserve WP 6.3+ native fetchpriority="high" / loading="eager" on LCP candidates.
add_filter('wp_get_attachment_image_attributes', function (array $attr, $attachment, $size): array {
    if (is_admin()) {
        return $attr;
    }
    // Don't override if WP (or st_responsive_image $priority flag) already set eager/fetchpriority
    if (! isset($attr['fetchpriority'])) {
        $attr['loading'] = $attr['loading'] ?? 'lazy';
    }
    $attr['decoding'] = $attr['decoding'] ?? 'async';
    return $attr;
}, 10, 3);

// --- Preconnect / DNS prefetch hints ---
add_action('wp_head', function (): void {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
    // Inter — default font. For GDPR/self-hosted: npm install @fontsource/inter and import in app.js instead.
    echo '<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">' . "\n";
    echo '<link rel="dns-prefetch" href="//www.google-analytics.com">' . "\n";
    echo '<link rel="dns-prefetch" href="//www.googletagmanager.com">' . "\n";
}, 1);

// --- Disable XML-RPC ---
add_filter('xmlrpc_enabled', '__return_false');

// --- Remove query strings from static assets ---
add_filter('script_loader_src', 'st_remove_query_strings');
add_filter('style_loader_src', 'st_remove_query_strings');

function st_remove_query_strings(string $src): string {
    if (strpos($src, '?ver=')) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}
