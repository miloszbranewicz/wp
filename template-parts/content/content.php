<?php
defined('ABSPATH') || exit;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('group bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow'); ?>>
    <?php if (has_post_thumbnail()) : ?>
        <a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
            <?php the_post_thumbnail('card', [
                'class'   => 'w-full h-48 object-cover',
                'loading' => 'lazy',
            ]); ?>
        </a>
    <?php endif; ?>

    <div class="p-6">
        <header class="mb-3">
            <h2 class="text-xl font-semibold text-gray-900 group-hover:text-primary">
                <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
            </h2>
            <div class="text-sm text-gray-500 mt-1">
                <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                    <?php echo esc_html(get_the_date()); ?>
                </time>
            </div>
        </header>

        <div class="text-gray-600 text-sm leading-relaxed">
            <?php the_excerpt(); ?>
        </div>

        <a href="<?php the_permalink(); ?>" class="inline-block mt-4 text-sm font-medium text-primary hover:underline">
            <?php esc_html_e('Read more', 'starter-theme'); ?> <span aria-hidden="true">&rarr;</span>
        </a>
    </div>
</article>
