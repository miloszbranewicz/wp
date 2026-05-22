/**
 * Block editor customizations.
 * Runs only in wp-admin/block editor context.
 */
import { addFilter } from '@wordpress/hooks';
import { registerBlockStyle } from '@wordpress/blocks';
import domReady from '@wordpress/dom-ready';

domReady(() => {
    // Ghost button: transparent background, primary border.
    // CSS in app.css + editor.css: .wp-block-button.is-style-ghost
    registerBlockStyle('core/button', {
        name: 'ghost',
        label: 'Ghost',
        isDefault: false,
    });

    // To remove a built-in embed variation:
    // wp.blocks.unregisterBlockVariation('core/embed', 'spotify');
});

// Placeholder for block attribute filters — extend as needed per project
addFilter('blocks.registerBlockType', 'starter-theme/block-defaults', (settings) => settings);
