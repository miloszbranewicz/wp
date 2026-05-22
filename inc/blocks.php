<?php
defined('ABSPATH') || exit;

/**
 * Restrict allowed blocks in the editor.
 * Extend this list as your project needs grow.
 */
add_filter('allowed_block_types_all', function (bool|array $allowed_blocks, WP_Block_Editor_Context $context): array {
    // Allow all blocks in widget areas and site editor
    if (empty($context->post)) {
        return is_array($allowed_blocks) ? $allowed_blocks : [];
    }

    return [
        // Text
        'core/paragraph',
        'core/heading',
        'core/list',
        'core/list-item',
        'core/quote',
        'core/pullquote',
        'core/verse',
        'core/preformatted',
        'core/code',
        // Media
        'core/image',
        'core/gallery',
        'core/video',
        'core/audio',
        'core/file',
        'core/media-text',
        // Layout
        'core/group',
        'core/columns',
        'core/column',
        'core/cover',
        'core/separator',
        'core/spacer',
        // Interactive
        'core/buttons',
        'core/button',
        'core/search',
        'core/shortcode',
        'core/html',
        'core/embed',
        'core/table',
        // Navigation (for menus)
        'core/navigation',
        'core/navigation-link',
        'core/navigation-submenu',
        // Template parts
        'core/template-part',
        // ACF blocks (loaded dynamically if plugin active)
        ...(function_exists('acf_register_block_type') ? st_get_acf_block_names() : []),
    ];
}, 10, 2);

function st_get_acf_block_names(): array {
    if (! function_exists('acf_get_block_types')) {
        return [];
    }
    return array_column(acf_get_block_types(), 'name');
}

// Disable block patterns from core (use your own)
add_action('after_setup_theme', function (): void {
    remove_theme_support('core-block-patterns');
});

// Disable the duotone filter on images (performance)
add_action('after_setup_theme', function (): void {
    remove_filter('render_block', 'wp_render_duotone_support');
    remove_filter('render_block_data', 'wp_resolve_post_duotone');
});
