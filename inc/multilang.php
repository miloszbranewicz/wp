<?php
defined('ABSPATH') || exit;

/**
 * Detects active multilingual plugin.
 * Returns 'wpml', 'polylang', or null.
 */
function st_multilang_plugin(): ?string {
    if (defined('ICL_SITEPRESS_VERSION')) {
        return 'wpml';
    }
    if (function_exists('pll_languages_list')) {
        return 'polylang';
    }
    return null;
}

// Output hreflang tags
add_action('wp_head', function (): void {
    $plugin = st_multilang_plugin();
    if (! $plugin) {
        return;
    }

    $translations = [];

    if ($plugin === 'wpml') {
        $languages = apply_filters('wpml_active_languages', null, ['skip_missing' => 0]);
        if (is_array($languages)) {
            foreach ($languages as $lang) {
                $translations[] = [
                    'hreflang' => esc_attr($lang['language_code']),
                    'href'     => esc_url($lang['url']),
                ];
            }
        }
    }

    if ($plugin === 'polylang') {
        $languages = pll_the_languages(['raw' => 1]);
        if (is_array($languages)) {
            foreach ($languages as $lang) {
                $translations[] = [
                    'hreflang' => esc_attr($lang['locale']),
                    'href'     => esc_url($lang['url']),
                ];
            }
        }
    }

    foreach ($translations as $t) {
        echo '<link rel="alternate" hreflang="' . $t['hreflang'] . '" href="' . $t['href'] . '">' . "\n";
    }

    // x-default — points to default language
    $default_url = ($plugin === 'wpml')
        ? apply_filters('wpml_home_url', home_url('/'))
        : (function_exists('pll_home_url') ? pll_home_url() : home_url('/'));

    echo '<link rel="alternate" hreflang="x-default" href="' . esc_url($default_url) . '">' . "\n";
}, 3);

/**
 * Returns a language switcher HTML list.
 * Use in header template: echo st_language_switcher();
 */
function st_language_switcher(string $class = 'lang-switcher'): string {
    $plugin = st_multilang_plugin();
    if (! $plugin) {
        return '';
    }

    $languages = [];

    if ($plugin === 'wpml') {
        $langs = apply_filters('wpml_active_languages', null, ['skip_missing' => 1]);
        if (is_array($langs)) {
            foreach ($langs as $lang) {
                $languages[] = [
                    'label'   => esc_html($lang['native_name']),
                    'url'     => esc_url($lang['url']),
                    'active'  => (bool) $lang['active'],
                    'code'    => strtoupper($lang['language_code']),
                ];
            }
        }
    }

    if ($plugin === 'polylang') {
        $langs = pll_the_languages(['raw' => 1, 'hide_if_no_translation' => 0]);
        if (is_array($langs)) {
            foreach ($langs as $lang) {
                $languages[] = [
                    'label'  => esc_html($lang['name']),
                    'url'    => esc_url($lang['url']),
                    'active' => (bool) $lang['current_lang'],
                    'code'   => strtoupper($lang['slug']),
                ];
            }
        }
    }

    if (empty($languages)) {
        return '';
    }

    $out  = '<ul class="' . esc_attr($class) . '">';
    foreach ($languages as $lang) {
        $active = $lang['active'] ? ' aria-current="true"' : '';
        $out   .= '<li><a href="' . $lang['url'] . '"' . $active . '>' . $lang['code'] . '</a></li>';
    }
    $out .= '</ul>';

    return $out;
}
