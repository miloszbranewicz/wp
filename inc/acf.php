<?php
defined('ABSPATH') || exit;

if (! function_exists('get_field')) {
    return;
}

/**
 * Safe ACF field getter with fallback.
 */
function st_get_field(string $key, mixed $fallback = '', int|string|false $post_id = false): mixed {
    $value = get_field($key, $post_id ?: null);
    return ($value !== null && $value !== false && $value !== '') ? $value : $fallback;
}

/**
 * Returns a responsive <img> tag from an ACF image field.
 *
 * @param string $key      ACF field key
 * @param string $size     WP image size name
 * @param string $class    CSS classes for the img element
 * @param int|string $post_id Optional post ID
 */
function st_acf_image(string $key, string $size = 'card', string $class = '', int|string|false $post_id = false): string {
    $image = get_field($key, $post_id ?: null);
    if (empty($image) || ! is_array($image)) {
        return '';
    }

    $src    = $image['sizes'][$size] ?? $image['url'];
    $src_2x = $image['sizes'][$size . '-2x'] ?? '';
    $srcset = $src_2x ? esc_url($src) . ' 1x, ' . esc_url($src_2x) . ' 2x' : '';
    $alt    = esc_attr($image['alt'] ?: $image['title']);
    $width  = $image['sizes'][$size . '-width'] ?? '';
    $height = $image['sizes'][$size . '-height'] ?? '';
    $class  = $class ? ' class="' . esc_attr($class) . '"' : '';

    $attrs  = '';
    $attrs .= $width  ? ' width="' . (int) $width . '"'   : '';
    $attrs .= $height ? ' height="' . (int) $height . '"' : '';
    $attrs .= $srcset ? ' srcset="' . $srcset . '"'       : '';

    return '<img src="' . esc_url($src) . '" alt="' . $alt . '"' . $attrs . $class . ' loading="lazy" decoding="async">';
}

/**
 * Returns an ACF link field as an <a> tag.
 */
function st_acf_link(string $key, string $class = '', int|string|false $post_id = false): string {
    $link = get_field($key, $post_id ?: null);
    if (empty($link)) {
        return '';
    }

    $url    = esc_url($link['url']);
    $title  = esc_html($link['title']);
    $target = $link['target'] ? ' target="' . esc_attr($link['target']) . '" rel="noopener noreferrer"' : '';
    $class  = $class ? ' class="' . esc_attr($class) . '"' : '';

    return "<a href=\"{$url}\"{$class}{$target}>{$title}</a>";
}

// Register ACF Options Page (requires ACF Pro)
if (function_exists('acf_add_options_page')) {
    acf_add_options_page([
        'page_title' => __('Theme Settings', 'starter-theme'),
        'menu_title' => __('Theme Settings', 'starter-theme'),
        'menu_slug'  => 'theme-settings',
        'capability' => 'edit_posts',
        'icon_url'   => 'dashicons-admin-customizer',
    ]);
}
