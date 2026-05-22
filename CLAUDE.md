# Starter Theme — Claude Code Guide

WordPress hybrid starter theme (classic PHP + block editor). SEO & performance focused.

## Stack

- **PHP 8.1+** — classic templates, no framework
- **Vite 6** — asset bundler (`npm run dev` / `npm run build`)
- **Tailwind CSS 3** — utility-first, purged in production
- **theme.json** — block editor palette, font sizes, layout widths

## Development workflow

```bash
# Start Vite dev server (HMR) — auto-creates .vite-dev marker, theme detects dev mode
npm run dev

# Production build — removes .vite-dev marker, theme switches to dist/
npm run build
```

> No changes to `wp-config.php` needed. Dev mode is detected automatically via `.vite-dev` file.
> Override: `define('VITE_DEV_MODE', true)` in `wp-config.php` still works if needed.

## File map

| Path | Purpose |
|------|---------|
| `inc/setup.php` | `add_theme_support`, nav menus, image sizes |
| `inc/enqueue.php` | Vite manifest loader, asset enqueuing |
| `inc/seo.php` | Meta tags, OG, Twitter Cards, JSON-LD, breadcrumbs |
| `inc/performance.php` | WP head cleanup, lazy images, CF7 conditional load |
| `inc/blocks.php` | Allowed block types list, duotone disable |
| `inc/acf.php` | `st_get_field()`, `st_acf_image()`, `st_acf_link()`, Options Page |
| `inc/woocommerce.php` | WC wrapper swap, breadcrumb integration |
| `inc/multilang.php` | hreflang tags, `st_language_switcher()` |
| `inc/helpers.php` | `st_responsive_image()`, `st_svg()`, `st_vite_asset()` |
| `theme.json` | Color palette, font sizes, spacing, layout widths |
| `assets/src/css/app.css` | Tailwind layers + WP alignment + component classes |
| `assets/src/css/editor.css` | Block editor mirror styles |
| `assets/src/css/woocommerce.css` | WooCommerce UI overrides |
| `assets/src/js/app.js` | Mobile nav toggle (vanilla JS) |
| `assets/src/js/editor.js` | Block editor customizations |

## Key functions

```php
// ACF safe getter (graceful if ACF inactive)
st_get_field('hero_title', 'Default title', $post_id);

// ACF image with srcset
echo st_acf_image('hero_image', 'hero', 'w-full h-auto rounded-xl');

// ACF link tag
echo st_acf_link('cta_link', 'btn-primary');

// Responsive WP attachment image
echo st_responsive_image(123, 'card', 'card-2x', 'w-full h-auto');

// Breadcrumbs (auto-detects Yoast/RankMath, falls back to custom)
st_breadcrumbs();

// Language switcher (auto-detects WPML/Polylang)
echo st_language_switcher('flex gap-2 text-sm');
```

## Adding a new template

1. Create `templates/template-{name}.php` with header comment:
   ```php
   <?php /* Template Name: My Template */ ?>
   ```
2. Follow pattern from `page.php` — `get_header()` → `<main>` → content → `get_footer()`
3. Use `st_breadcrumbs()` where appropriate

## Adding ACF field groups

Register groups in `inc/acf.php` using `acf_add_local_field_group()` or JSON sync. Keep group JSON in `acf-json/` (ACF auto-saves there).

## Extending the allowed block list

Edit the array in `inc/blocks.php` → `allowed_block_types_all` filter.

## Changing the color palette

Edit `theme.json` → `settings.color.palette`. CSS variables are auto-generated as `--wp--preset--color--{slug}`. Tailwind picks them up via `tailwind.config.js` `theme.extend.colors`.

## Deployment checklist

- [ ] `npm run build` — dist/ generated, `.vite-dev` marker removed
- [ ] `.htaccess` / Nginx cache headers configured
- [ ] Yoast SEO or RankMath activated (SEO meta falls back to built-in if neither present)
- [ ] Permalink structure set to `/%postname%/`
