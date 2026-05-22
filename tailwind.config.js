/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './**/*.php',
    '!./node_modules/**',
    '!./dist/**',
    './assets/src/js/**/*.js',
  ],
  theme: {
    extend: {
      colors: {
        primary:        'var(--wp--preset--color--primary, #2563eb)',
        'primary-dark': 'var(--wp--preset--color--primary-dark, #1d4ed8)',
        secondary:      'var(--wp--preset--color--secondary, #7c3aed)',
        'neutral-900':  'var(--wp--preset--color--neutral-900, #111827)',
        'neutral-600':  'var(--wp--preset--color--neutral-600, #4b5563)',
        'neutral-100':  'var(--wp--preset--color--neutral-100, #f3f4f6)',
      },
      typography: (theme) => ({
        DEFAULT: {
          css: {
            maxWidth: 'none',
            color: theme('colors.gray.900'),
            a: {
              color: 'var(--wp--preset--color--primary, #2563eb)',
              '&:hover': {
                color: 'var(--wp--preset--color--primary, #2563eb)',
              },
            },
          },
        },
      }),
    },
  },
  plugins: [
    require('@tailwindcss/typography'),
    require('@tailwindcss/forms'),
  ],
};
