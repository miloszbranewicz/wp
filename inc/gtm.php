<?php
defined('ABSPATH') || exit;

// Google Tag Manager integration with Consent Mode v2 (required for GA4/Ads in EU, March 2024+).
//
// Setup: add to wp-config.php per project:
//   define('ST_GTM_ID', 'GTM-XXXXXXX');
//
// Consent Mode v2 defaults all consent states to 'denied'. Your consent management
// platform (Cookiebot, CookieYes, or custom) must call:
//   gtag('consent', 'update', { analytics_storage: 'granted', ... })
// after the user accepts. Both Cookiebot and CookieYes support this natively
// via their GTM template or direct integration.
//
// To disable Consent Mode and load GTM unconditionally (non-EU / no CMP):
//   define('ST_GTM_CONSENT_MODE', false);  // default: true

if (! defined('ST_GTM_ID') || ! ST_GTM_ID) {
    return;
}

$st_gtm_consent_mode = ! defined('ST_GTM_CONSENT_MODE') || ST_GTM_CONSENT_MODE;

// Consent Mode v2 defaults — output BEFORE GTM script
if ($st_gtm_consent_mode) {
    add_action('wp_head', function (): void {
        ?>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('consent', 'default', {
    ad_storage:             'denied',
    ad_user_data:           'denied',
    ad_personalization:     'denied',
    analytics_storage:      'denied',
    functionality_storage:  'denied',
    personalization_storage:'denied',
    security_storage:       'granted',
    wait_for_update:        500
});
</script>
        <?php
    }, 0); // priority 0 — before GTM snippet at priority 1
}

// GTM snippet in <head>
add_action('wp_head', function (): void {
    $id = esc_js(ST_GTM_ID);
    ?>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','<?php echo $id; ?>');</script>
<!-- End Google Tag Manager -->
    <?php
}, 1);

// GTM noscript — immediately after <body> via wp_body_open (WP 5.2+)
add_action('wp_body_open', function (): void {
    $id = esc_attr(ST_GTM_ID);
    echo "<!-- Google Tag Manager (noscript) -->\n";
    echo "<noscript><iframe src=\"https://www.googletagmanager.com/ns.html?id={$id}\" height=\"0\" width=\"0\" style=\"display:none;visibility:hidden\"></iframe></noscript>\n";
    echo "<!-- End Google Tag Manager (noscript) -->\n";
}, 1);
