<?php
defined('ABSPATH') || exit;

/**
 * Returns SEO meta values with fallback chain:
 * Yoast/RankMath → ACF → WP native → auto-generated
 */
function st_seo_meta(): array {
    global $post;

    // If Yoast or RankMath is active, let them handle meta output
    if (defined('WPSEO_VERSION') || defined('RANK_MATH_VERSION')) {
        return [];
    }

    $title       = '';
    $description = '';
    $image_url   = '';
    $canonical   = get_permalink();
    $type        = 'website';

    if (is_singular() && isset($post)) {
        $type        = 'article';
        $title       = get_the_title($post);
        $description = has_excerpt($post) ? get_the_excerpt($post) : wp_trim_words(strip_shortcodes(strip_tags($post->post_content)), 25);
        $canonical   = get_permalink($post);

        if (has_post_thumbnail($post)) {
            $img       = wp_get_attachment_image_src(get_post_thumbnail_id($post), 'hero');
            $image_url = $img ? $img[0] : '';
        }

        // ACF override
        if (function_exists('get_field')) {
            $title       = get_field('seo_title', $post->ID) ?: $title;
            $description = get_field('seo_description', $post->ID) ?: $description;
        }
    } elseif (is_home() || is_front_page()) {
        $title       = get_bloginfo('name') . ' — ' . get_bloginfo('description');
        $description = get_bloginfo('description');
        $canonical   = home_url('/');
    } elseif (is_archive()) {
        $title       = get_the_archive_title();
        $description = get_the_archive_description();
    } elseif (is_search()) {
        $title = sprintf(__('Search results for: %s', 'starter-theme'), get_search_query());
        $type  = 'website';
    }

    return compact('title', 'description', 'image_url', 'canonical', 'type');
}

add_action('wp_head', function (): void {
    // Skip if Yoast or RankMath handles meta
    if (defined('WPSEO_VERSION') || defined('RANK_MATH_VERSION')) {
        return;
    }

    $meta = st_seo_meta();
    if (empty($meta)) {
        return;
    }

    $title       = esc_attr($meta['title']);
    $description = esc_attr($meta['description']);
    $image_url   = esc_url($meta['image_url'] ?: '');
    $canonical   = esc_url($meta['canonical']);
    $type        = $meta['type'];
    $site_name   = esc_attr(get_bloginfo('name'));
    $robots      = is_search() ? 'noindex, follow' : 'index, follow';

    echo "<meta name=\"description\" content=\"{$description}\">\n";
    echo "<link rel=\"canonical\" href=\"{$canonical}\">\n";
    echo "<meta name=\"robots\" content=\"{$robots}\">\n";

    // Open Graph
    echo "<meta property=\"og:type\" content=\"{$type}\">\n";
    echo "<meta property=\"og:title\" content=\"{$title}\">\n";
    echo "<meta property=\"og:description\" content=\"{$description}\">\n";
    echo "<meta property=\"og:url\" content=\"{$canonical}\">\n";
    echo "<meta property=\"og:site_name\" content=\"{$site_name}\">\n";
    if ($image_url) {
        echo "<meta property=\"og:image\" content=\"{$image_url}\">\n";
    }

    // Twitter Cards
    echo "<meta name=\"twitter:card\" content=\"summary_large_image\">\n";
    echo "<meta name=\"twitter:title\" content=\"{$title}\">\n";
    echo "<meta name=\"twitter:description\" content=\"{$description}\">\n";
    if ($image_url) {
        echo "<meta name=\"twitter:image\" content=\"{$image_url}\">\n";
    }
}, 2);

// --- JSON-LD Schema.org ---
add_action('wp_head', function (): void {
    $schemas = [];

    if (is_front_page()) {
        $schemas[] = [
            '@context' => 'https://schema.org',
            '@type'    => 'WebSite',
            'name'     => get_bloginfo('name'),
            'url'      => home_url('/'),
            'potentialAction' => [
                '@type'       => 'SearchAction',
                'target'      => [
                    '@type'       => 'EntryPoint',
                    'urlTemplate' => home_url('/?s={search_term_string}'),
                ],
                'query-input' => 'required name=search_term_string',
            ],
        ];

        $schemas[] = st_schema_organization();
    }

    if (is_singular('post')) {
        global $post;
        setup_postdata($post);
        $schemas[] = st_schema_article($post);
    }

    if (! is_front_page()) {
        $breadcrumb = st_schema_breadcrumb();
        if ($breadcrumb) {
            $schemas[] = $breadcrumb;
        }
    }

    foreach ($schemas as $schema) {
        echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
    }
}, 5);

