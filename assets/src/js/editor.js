/**
 * Block editor customizations.
 * Runs only in wp-admin/block editor context.
 */
import { addFilter } from '@wordpress/hooks';
import domReady from '@wordpress/dom-ready';

// Remove unwanted block variations (extend as needed)
domReady(() => {
    // Example: unregister embed variations not needed
    // wp.blocks.unregisterBlockVariation('core/embed', 'spotify');
});

// Add custom block category
addFilter(
    'blocks.registerBlockType',
    'starter-theme/block-defaults',
    (settings) => settings,
);
