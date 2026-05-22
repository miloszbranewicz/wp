<?php
/**
 * @var $block WP_Block
 */
defined('ABSPATH') || exit;

$autoplay = $attributes['autoplay'] ?? true;
$loop     = $attributes['loop']     ?? true;
$speed    = (int) ($attributes['speed'] ?? 500);

$wrapper_attrs = get_block_wrapper_attributes([
    'class'        => 'swiper',
    'data-autoplay' => $autoplay ? 'true' : 'false',
    'data-loop'     => $loop ? 'true' : 'false',
    'data-speed'    => (string) $speed,
]);
?>
<div <?php echo $wrapper_attrs; ?>>
    <div class="swiper-wrapper">
        <?php foreach ($block->inner_blocks as $inner_block ) : ?>
            <div class="swiper-slide">
                <?php echo $inner_block->render(); ?>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="swiper-pagination"></div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
</div>