function st_schema_organization(): array {
    $logo_id  = get_theme_mod('custom_logo');
    $logo_url = $logo_id ? wp_get_attachment_url($logo_id) : '';

    $schema = [
        '@context' => 'https://schema.org',
        '@type'    => 'Organization',
        'name'     => get_bloginfo('name'),
        'url'      => home_url('/'),
    ];

    if ($logo_url) {
        $schema['logo'] = $logo_url;
    }

    // ACF social links (optional)
    if (function_exists('get_field')) {
        $social = get_field('social_links', 'option');
        if (! empty($social)) {
            $schema['sameAs'] = array_values(array_filter((array) $social));
        }
    }

    return $schema;
}

function st_schema_article(WP_Post $post): array {
    $img      = has_post_thumbnail($post) ? wp_get_attachment_image_src(get_post_thumbnail_id($post), 'hero') : null;
    $author   = get_the_author_meta('display_name', $post->post_author);

    return [
        '@context'      => 'https://schema.org',
        '@type'         => 'Article',
        'headline'      => get_the_title($post),
        'datePublished' => get_the_date('c', $post),
        'dateModified'  => get_the_modified_date('c', $post),
        'author'        => ['@type' => 'Person', 'name' => $author],
        'url'           => get_permalink($post),
        'image'         => $img ? $img[0] : '',
        'publisher'     => [
            '@type' => 'Organization',
            'name'  => get_bloginfo('name'),
        ],
    ];
}

function st_schema_breadcrumb(): ?array {
    $items    = st_get_breadcrumb_items();
    if (count($items) < 2) {
        return null;
    }

    $list_items = [];
    foreach ($items as $position => $item) {
        $list_items[] = [
            '@type'    => 'ListItem',
            'position' => $position + 1,
            'name'     => $item['name'],
            'item'     => $item['url'],
        ];
    }

    return [
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        'itemListElement' => $list_items,
    ];
}

/**
 * Returns breadcrumb items as ['name' => '', 'url' => ''] array.
 * Supports Yoast breadcrumbs data, RankMath data, then falls back to native.
 */
function st_get_breadcrumb_items(): array {
    $items = [['name' => __('Home', 'starter-theme'), 'url' => home_url('/')]];

    if (is_singular()) {
        global $post;
        $ancestors = array_reverse(get_post_ancestors($post));
        foreach ($ancestors as $ancestor_id) {
            $items[] = ['name' => get_the_title($ancestor_id), 'url' => get_permalink($ancestor_id)];
        }
        $items[] = ['name' => get_the_title($post), 'url' => get_permalink($post)];
    } elseif (is_category() || is_tag() || is_tax()) {
        $term    = get_queried_object();
        $items[] = ['name' => $term->name, 'url' => get_term_link($term)];
    } elseif (is_archive()) {
        $items[] = ['name' => get_the_archive_title(), 'url' => ''];
    } elseif (is_search()) {
        $items[] = ['name' => sprintf(__('Search: %s', 'starter-theme'), get_search_query()), 'url' => ''];
    } elseif (is_404()) {
        $items[] = ['name' => __('404 Not Found', 'starter-theme'), 'url' => ''];
    }

    return $items;
}

/**
 * Outputs HTML breadcrumb — Yoast → RankMath → custom fallback.
 */
function st_breadcrumbs(): void {
    if (is_front_page()) {
        return;
    }

    if (function_exists('yoast_breadcrumb')) {
        yoast_breadcrumb('<nav aria-label="' . esc_attr__('Breadcrumb', 'starter-theme') . '" class="breadcrumb">', '</nav>');
        return;
    }

    if (function_exists('rank_math_the_breadcrumbs')) {
        rank_math_the_breadcrumbs();
        return;
    }

    $items = st_get_breadcrumb_items();
    if (count($items) < 2) {
        return;
    }

    echo '<nav aria-label="' . esc_attr__('Breadcrumb', 'starter-theme') . '" class="breadcrumb">';
    echo '<ol class="flex flex-wrap gap-1 text-sm text-gray-500">';
    foreach ($items as $i => $item) {
        $is_last = $i === array_key_last($items);
        echo '<li>';
        if (! $is_last && $item['url']) {
            echo '<a href="' . esc_url($item['url']) . '" class="hover:underline">' . esc_html($item['name']) . '</a>';
            echo '<span aria-hidden="true" class="mx-1">/</span>';
        } else {
            echo '<span aria-current="page">' . esc_html($item['name']) . '</span>';
        }
        echo '</li>';
    }
    echo '</ol></nav>';
}
