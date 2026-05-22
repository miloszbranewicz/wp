<?php
defined('ABSPATH') || exit;
get_header();
?>
<main id="main" role="main" class="container mx-auto px-4 py-24 text-center">
    <h1 class="text-8xl font-black text-gray-200 mb-4">404</h1>
    <p class="text-2xl font-bold text-gray-900 mb-3">
        <?php esc_html_e('Page not found', 'starter-theme'); ?>
    </p>
    <p class="text-gray-600 mb-8">
        <?php esc_html_e('The page you are looking for does not exist or has been moved.', 'starter-theme'); ?>
    </p>
    <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-flex items-center px-6 py-3 bg-primary text-white font-medium rounded-lg hover:bg-primary-dark transition-colors">
        <?php esc_html_e('Back to homepage', 'starter-theme'); ?>
    </a>
</main>
<?php get_footer(); ?>
