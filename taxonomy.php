<?php
defined('ABSPATH') || exit;
get_header();

$term = get_queried_object();
?>
<main id="main" role="main" class="container mx-auto px-4 py-8">
    <?php st_breadcrumbs(); ?>

    <header class="mb-10">
        <h1 class="text-3xl font-bold text-gray-900">
            <?php echo esc_html($term->name); ?>
        </h1>
        <?php if ($term->description) : ?>
            <div class="mt-3 text-gray-600"><?php echo wp_kses_post($term->description); ?></div>
        <?php endif; ?>
    </header>

    <?php if (have_posts()) : ?>
        <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
            <?php while (have_posts()) : the_post(); ?>
                <?php get_template_part('template-parts/content/content'); ?>
            <?php endwhile; ?>
        </div>
        <?php st_pagination(); ?>
    <?php else : ?>
        <?php get_template_part('template-parts/content/content', 'none'); ?>
    <?php endif; ?>
</main>
<?php get_footer(); ?>
