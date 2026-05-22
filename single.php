<?php
defined('ABSPATH') || exit;
get_header();
?>
<main id="main" role="main" class="container mx-auto px-4 py-8">
    <?php st_breadcrumbs(); ?>

    <?php while (have_posts()) : the_post(); ?>
        <article
            id="post-<?php the_ID(); ?>"
            <?php post_class('max-w-3xl mx-auto'); ?>
            itemscope
            itemtype="https://schema.org/Article"
        >
            <header class="mb-8">
                <h1 class="text-4xl font-bold text-gray-900 mb-4" itemprop="headline">
                    <?php the_title(); ?>
                </h1>

                <div class="flex items-center gap-4 text-sm text-gray-500">
                    <time datetime="<?php echo esc_attr(get_the_date('c')); ?>" itemprop="datePublished">
                        <?php echo esc_html(get_the_date()); ?>
                    </time>
                    <span itemprop="author" itemscope itemtype="https://schema.org/Person">
                        <?php esc_html_e('By', 'starter-theme'); ?>
                        <span itemprop="name"><?php the_author(); ?></span>
                    </span>
                    <?php the_category(', '); ?>
                </div>
            </header>

            <?php if (has_post_thumbnail()) : ?>
                <div class="mb-8 rounded-xl overflow-hidden">
                    <?php the_post_thumbnail('hero', [
                        'class'    => 'w-full h-auto',
                        'itemprop' => 'image',
                    ]); ?>
                </div>
            <?php endif; ?>

            <div class="entry-content" itemprop="articleBody">
                <?php the_content(); ?>
                <?php wp_link_pages(['before' => '<nav class="page-links">', 'after' => '</nav>']); ?>
            </div>

            <footer class="mt-12 pt-8 border-t border-gray-200">
                <?php the_tags('<div class="flex flex-wrap gap-2 text-sm">', ', ', '</div>'); ?>
            </footer>
        </article>

        <?php the_post_navigation([
            'prev_text' => '&larr; %title',
            'next_text' => '%title &rarr;',
        ]); ?>

        <?php if (comments_open() || get_comments_number()) : ?>
            <?php comments_template(); ?>
        <?php endif; ?>

    <?php endwhile; ?>
</main>
<?php get_footer(); ?>
