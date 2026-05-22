/**
 * Block editor customizations.
 * Runs only in wp-admin / block editor context.
 *
 * All @wordpress/* packages are provided by WordPress and loaded as globals
 * (wp.blocks, wp.blockEditor, etc.) via enqueue_block_editor_assets deps.
 * Do NOT import them as ES modules — they are not installed as npm packages
 * and Vite dev server would fail to resolve them.
 */

wp.domReady(() => {
    // Ghost button: transparent background, primary border.
    // CSS in app.css + editor.css: .wp-block-button.is-style-ghost
    wp.blocks.registerBlockStyle('core/button', {
        name: 'ghost',
        label: 'Ghost',
        isDefault: false,
    });

    const { useBlockProps, InnerBlocks, InspectorControls } = wp.blockEditor;
    const { PanelBody, ToggleControl } = wp.components;
    const { createElement: h, Fragment } = wp.element;

    wp.blocks.registerBlockType('starter-theme/slider', {
        edit: function SliderEdit({ attributes, setAttributes }) {
            const { autoplay, loop } = attributes;
            const blockProps = useBlockProps({
                className: 'swiper border-2 border-dashed border-gray-300 p-4 rounded-lg',
            });
            return h(
                Fragment,
                null,
                h(
                    InspectorControls,
                    null,
                    h(
                        PanelBody,
                        { title: 'Slider Settings' },
                        h(ToggleControl, {
                            label: 'Autoplay',
                            checked: autoplay,
                            onChange: (v) => setAttributes({ autoplay: v }),
                        }),
                        h(ToggleControl, {
                            label: 'Loop',
                            checked: loop,
                            onChange: (v) => setAttributes({ loop: v }),
                        })
                    )
                ),
                h(
                    'div',
                    blockProps,
                    h(InnerBlocks, {
                        allowedBlocks: ['core/image'],
                        template: [['core/image'], ['core/image']],
                    })
                )
            );
        },
        save: () => {
            const { InnerBlocks: IB } = wp.blockEditor;
            return h(IB.Content, null);
        },
    });
});

wp.hooks.addFilter(
    'blocks.registerBlockType',
    'starter-theme/block-defaults',
    (settings) => settings
);
