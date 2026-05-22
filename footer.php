<footer id="site-footer" role="contentinfo" class="bg-gray-900 text-gray-300 mt-16">
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 gap-8 md:grid-cols-3">

            <div class="footer-brand">
                <?php if (has_custom_logo()) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <p class="text-white font-bold text-lg"><?php bloginfo('name'); ?></p>
                <?php endif; ?>
                <p class="mt-2 text-sm"><?php bloginfo('description'); ?></p>
            </div>

            <?php if (has_nav_menu('footer')) : ?>
                <nav aria-label="<?php esc_attr_e('Footer Menu', 'starter-theme'); ?>">
                    <?php wp_nav_menu([
                        'theme_location' => 'footer',
                        'menu_class'     => 'flex flex-col gap-2 text-sm',
                        'container'      => false,
                        'depth'          => 1,
                    ]); ?>
                </nav>
            <?php endif; ?>

            <div class="footer-info text-sm">
                <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>.</p>
            </div>

        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
