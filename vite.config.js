import { defineConfig } from 'vite';
import { resolve } from 'path';

export default defineConfig(({ command }) => ({
  root: '.',
  base: command === 'build' ? '/wp-content/themes/starter-theme/dist/' : '/',
  build: {
    outDir: 'dist',
    manifest: true,
    assetsDir: 'assets',
    sourcemap: false,
    rollupOptions: {
      input: {
        app: resolve(__dirname, 'assets/src/js/app.js'),
        'app-css': resolve(__dirname, 'assets/src/css/app.css'),
        editor: resolve(__dirname, 'assets/src/js/editor.js'),
        'editor-css': resolve(__dirname, 'assets/src/css/editor.css'),
        'woocommerce-css': resolve(__dirname, 'assets/src/css/woocommerce.css'),
        slider: resolve(__dirname, 'assets/src/js/slider.js'),
      },
      external: [
        /^@wordpress\/.*/,
        /^react$/,
        /^react-dom$/,
      ],
      output: {
        globals: {
          '@wordpress/hooks': 'wp.hooks',
          '@wordpress/dom-ready': 'wp.domReady',
          '@wordpress/blocks': 'wp.blocks',
          '@wordpress/block-editor': 'wp.blockEditor',
          '@wordpress/components': 'wp.components',
          '@wordpress/element': 'wp.element',
          '@wordpress/edit-post': 'wp.editPost',
          'react': 'React',
          'react-dom': 'ReactDOM',
        },
      },
    },
  },
  server: {
    port: 5173,
    strictPort: true,
    cors: true,
    origin: 'http://localhost:5173',
    hmr: {
      host: 'localhost',
      protocol: 'ws',
      port: 5173,
    },
  },
  css: {
    devSourcemap: true,
  },
}));
