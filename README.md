# Starter Theme

WordPress hybrid starter theme for software house projects. Classic PHP templates + block editor, SEO & performance focused.

## Stack

| | |
|---|---|
| **PHP** | 8.1+ |
| **WordPress** | 6.4+ |
| **Bundler** | Vite 6 |
| **CSS** | Tailwind CSS 3 |
| **Block editor** | theme.json v3 |

## Requirements

- Node 18+
- npm 9+
- Local WordPress install (e.g. Local by Flywheel)

## Quick start

```bash
npm install
npm run dev      # Vite dev server + HMR, auto-detects WordPress URL
npm run build    # Production build → dist/
```

> Dev mode is detected automatically via a `.vite-dev` marker file — no changes to `wp-config.php` needed.
> Override: `define('VITE_DEV_MODE', true)` in `wp-config.php` still works.

## Key features

- **Vite HMR** — instant CSS/JS updates in WordPress dev mode
- **Manifest-based asset versioning** — hashed filenames in production
- **SEO suite** — JSON-LD (WebSite, Organization, Article, BreadcrumbList), OG, Twitter Cards, canonical; defers to Yoast/RankMath when active
- **Performance** — WP head cleanup, per-block CSS, lazy images, conditional CF7 assets, query string removal
- **ACF helpers** — `st_get_field()`, `st_acf_image()`, `st_acf_link()` with graceful fallbacks when ACF is inactive
- **WooCommerce** — wrapper swap, breadcrumb integration, `woocommerce.css` loaded only on WC pages
- **WPML / Polylang** — hreflang tags, `st_language_switcher()` helper
- **Block editor** — `editor.css` mirrors frontend styles, `theme.json` palette + font sizes, allowed block whitelist

## Customization

### Font

Default: **Inter** via Google Fonts (loaded in `inc/performance.php`).

For GDPR / self-hosted:
```bash
npm install @fontsource/inter
```
Then replace the `<link>` in `inc/performance.php` with imports in `assets/src/js/app.js`:
```js
import '@fontsource/inter/400.css';
import '@fontsource/inter/500.css';
import '@fontsource/inter/600.css';
import '@fontsource/inter/700.css';
```

### Colors

Edit `theme.json` → `settings.color.palette`. CSS custom properties are auto-generated as `--wp--preset--color--{slug}`. Mirror any new tokens in `tailwind.config.js` → `theme.extend.colors`.

### Custom Post Types

Register CPTs and taxonomies via **ACF Pro** (version 6.x has built-in CPT/Taxonomy registration). Field group JSON is auto-saved to `acf-json/`.

## File map

| Path | Purpose |
|------|---------|
| `inc/setup.php` | `add_theme_support`, nav menus, image sizes |
| `inc/enqueue.php` | Vite manifest loader, asset enqueuing |
| `inc/seo.php` | Meta tags, OG, Twitter Cards, JSON-LD, breadcrumbs |
| `inc/performance.php` | WP head cleanup, font load, lazy images, CF7 |
| `inc/blocks.php` | Allowed block types, duotone disable |
| `inc/acf.php` | ACF helpers, Options Page registration |
| `inc/woocommerce.php` | WC wrapper swap, breadcrumb integration |
| `inc/multilang.php` | hreflang tags, `st_language_switcher()` |
| `inc/helpers.php` | `st_responsive_image()`, `st_svg()`, `st_pagination()` |
| `assets/src/css/app.css` | Tailwind layers + WP alignment + component classes |
| `assets/src/css/editor.css` | Block editor mirror styles |
| `assets/src/css/woocommerce.css` | WooCommerce UI overrides |
| `theme.json` | Color palette, font sizes, layout widths |
| `acf-json/` | ACF field group JSON sync (auto-saved by ACF Pro) |

## Using as a project base

**GitHub Template** (recommended):
Use the green `Use this template` button to create a new repo with a clean history.

**Manual clone:**
```bash
git clone <repo-url> my-project
cd my-project
rm -rf .git
git init && git add . && git commit -m "Initial commit from starter-theme"
```

## Plugin compatibility

| Plugin | Support |
|--------|---------|
| ACF / ACF Pro | Helpers + JSON sync + Options Page |
| Yoast SEO | Auto-detected, SEO meta deferred |
| RankMath | Auto-detected, SEO meta deferred |
| WooCommerce | Theme support, wrapper, styles |
| WPML | hreflang, language switcher |
| Polylang | hreflang, language switcher |
| Contact Form 7 | Assets loaded only on pages with `[contact-form-7]` shortcode |
