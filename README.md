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
| **PHP linting** | PHPCS + WordPress Coding Standards |
| **PHP analysis** | PHPStan level 5 |
| **JS linting** | ESLint 9 |
| **Formatting** | Prettier 3 |

## Requirements

- Node 18+, npm 9+
- PHP 8.1+ with Composer
- Local WordPress install (e.g. Local by Flywheel)

## Quick start

```bash
npm install
composer install     # PHP code quality tools (PHPCS, PHPStan)
npm run dev          # Vite dev server + HMR
npm run build        # Production build → dist/
```

> Dev mode is detected automatically via a `.vite-dev` marker file — no `wp-config.php` changes needed.

## Key features

- **Vite HMR** — instant CSS/JS updates in WordPress dev mode; manifest-based hashed filenames in production
- **SEO suite** — JSON-LD (WebSite, Organization, Article, BreadcrumbList), OG, Twitter Cards, canonical; auto-defers to Yoast/RankMath when active
- **Security** — HTTP security headers (CSP, HSTS, X-Frame-Options, Permissions-Policy), user enumeration prevention, REST API hardening, generic login errors
- **GTM + Consent Mode v2** — Google Tag Manager with all consent states defaulting to `denied`; required for GA4/Ads in the EU since March 2024
- **Performance** — WP head cleanup, per-block CSS, lazy images with CLS prevention, conditional CF7 assets, CSS preload hint for LCP
- **ACF helpers** — `st_get_field()`, `st_acf_image()`, `st_acf_link()` with graceful fallbacks when ACF is inactive
- **WooCommerce** — wrapper swap, breadcrumb integration, `woocommerce.css` loaded only on WC pages
- **WPML / Polylang** — hreflang tags, `st_language_switcher()` helper
- **Block editor** — `editor.css` mirrors frontend styles, `theme.json` palette + font sizes, allowed block whitelist
- **CI/CD** — GitHub Actions (PHP lint + PHPCS + PHPStan, ESLint + Prettier, Vite build); rsync deployment to staging/production

## Figma → Theme workflow

1. Designer delivers Figma file with **Variables** (colors, typography, spacing)
2. Dev extracts color hex values → updates `theme.json` → `settings.color.palette`
   - `slug` becomes the CSS class suffix: `text-primary`, `bg-neutral-100`
   - CSS custom property auto-generated: `--wp--preset--color--{slug}`
3. Mirror new slugs in `tailwind.config.js` → `theme.extend.colors`:
   ```js
   'primary': 'var(--wp--preset--color--primary, #2563eb)',
   ```
4. For typography: update `theme.json` → `settings.typography.fontFamilies` + `tailwind.config.js` → `fontFamily.sans`
5. Run `npm run build` (or `npm run dev` for live reload)
6. **Verify in browser**: create a WordPress page, assign the **Style Guide** template → all tokens and components render live from `theme.json`

### Building components

| Use case | Where |
|----------|-------|
| Reusable utility class (button, badge) | `@layer components` in `assets/src/css/app.css` |
| Repeatable section (hero, features grid) | `template-parts/` PHP file + ACF field group |
| Client-editable content section | Block pattern in `inc/blocks.php` |
| Page-specific layout | `templates/template-{name}.php` |

## Code quality

```bash
npm run lint:js        # ESLint
npm run format         # Prettier (write)
npm run format:check   # Prettier (CI check)
composer run lint      # PHPCS — WordPress Coding Standards
composer run analyse   # PHPStan level 5
```

Pre-commit hooks (Husky + lint-staged) auto-run Prettier and ESLint on staged JS/CSS files, and `php -l` on staged PHP files.

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

### Translation

All user-facing strings use `__()`, `_e()`, `esc_html__()` with the `starter-theme` domain. Generate a `.pot` template for translators:

```bash
npm run makepot   # → languages/starter-theme.pot
```

