<?php
/**
 * Title: Text + Image
 * Slug: starter-theme/text-image
 * Categories: columns
 * Description: Two-column layout with heading, text, bullet list, and CTA on the left; image on the right.
 * Keywords: columns, text, image, features, two column
 * Inserter: true
 */
?>
<!-- wp:columns {"verticalAlignment":"center","align":"wide"} -->
<div class="wp-block-columns alignwide are-vertically-aligned-center">
<!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center">
<!-- wp:heading -->
<h2 class="wp-block-heading">Section Heading</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Your description text goes here. Explain the key benefit or feature you want to highlight in this section.</p>
<!-- /wp:paragraph -->

<!-- wp:list -->
<ul class="wp-block-list"><li>First key benefit or feature</li><li>Second key benefit or feature</li><li>Third key benefit or feature</li></ul>
<!-- /wp:list -->

<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"1.5rem"}}}} -->
<div class="wp-block-buttons">
<!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button">Call to Action</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center">
<!-- wp:image {"sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img alt="" src=""/></figure>
<!-- /wp:image -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
