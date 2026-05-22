<!DOCTYPE html>
<html <?php language_attributes(); ?> class="scroll-smooth">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php get_template_part('template-parts/head/meta'); ?>
    <?php wp_head(); ?>
</head>
<body <?php body_class('antialiased'); ?>>
<?php wp_body_open(); ?>
<a href="#main" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 bg-white px-4 py-2 rounded z-50">
    <?php esc_html_e('Skip to content', 'starter-theme'); ?>
</a>

<header id="site-header" role="banner" class="sticky top-0 z-40 bg-white shadow-sm">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">

            <div class="site-branding">
                <?php if (has_custom_logo()) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" rel="home" class="text-xl font-bold text-gray-900 hover:text-primary">
                        <?php bloginfo('name'); ?>
                    </a>
                <?php endif; ?>
            </div>

            <?php get_template_part('template-parts/navigation/nav-primary'); ?>

            <?php echo st_language_switcher('flex items-center gap-2 text-sm font-medium'); ?>

        </div>
    </div>
</header>
