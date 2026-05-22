<?php
defined('ABSPATH') || exit;
get_header();
?>
<main id="main" role="main" class="container mx-auto px-4 py-8">
    <header class="mb-10">
        <h1 class="text-3xl font-bold text-gray-900">
            <?php printf(
                esc_html__('Search results for: %s', 'starter-theme'),
                '<span class="text-primary">' . esc_html(get_search_query()) . '</span>'
            ); ?>
        </h1>
    </header>

    <?php if (have_posts()) : ?>
        <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
            <?php while (have_posts()) : the_post(); ?>
                <?php get_template_part('template-parts/content/content'); ?>
            <?php endwhile; ?>
        </div>
        <?php the_posts_pagination(['mid_size' => 2]); ?>
    <?php else : ?>
        <?php get_template_part('template-parts/content/content', 'none'); ?>
    <?php endif; ?>
</main>
<?php get_footer(); ?>
