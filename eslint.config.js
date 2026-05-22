import js from '@eslint/js';

export default [
    js.configs.recommended,
    {
        files: ['assets/src/js/**/*.js'],
        languageOptions: {
            ecmaVersion: 2022,
            sourceType: 'module',
            globals: {
                window:   'readonly',
                document: 'readonly',
                wp:       'readonly',
            },
        },
        rules: {
            'no-console':    'warn',
            'no-unused-vars': 'warn',
            'prefer-const':  'error',
        },
    },
    {
        ignores: ['dist/**', 'node_modules/**'],
    },
];
