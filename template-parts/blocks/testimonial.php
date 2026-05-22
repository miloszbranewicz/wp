<?php
/**
 * ACF Block: Testimonial
 * Slug: acf/testimonial
 * Register in inc/acf.php via acf_register_block_type().
 * Fields: testimonial_quote, testimonial_author, testimonial_role, testimonial_avatar (image).
 */
defined('ABSPATH') || exit;

$quote  = st_get_field('testimonial_quote', __('Add your testimonial text here.', 'starter-theme'));
$author = st_get_field('testimonial_author', __('Author Name', 'starter-theme'));
$role   = st_get_field('testimonial_role');
$avatar = st_acf_image('testimonial_avatar', 'thumbnail', 'w-12 h-12 rounded-full object-cover flex-shrink-0');
?>
<figure class="card p-6 flex flex-col gap-4" <?php echo get_block_wrapper_attributes(); ?>>
    <blockquote class="text-neutral-600 italic m-0 border-0 p-0">
        "<?php echo esc_html($quote); ?>"
    </blockquote>
    <figcaption class="flex items-center gap-3 mt-auto pt-4 border-t border-gray-100">
        <?php echo $avatar; ?>
        <div>
            <p class="font-semibold text-neutral-900 text-sm m-0"><?php echo esc_html($author); ?></p>
            <?php if ($role) : ?>
                <p class="text-xs text-neutral-500 m-0"><?php echo esc_html($role); ?></p>
            <?php endif; ?>
        </div>
    </figcaption>
</figure>
