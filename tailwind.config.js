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
        primary: 'var(--wp--preset--color--primary, #2563eb)',
        secondary: 'var(--wp--preset--color--secondary, #7c3aed)',
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
