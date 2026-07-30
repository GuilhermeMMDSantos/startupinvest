/** @type {import('tailwindcss').Config} */
export default {
  content: ['./index.html', './src/**/*.{js,ts,jsx,tsx}'],
  theme: {
    extend: {
      colors: {
        brand: {
          50: '#eef7ff',
          100: '#d9edff',
          200: '#bce0ff',
          300: '#8ecdff',
          400: '#59b0ff',
          500: '#2f8fff',
          600: '#1a6ff5',
          700: '#1558e0',
          800: '#1747b5',
          900: '#193f8e',
        },
      },
    },
  },
  plugins: [],
};
