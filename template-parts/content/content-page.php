<?php
defined('ABSPATH') || exit;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="entry-content">
        <?php
        the_content();
        wp_link_pages([
            'before' => '<nav class="page-links" aria-label="' . esc_attr__('Page navigation', 'starter-theme') . '">',
            'after'  => '</nav>',
        ]);
        ?>
    </div>
</article>
