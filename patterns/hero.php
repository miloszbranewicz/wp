<?php
/**
 * Title: Hero Section
 * Slug: starter-theme/hero
 * Categories: banner
 * Description: Full-width hero with heading, description, and two CTA buttons.
 * Keywords: hero, banner, cta, heading
 * Inserter: true
 */
?>
<!-- wp:group {"align":"full","backgroundColor":"neutral-900","style":{"spacing":{"padding":{"top":"5rem","bottom":"5rem"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-neutral-900-background-color has-background">
<!-- wp:heading {"textAlign":"center","level":1,"textColor":"white"} -->
<h1 class="wp-block-heading has-text-align-center has-white-color has-text-color">Your Page Headline</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","textColor":"neutral-100"} -->
<p class="has-text-align-center has-neutral-100-color has-text-color">A compelling description that explains your value proposition. Replace this text with your own content.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"style":{"spacing":{"margin":{"top":"2rem"}}}} -->
<div class="wp-block-buttons">
<!-- wp:button {"backgroundColor":"primary","textColor":"white"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-primary-background-color has-white-color has-background has-text-color wp-element-button">Get Started</a></div>
<!-- /wp:button -->
<!-- wp:button {"className":"is-style-ghost"} -->
<div class="wp-block-button is-style-ghost"><a class="wp-block-button__link wp-element-button">Learn More</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->
