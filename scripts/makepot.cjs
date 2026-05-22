/**
 * Generates a .pot translation template from all PHP files in the theme.
 * Run: npm run makepot
 */
const wpPot = require('wp-pot');
const fs = require('fs');

fs.mkdirSync('languages', { recursive: true });

wpPot({
    src: ['*.php', 'inc/**/*.php', 'templates/**/*.php', 'template-parts/**/*.php'],
    destFile: 'languages/starter-theme.pot',
    domain: 'starter-theme',
    package: 'Starter Theme',
    lastTranslator: '',
    team: '',
});

console.log('Generated: languages/starter-theme.pot');
