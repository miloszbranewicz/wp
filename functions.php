<?php
defined('ABSPATH') || exit;

foreach ([
    'inc/setup.php',
    'inc/enqueue.php',
    'inc/helpers.php',
    'inc/performance.php',
    'inc/seo.php',
    'inc/blocks.php',
    'inc/acf.php',
    'inc/woocommerce.php',
    'inc/multilang.php',
    'inc/security.php',
    'inc/gtm.php',
] as $file) {
    require_once get_template_directory() . '/' . $file;
}
