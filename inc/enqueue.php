<?php
defined('ABSPATH') || exit;

/**
 * Reads the Vite manifest and returns the hashed filename for a given entry.
 */
function st_vite_asset(string $entry): string {
    static $manifest = null;

    if ($manifest === null) {
        $manifest_path = get_template_directory() . '/dist/.vite/manifest.json';
        if (! file_exists($manifest_path)) {
            return '';
        }
        $manifest = json_decode(file_get_contents($manifest_path), true);
    }

    return $manifest[$entry]['file'] ?? '';
}

function st_is_vite_dev(): bool {
    if (defined('VITE_DEV_MODE')) {
        return (bool) VITE_DEV_MODE;
    }
    return file_exists(get_template_directory() . '/.vite-dev');
}

add_action('wp_enqueue_scripts', function (): void {
    $theme_uri = get_template_directory_uri();

    if (st_is_vite_dev()) {
        // Dev mode: load from Vite dev server
        wp_enqueue_script('vite-client', 'http://localhost:5173/@vite/client', [], null, false);
        wp_enqueue_script('app-js', 'http://localhost:5173/assets/src/js/app.js', [], null, true);
        wp_enqueue_style('app-css', 'http://localhost:5173/assets/src/css/app.css', [], null);

        // WooCommerce styles only on WC pages
        if (function_exists('is_woocommerce') && (is_woocommerce() || is_cart() || is_checkout() || is_account_page())) {
            wp_enqueue_style('woocommerce-css', 'http://localhost:5173/assets/src/css/woocommerce.css', [], null);
        }
    } else {
        // Production: load from manifest
        $app_js  = st_vite_asset('assets/src/js/app.js');
        $app_css = st_vite_asset('assets/src/css/app.css');

        if ($app_css) {
            wp_enqueue_style('app-css', $theme_uri . '/dist/' . $app_css, [], null);
        }
        if ($app_js) {
            wp_enqueue_script('app-js', $theme_uri . '/dist/' . $app_js, [], null, true);
        }

        if (function_exists('is_woocommerce') && (is_woocommerce() || is_cart() || is_checkout() || is_account_page())) {
            $wc_css = st_vite_asset('assets/src/css/woocommerce.css');
            if ($wc_css) {
                wp_enqueue_style('woocommerce-css', $theme_uri . '/dist/' . $wc_css, [], null);
            }
        }
    }

    // Dequeue jQuery on front-end unless WooCommerce or CF7 needs it
    if (! is_admin() && ! function_exists('is_woocommerce')) {
        add_action('wp_print_scripts', function (): void {
            if (! is_woocommerce_page_maybe() && ! has_shortcode_cf7()) {
                wp_dequeue_script('jquery');
                wp_deregister_script('jquery');
            }
        }, 100);
    }
});

add_action('enqueue_block_editor_assets', function (): void {
    $theme_uri = get_template_directory_uri();

    if (st_is_vite_dev()) {
        wp_enqueue_style('editor-css', 'http://localhost:5173/assets/src/css/editor.css', [], null);
        wp_enqueue_script('editor-js', 'http://localhost:5173/assets/src/js/editor.js', ['wp-blocks', 'wp-dom-ready', 'wp-edit-post'], null, true);
    } else {
        $editor_css = st_vite_asset('assets/src/css/editor.css');
        $editor_js  = st_vite_asset('assets/src/js/editor.js');

        if ($editor_css) {
            wp_enqueue_style('editor-css', $theme_uri . '/dist/' . $editor_css, [], null);
        }
        if ($editor_js) {
            wp_enqueue_script('editor-js', $theme_uri . '/dist/' . $editor_js, ['wp-blocks', 'wp-dom-ready', 'wp-edit-post'], null, true);
        }
    }
});

add_action('after_setup_theme', function (): void {
    $css = st_vite_asset('assets/src/css/editor.css');
    if ($css) {
        add_editor_style('dist/' . $css);
    }
});

// Vite scripts must be ES modules for HMR to work
add_filter('script_loader_tag', function (string $tag, string $handle): string {
    if (in_array($handle, ['vite-client', 'app-js', 'editor-js'], true)) {
        $tag = str_replace(' src=', ' type="module" crossorigin src=', $tag);
    }
    return $tag;
}, 10, 2);

function is_woocommerce_page_maybe(): bool {
    return function_exists('is_woocommerce') && (is_woocommerce() || is_cart() || is_checkout() || is_account_page());
}

function has_shortcode_cf7(): bool {
    global $post;
    return isset($post->post_content) && has_shortcode($post->post_content, 'contact-form-7');
}
