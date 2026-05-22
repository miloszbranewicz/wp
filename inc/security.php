<?php
defined('ABSPATH') || exit;

// --- Security headers ---
// Not in theme: DISALLOW_FILE_EDIT, FORCE_SSL_ADMIN → wp-config.php
//               HSTS preload, file permissions → server config
add_action('send_headers', function (): void {
    if (is_admin()) {
        return;
    }

    header('X-Frame-Options: SAMEORIGIN');
    header('X-Content-Type-Options: nosniff');
    header('X-XSS-Protection: 1; mode=block');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Permissions-Policy: camera=(), microphone=(), geolocation=(), payment=()');

    if (is_ssl()) {
        header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
    }

    // CSP starter policy — 'unsafe-inline'/'unsafe-eval' kept for WP/plugin compatibility.
    // Per project: tighten by generating a nonce and replacing unsafe-inline with 'nonce-{value}'.
    header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https:; style-src 'self' 'unsafe-inline' https:; img-src 'self' data: https:; font-src 'self' https:; frame-src 'self' https:; object-src 'none'; base-uri 'self';");
});

// --- Prevent user enumeration via author archives and ?author= query ---
add_action('template_redirect', function (): void {
    if (! is_user_logged_in() && (is_author() || isset($_GET['author']))) {
        wp_redirect(home_url('/'), 301);
        exit;
    }
});

// --- Remove /wp/v2/users from public REST API ---
add_filter('rest_endpoints', function (array $endpoints): array {
    unset(
        $endpoints['/wp/v2/users'],
        $endpoints['/wp/v2/users/(?P<id>[\d]+)']
    );
    return $endpoints;
});

// --- Generic login error — don't hint whether username or password was wrong ---
add_filter('login_errors', fn() => __('Invalid credentials.', 'starter-theme'));

// --- Disable self-pingbacks ---
add_action('pre_ping', function (array &$links): void {
    $home = home_url();
    foreach ($links as $k => $link) {
        if (str_starts_with($link, $home)) {
            unset($links[$k]);
        }
    }
});

// --- Admin notice when DISALLOW_FILE_EDIT is not set in wp-config.php ---
add_action('admin_notices', function (): void {
    if (! current_user_can('manage_options')) {
        return;
    }
    if (! defined('DISALLOW_FILE_EDIT') || ! DISALLOW_FILE_EDIT) {
        echo '<div class="notice notice-warning is-dismissible"><p>';
        printf(
            /* translators: %s: constant name */
            esc_html__('Security: add %s to wp-config.php to disable the built-in theme and plugin file editor.', 'starter-theme'),
            '<code>define(\'DISALLOW_FILE_EDIT\', true);</code>'
        );
        echo '</p></div>';
    }
});
