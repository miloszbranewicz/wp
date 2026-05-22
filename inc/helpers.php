<?php
defined('ABSPATH') || exit;

/**
 * Returns a responsive <img> tag from a WP attachment ID.
 * Outputs width+height to prevent CLS.
 *
 * @param int    $attachment_id
 * @param string $size     Main size (e.g. 'card')
 * @param string $size_2x  Retina size (e.g. 'card-2x'), pass '' to skip srcset
 * @param string $class    CSS classes
 */
function st_responsive_image(int $attachment_id, string $size = 'card', string $size_2x = 'card-2x', string $class = ''): string {
    if (! $attachment_id) {
        return '';
    }

    $img = wp_get_attachment_image_src($attachment_id, $size);
    if (! $img) {
        return '';
    }

    [$src, $width, $height] = $img;

    $srcset = '';
    if ($size_2x) {
        $img_2x = wp_get_attachment_image_src($attachment_id, $size_2x);
        if ($img_2x) {
            $srcset = esc_url($src) . ' 1x, ' . esc_url($img_2x[0]) . ' 2x';
        }
    }

    $alt   = esc_attr(get_post_meta($attachment_id, '_wp_attachment_image_alt', true));
    $class = $class ? ' class="' . esc_attr($class) . '"' : '';

    $attrs  = ' width="' . (int) $width . '" height="' . (int) $height . '"';
    $attrs .= ' loading="lazy" decoding="async"';
    $attrs .= $srcset ? ' srcset="' . $srcset . '"' : '';

    return '<img src="' . esc_url($src) . '" alt="' . $alt . '"' . $attrs . $class . '>';
}

/**
 * Outputs an inline SVG from the theme's assets directory.
 * SVG must be in assets/svg/{name}.svg
 *
 * @param string $name    Filename without extension
 * @param string $class   CSS classes for the <svg> element
 * @param string $aria    aria-label value (omit for decorative icons)
 */
function st_svg(string $name, string $class = '', string $aria = ''): string {
    $path = get_template_directory() . '/assets/svg/' . sanitize_file_name($name) . '.svg';
    if (! file_exists($path)) {
        return '';
    }

    $svg = file_get_contents($path);

    if ($class) {
        $svg = preg_replace('/<svg/', '<svg class="' . esc_attr($class) . '"', $svg, 1);
    }

    if ($aria) {
        $svg = preg_replace('/<svg/', '<svg role="img" aria-label="' . esc_attr($aria) . '"', $svg, 1);
    } else {
        $svg = preg_replace('/<svg/', '<svg aria-hidden="true" focusable="false"', $svg, 1);
    }

    return $svg;
}

/**
 * Outputs pagination for archive pages.
 */
function st_pagination(): void {
    the_posts_pagination([
        'mid_size'           => 2,
        'prev_text'          => '&larr; ' . __('Previous', 'starter-theme'),
        'next_text'          => __('Next', 'starter-theme') . ' &rarr;',
        'screen_reader_text' => __('Posts navigation', 'starter-theme'),
        'aria_label'         => __('Posts', 'starter-theme'),
    ]);
}

/**
 * Returns true if the current page is a WooCommerce page.
 * Safe to call even when WooCommerce is not active.
 */
function st_is_woo(): bool {
    return function_exists('is_woocommerce') && (
        is_woocommerce() || is_cart() || is_checkout() || is_account_page()
    );
}
