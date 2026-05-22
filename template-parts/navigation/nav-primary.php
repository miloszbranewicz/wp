<?php
defined('ABSPATH') || exit;
if (! has_nav_menu('primary')) {
    return;
}
?>
<nav id="site-navigation" aria-label="<?php esc_attr_e('Primary Menu', 'starter-theme'); ?>" class="hidden md:flex items-center gap-6">
    <?php wp_nav_menu([
        'theme_location' => 'primary',
        'menu_class'     => 'flex items-center gap-6 text-sm font-medium text-gray-700',
        'container'      => false,
        'depth'          => 2,
        'fallback_cb'    => false,
    ]); ?>
</nav>

<button
    type="button"
    id="mobile-menu-toggle"
    aria-controls="mobile-menu"
    aria-expanded="false"
    class="md:hidden p-2 rounded text-gray-700 hover:text-primary focus:outline-none focus:ring-2 focus:ring-primary"
    aria-label="<?php esc_attr_e('Toggle navigation', 'starter-theme'); ?>"
>
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
    </svg>
</button>

<div id="mobile-menu" class="hidden absolute top-16 inset-x-0 bg-white shadow-lg md:hidden z-50">
    <?php wp_nav_menu([
        'theme_location' => 'primary',
        'menu_class'     => 'flex flex-col divide-y divide-gray-100 text-sm font-medium text-gray-700',
        'container'      => false,
        'depth'          => 2,
        'fallback_cb'    => false,
    ]); ?>
</div>
