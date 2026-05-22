<?php
defined('ABSPATH') || exit;
get_header();
?>
<main id="main" role="main">
    <?php while (have_posts()) : the_post(); ?>
        <?php get_template_part('template-parts/content/content', 'page'); ?>
    <?php endwhile; ?>
</main>
<?php get_footer(); ?>
