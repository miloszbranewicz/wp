<?php
/**
 * Template Name: Style Guide
 * Template Post Type: page
 *
 * Visual reference for design tokens and components.
 * Create a page in WP Admin, assign this template, publish.
 * Restricted to logged-in editors — not visible to public.
 */
defined('ABSPATH') || exit;

if (! current_user_can('edit_posts')) {
    wp_die(esc_html__('Access restricted.', 'starter-theme'), 403);
}

// Read design tokens from theme.json — always in sync with current config
$theme_json    = json_decode(file_get_contents(get_template_directory() . '/theme.json'), true); // phpcs:ignore
$colors        = $theme_json['settings']['color']['palette']              ?? [];
$font_sizes    = $theme_json['settings']['typography']['fontSizes']       ?? [];
$font_families = $theme_json['settings']['typography']['fontFamilies']    ?? [];

get_header();
?>
<main id="main" role="main" class="container mx-auto px-4 py-12 space-y-16">

    <header>
        <h1 class="text-4xl font-bold text-neutral-900 mb-2">Style Guide</h1>
        <p class="text-neutral-600">Design tokens and components. Restricted to editors.</p>
    </header>

    <?php /* ── 1. COLORS ── */ ?>
    <section>
        <h2 class="text-2xl font-bold text-neutral-900 mb-6 pb-2 border-b border-gray-200">Colors</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
            <?php foreach ($colors as $color) :
                $var = '--wp--preset--color--' . esc_attr($color['slug']);
            ?>
            <div class="flex items-center gap-3">
                <span class="w-10 h-10 rounded-lg shadow-sm border border-gray-200 flex-shrink-0"
                      style="background: var(<?php echo $var; ?>, <?php echo esc_attr($color['color']); ?>);"
                      aria-hidden="true"></span>
                <div>
                    <p class="text-sm font-semibold text-neutral-900 leading-tight"><?php echo esc_html($color['name']); ?></p>
                    <p class="text-xs text-neutral-600 font-mono"><?php echo esc_html($color['color']); ?></p>
                    <p class="text-xs text-neutral-400 font-mono"><?php echo esc_html($color['slug']); ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <?php /* ── 2. TYPOGRAPHY SCALE ── */ ?>
    <section>
        <h2 class="text-2xl font-bold text-neutral-900 mb-6 pb-2 border-b border-gray-200">Typography Scale</h2>
        <div class="space-y-4">
            <?php foreach (array_reverse($font_sizes) as $size) :
                $var = '--wp--preset--font-size--' . esc_attr($size['slug']);
            ?>
            <div class="flex items-baseline gap-6">
                <span class="w-12 text-right text-xs text-neutral-400 font-mono flex-shrink-0"><?php echo esc_html($size['slug']); ?></span>
                <span style="font-size: var(<?php echo $var; ?>, <?php echo esc_attr($size['size']); ?>); line-height: 1.2;">
                    The quick brown fox jumps over the lazy dog
                </span>
                <span class="text-xs text-neutral-400 font-mono"><?php echo esc_html($size['size']); ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <?php /* ── 3. FONT FAMILIES ── */ ?>
    <?php if ($font_families) : ?>
    <section>
        <h2 class="text-2xl font-bold text-neutral-900 mb-6 pb-2 border-b border-gray-200">Font Families</h2>
        <div class="space-y-6">
            <?php foreach ($font_families as $family) :
                $var = '--wp--preset--font-family--' . esc_attr($family['slug']);
            ?>
            <div>
                <p class="text-xs text-neutral-400 font-mono mb-1"><?php echo esc_html($family['name']); ?> — <code><?php echo esc_html($family['fontFamily']); ?></code></p>
                <p class="text-xl" style="font-family: var(<?php echo $var; ?>, <?php echo esc_attr($family['fontFamily']); ?>);">
                    The quick brown fox jumps over the lazy dog. 0123456789 !@#$%
                </p>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <?php /* ── 4. BUTTONS ── */ ?>
    <section>
        <h2 class="text-2xl font-bold text-neutral-900 mb-6 pb-2 border-b border-gray-200">Buttons</h2>
        <div class="flex flex-wrap gap-4 items-center">
            <button class="btn-primary"><?php esc_html_e('Primary Button', 'starter-theme'); ?></button>
            <button class="btn-secondary"><?php esc_html_e('Secondary Button', 'starter-theme'); ?></button>
            <button class="btn-primary" disabled><?php esc_html_e('Disabled', 'starter-theme'); ?></button>
        </div>
        <div class="mt-3 space-y-1">
            <p class="text-xs text-neutral-400 font-mono">.btn-primary — bg-primary text-white</p>
            <p class="text-xs text-neutral-400 font-mono">.btn-secondary — bg-white border text-gray-700</p>
        </div>
    </section>

    <?php /* ── 5. CARD ── */ ?>
    <section>
        <h2 class="text-2xl font-bold text-neutral-900 mb-6 pb-2 border-b border-gray-200">Card</h2>
        <div class="max-w-sm">
            <div class="card p-5">
                <div class="w-full h-32 bg-neutral-100 rounded-lg mb-4 flex items-center justify-center text-neutral-400 text-sm">Image placeholder</div>
                <h3 class="font-semibold text-neutral-900 mb-2">Card Title</h3>
                <p class="text-sm text-neutral-600 mb-4">Card description text that spans a couple of lines to show the layout correctly.</p>
                <a href="#" class="btn-primary text-sm"><?php esc_html_e('Read more', 'starter-theme'); ?></a>
            </div>
        </div>
        <p class="mt-3 text-xs text-neutral-400 font-mono">.card — rounded-xl shadow-sm hover:shadow-md</p>
    </section>

    <?php /* ── 6. BREADCRUMB ── */ ?>
    <section>
        <h2 class="text-2xl font-bold text-neutral-900 mb-6 pb-2 border-b border-gray-200">Breadcrumb</h2>
        <nav class="breadcrumb" aria-label="Breadcrumb example">
            <a href="#">Home</a> &rsaquo;
            <a href="#">Category</a> &rsaquo;
            <span aria-current="page">Current Page</span>
        </nav>
        <p class="mt-3 text-xs text-neutral-400 font-mono">.breadcrumb — text-sm text-gray-500</p>
    </section>

    <?php /* ── 7. PAGINATION ── */ ?>
    <section>
        <h2 class="text-2xl font-bold text-neutral-900 mb-6 pb-2 border-b border-gray-200">Pagination</h2>
        <div class="pagination">
            <a href="#" class="page-numbers">&laquo;</a>
            <a href="#" class="page-numbers">1</a>
            <span class="page-numbers current">2</span>
            <a href="#" class="page-numbers">3</a>
            <a href="#" class="page-numbers">&raquo;</a>
        </div>
        <p class="mt-3 text-xs text-neutral-400 font-mono">.page-numbers — .page-numbers.current</p>
    </section>

    <?php /* ── 8. WP BLOCK OVERRIDES ── */ ?>
    <section>
        <h2 class="text-2xl font-bold text-neutral-900 mb-6 pb-2 border-b border-gray-200">WP Block Overrides</h2>
        <div class="space-y-6 max-w-2xl">
            <blockquote class="wp-block-quote">
                <p>Great design is making something memorable and meaningful. — Dieter Rams</p>
            </blockquote>
            <hr class="wp-block-separator">
            <div class="entry-content">
                <h2>Prose heading (entry-content)</h2>
                <p>This is body text inside <code>.entry-content</code>. Links look <a href="#">like this</a>. Lists:</p>
                <ul><li>Item one</li><li>Item two</li><li>Item three</li></ul>
                <p>And a blockquote inside prose:</p>
                <blockquote><p>Quoted text inside entry-content.</p></blockquote>
            </div>
        </div>
    </section>

    <?php /* ── 9. FORM ELEMENTS ── */ ?>
    <section>
        <h2 class="text-2xl font-bold text-neutral-900 mb-6 pb-2 border-b border-gray-200">Form Elements</h2>
        <p class="text-sm text-neutral-500 mb-4">Styled by <code>@tailwindcss/forms</code> — used by Contact Form 7 and custom forms.</p>
        <div class="max-w-md space-y-4">
            <div>
                <label class="block text-sm font-medium text-neutral-900 mb-1" for="sg-text">Text input</label>
                <input id="sg-text" type="text" placeholder="Enter text…" class="w-full">
            </div>
            <div>
                <label class="block text-sm font-medium text-neutral-900 mb-1" for="sg-textarea">Textarea</label>
                <textarea id="sg-textarea" rows="3" placeholder="Enter message…" class="w-full"></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-neutral-900 mb-1" for="sg-select">Select</label>
                <select id="sg-select" class="w-full">
                    <option>Option A</option>
                    <option>Option B</option>
                    <option>Option C</option>
                </select>
            </div>
            <div class="flex items-center gap-2">
                <input id="sg-check" type="checkbox" checked>
                <label for="sg-check" class="text-sm text-neutral-900">Checkbox label</label>
            </div>
        </div>
    </section>

</main>
<?php get_footer(); ?>