Open the `.pot` in **PoEdit** or use **Loco Translate** for in-browser translation. Compiled `.mo`/`.po` files are excluded from git — include them in the deploy rsync.

### GTM + Analytics

Add to `wp-config.php` per project:

```php
define('ST_GTM_ID', 'GTM-XXXXXXX');   // enables GTM with Consent Mode v2 defaults
```

Consent Mode v2 defaults all consent states to `denied`. Your CMP (Cookiebot, CookieYes, or custom) must call `gtag('consent', 'update', {...})` after user acceptance. To disable consent defaults (non-EU sites):

```php
define('ST_GTM_CONSENT_MODE', false);
```

## File map

| Path | Purpose |
|------|---------|
| `inc/enqueue.php` | Vite manifest loader, dev/prod switching, asset enqueuing |
| `inc/setup.php` | `add_theme_support`, nav menus, image sizes |
| `inc/seo.php` | Meta tags, OG, Twitter Cards, JSON-LD, breadcrumbs |
| `inc/performance.php` | WP head cleanup, font load, lazy images, CF7 |
| `inc/security.php` | HTTP security headers, user enumeration prevention, REST API hardening |
| `inc/gtm.php` | Google Tag Manager + Consent Mode v2 |
| `inc/blocks.php` | Allowed block types whitelist, duotone disable |
| `inc/acf.php` | ACF helpers, Options Page registration |
| `inc/woocommerce.php` | WC wrapper swap, breadcrumb integration |
| `inc/multilang.php` | hreflang tags, `st_language_switcher()` |
| `inc/helpers.php` | `st_responsive_image()`, `st_svg()`, `st_pagination()` |
| `assets/src/css/app.css` | Tailwind layers + WP alignment + component classes |
| `assets/src/css/editor.css` | Block editor mirror styles (no Preflight) |
| `assets/src/css/woocommerce.css` | WooCommerce UI overrides |
| `theme.json` | Design token source of truth — color palette, font sizes, layout widths |
| `phpcs.xml` | PHPCS config — WordPress Coding Standards, `st_` prefix |
| `phpstan.neon` | PHPStan level 5 config with WordPress extension |
| `acf-json/` | ACF field group JSON sync (auto-saved by ACF Pro) |
| `languages/` | Translation files — `.pot` tracked, `.po`/`.mo` excluded from git |

## Deployment

### GitHub Actions

- **CI** (`.github/workflows/ci.yml`) — runs on every push/PR: PHP syntax + PHPCS, PHPStan, ESLint + Prettier check, Vite build
- **Deploy** (`.github/workflows/deploy.yml`) — manual trigger; builds assets and deploys via rsync over SSH to staging or production

Required GitHub Secrets per environment (staging/production):

| Secret | Description |
|--------|-------------|
| `STAGING_SSH_HOST` | Server hostname |
| `STAGING_SSH_USER` | SSH user |
| `STAGING_SSH_PORT` | SSH port (default 22) |
| `STAGING_SSH_KEY` | Private key content (ed25519 recommended) |
| `STAGING_DEPLOY_PATH` | Absolute path to theme on server |

See `.env.example` for the full list. Mirror the same set for `PRODUCTION_*`.

### Pre-deploy checklist

- [ ] `npm run build` — `dist/` generated, `.vite-dev` removed
- [ ] `define('DISALLOW_FILE_EDIT', true)` in `wp-config.php`
- [ ] `define('ST_GTM_ID', 'GTM-XXXXXXX')` in `wp-config.php`
- [ ] Yoast SEO or RankMath activated (SEO meta auto-defers)
- [ ] Permalink structure set to `/%postname%/`
- [ ] `.htaccess` / Nginx cache headers configured
- [ ] Compiled `.mo` translation files included in deploy

## Using as a project base

**GitHub Template** (recommended): use the `Use this template` button — creates a new repo with clean history.

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
| Cookiebot / CookieYes | Consent Mode v2 update via GTM template or direct integration |
