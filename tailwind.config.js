/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ['./index.html', './src/**/*.{vue,js,ts,jsx,tsx}'],
  purge: ['./index.html', './src/**/*.{vue,js,ts,jsx,tsx}'],
  theme: {
    extend: {},
    container: {
      center: true,
    },
    screens: {
      'sm': '640px',
      'md': '640px',
      'lg': '640px',
      'xl': '640px',
      '2xl': '640px'
    }
  },
  plugins: [],
}

