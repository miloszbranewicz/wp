<?php
defined('ABSPATH') || exit;
get_header();
?>
<main id="main" role="main" class="container mx-auto px-4 py-8">
    <?php st_breadcrumbs(); ?>

    <?php while (have_posts()) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('max-w-3xl mx-auto'); ?>>
            <header class="mb-8">
                <h1 class="text-4xl font-bold text-gray-900"><?php the_title(); ?></h1>
            </header>
            <?php get_template_part('template-parts/content/content', 'page'); ?>
        </article>
    <?php endwhile; ?>
</main>
<?php get_footer(); ?>
