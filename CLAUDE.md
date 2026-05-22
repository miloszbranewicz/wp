# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Stack

- **PHP 8.1+** — classic templates, no framework
- **Vite 6** — asset bundler with manifest-based versioning and HMR
- **Tailwind CSS 3** — utility-first; purged in production via `content` globs
- **theme.json v3** — block editor palette, font sizes, layout widths (source of truth for design tokens)

## Commands

```bash
npm run dev          # Vite dev server + HMR (auto-creates .vite-dev, theme switches to dev mode)
npm run build        # Production build → dist/ (removes .vite-dev, theme switches to manifest)
npm run lint:js      # ESLint on assets/src/js/
npm run format       # Prettier write on assets/src/**/{js,css,json}
npm run format:check # Prettier check (used in CI)
npm run makepot      # Extract translatable strings → languages/starter-theme.pot
```

```bash
composer install            # Install PHP dev tools (PHPCS, PHPStan)
composer run lint            # PHPCS with WordPress Coding Standards
composer run analyse         # PHPStan level 5 on inc/, templates/, template-parts/
```

## Architecture

### Dev vs Production mode

`st_is_vite_dev()` (`inc/enqueue.php`) checks for a `.vite-dev` marker file created by `npm run dev` (via `predev` hook) and removed by `npm run build` (via `postbuild` hook). In dev mode all assets load from `http://localhost:5173`. In production they load from `dist/` via the Vite manifest at `dist/.vite/manifest.json`. No `wp-config.php` changes needed; override with `define('VITE_DEV_MODE', true)` if needed.

### CSS architecture

- `app.css` — `@tailwind base/components/utilities` + WP alignment utilities + component classes (`.btn-primary`, `.card`, etc.)
- `editor.css` — **no `@tailwind base`** (Preflight would clash with WP Admin styles); only `@tailwind components/utilities` + `.editor-styles-wrapper` wrapper
- `woocommerce.css` — loaded only on WC pages; enqueued conditionally in `inc/enqueue.php`

### Design token flow

`theme.json` → `settings.color.palette` auto-generates `--wp--preset--color--{slug}` CSS custom properties. `tailwind.config.js` → `theme.extend.colors` maps these vars as Tailwind utilities (e.g. `text-primary`, `bg-neutral-100`). When adding a new color: update both files.

### Vite externals

`@wordpress/*`, `react`, `react-dom` are externalized in `vite.config.js` — they are provided by WordPress globals (`wp.hooks`, `wp.blocks`, etc.) and must not be bundled.

### wp-config.php constants

```php
define('ST_GTM_ID', 'GTM-XXXXXXX');          // enables GTM + Consent Mode v2
define('ST_GTM_CONSENT_MODE', false);         // disables consent defaults (non-EU)
define('VITE_DEV_MODE', true);                // force dev mode without .vite-dev file
define('DISALLOW_FILE_EDIT', true);           // recommended; theme shows admin notice if missing
define('FORCE_SSL_ADMIN', true);              // recommended on production
```

### Function prefix convention

All theme functions use `st_` prefix. Key helpers in `inc/helpers.php`:

```php
st_responsive_image(int $id, string $size, string $size_2x, string $class, bool $priority)
// $priority=true → fetchpriority="high" loading="eager" for LCP images

st_svg(string $name, string $class, string $aria)
// inline SVG from assets/svg/{name}.svg; decorative icons get aria-hidden automatically

st_pagination()   // archive pagination with translated labels
st_is_woo()       // safe WooCommerce page check (works without WC active)
```

ACF helpers in `inc/acf.php` (all gracefully return defaults when ACF is inactive):

```php
st_get_field('key', 'default', $post_id)
st_acf_image('field', 'size', 'class')   // returns <img> with srcset
st_acf_link('field', 'class')            // returns <a> tag
```

## File map

| Path | Purpose |
|------|---------|
| `inc/enqueue.php` | Vite manifest loader, dev/prod switching, asset enqueuing |
| `inc/setup.php` | `add_theme_support`, nav menus, image sizes |
| `inc/seo.php` | Meta tags, OG, Twitter Cards, JSON-LD, breadcrumbs |
| `inc/performance.php` | WP head cleanup, Google Fonts, lazy images, CF7 conditional load |
| `inc/security.php` | HTTP security headers, user enumeration prevention, REST API hardening |
| `inc/gtm.php` | Google Tag Manager + Consent Mode v2 (requires `ST_GTM_ID` constant) |
| `inc/blocks.php` | Allowed block types whitelist, duotone disable |
| `inc/acf.php` | ACF helpers, Options Page registration |
| `inc/woocommerce.php` | WC wrapper swap, breadcrumb integration |
| `inc/multilang.php` | hreflang tags, `st_language_switcher()` |
| `inc/helpers.php` | `st_responsive_image()`, `st_svg()`, `st_pagination()`, `st_is_woo()` |
| `theme.json` | Design token source of truth — color palette, font sizes, spacing, layout widths |
| `phpstan.neon` | PHPStan level 5 config; ACF functions pre-ignored (optional plugin) |
| `phpcs.xml` | PHPCS config — WordPress Coding Standards, `st_` prefix enforcement |
| `scripts/makepot.cjs` | Node script that drives `npm run makepot` via `wp-pot` library |

## Common tasks

### Adding a new page template

Create `templates/template-{name}.php`:
```php
<?php /* Template Name: My Template */ ?>
```
Follow `page.php` pattern: `get_header()` → `<main>` → content → `get_footer()`.

### Changing the color palette

1. Edit `theme.json` → `settings.color.palette`
2. Mirror in `tailwind.config.js` → `theme.extend.colors` using `var(--wp--preset--color--{slug}, #fallback)`
3. Open the **Style Guide** page template to verify visually

### Adding ACF field groups

Use `acf_add_local_field_group()` in `inc/acf.php` or let ACF Pro auto-save JSON to `acf-json/`. CPTs and taxonomies are always registered via ACF Pro, not PHP boilerplate.

### Adding a new allowed block

Edit the array in `inc/blocks.php` → `allowed_block_types_all` filter.

## Deployment checklist

- [ ] `npm run build` — `dist/` generated, `.vite-dev` removed
- [ ] `define('DISALLOW_FILE_EDIT', true)` in `wp-config.php`
- [ ] `define('ST_GTM_ID', 'GTM-XXXXXXX')` in `wp-config.php` (if using analytics)
- [ ] Yoast SEO or RankMath activated (SEO meta auto-defers)
- [ ] Permalink structure set to `/%postname%/`
- [ ] `.htaccess` / Nginx cache headers configured
- [ ] Compiled `.mo` translation files deployed (not in git — add to rsync)
