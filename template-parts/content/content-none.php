<?php
defined('ABSPATH') || exit;
?>
<section class="py-16 text-center">
    <h2 class="text-2xl font-bold text-gray-900 mb-4">
        <?php esc_html_e('Nothing found', 'starter-theme'); ?>
    </h2>
    <p class="text-gray-600 mb-8">
        <?php esc_html_e('Try searching or browse the homepage.', 'starter-theme'); ?>
    </p>
    <?php get_search_form(); ?>
</section>
