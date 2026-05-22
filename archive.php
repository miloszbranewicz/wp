<?php
defined('ABSPATH') || exit;
get_header();
?>
<main id="main" role="main" class="container mx-auto px-4 py-8">
    <?php st_breadcrumbs(); ?>

    <header class="mb-10">
        <h1 class="text-3xl font-bold text-gray-900"><?php the_archive_title(); ?></h1>
        <?php $desc = get_the_archive_description(); if ($desc) : ?>
            <div class="mt-3 text-gray-600"><?php echo wp_kses_post($desc); ?></div>
        <?php endif; ?>
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
